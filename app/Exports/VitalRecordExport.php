<?php

namespace App\Exports;

use App\Models\User;
use App\Models\VitalCategory;
use App\Models\VitalRecord;
use App\Models\VitalType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * Export class for Vital Records.
 * Supports optional filters (category, type, status, date range) passed from the controller.
 * Used by both Excel (.xlsx) and CSV export routes via Maatwebsite\Excel.
 */
class VitalRecordsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle, WithEvents
{
    protected array $filters;
    protected Collection $categoriesMap;
    protected Collection $typesMap;
    protected Collection $usersMap;

    /**
     * @param array $filters Optional filters: category_id, type_id, status, date_from, date_to
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;

        // Preload related data to avoid N+1 lookups while mapping rows
        $this->categoriesMap = VitalCategory::all()->keyBy('id');
        $this->typesMap      = VitalType::all()->keyBy('id');
        $this->usersMap      = User::all()->keyBy('id');
    }

    /**
     * Build the filtered collection of vital records to export.
     * MongoDB collections are queried directly here (no toSql() dependency).
     */
    public function collection()
    {
        $query = VitalRecord::query()->orderBy('recorded_at', 'desc');

        if (!empty($this->filters['category_id'])) {
            $query->where('category_id', $this->filters['category_id']);
        }

        if (!empty($this->filters['type_id'])) {
            $query->where('type_id', $this->filters['type_id']);
        }

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['date_from'])) {
            $query->where('recorded_at', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->where('recorded_at', '<=', $this->filters['date_to']);
        }

        return $query->get();
    }

    /**
     * Column headings for the export sheet.
     */
    public function headings(): array
    {
        return [
            '#',
            'Date & Time',
            'User',
            'Category',
            'Type',
            'Value',
            'Unit',
            'Normal Range',
            'Status',
            'Note',
        ];
    }

    /**
     * Map each VitalRecord row to a flat array matching the headings order.
     */
    public function map($row): array
    {
        static $index = 0;
        $index++;

        $category = $this->categoriesMap->get((string) $row->category_id);
        $type     = $this->typesMap->get((string) $row->type_id);
        $user     = $this->usersMap->get((string) $row->user_id);

        $normalRange = ($type && $type->normal_range_min !== null && $type->normal_range_max !== null)
            ? $type->normal_range_min . ' - ' . $type->normal_range_max
            : '-';

        return [
            $index,
            $row->recorded_at?->format('Y-m-d H:i') ?? '-',
            $user?->name ?? 'Unknown',
            $category?->name ?? '-',
            $type?->name ?? '-',
            $row->value,
            $row->unit ?? '-',
            $normalRange,
            $row->status === 'normal' ? 'Normal' : 'High / Low',
            $row->note ?? '',
        ];
    }

    /**
     * Sheet tab title.
     */
    public function title(): string
    {
        return 'Vital Records';
    }

    /**
     * Fixed column widths for readability.
     */
    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 18,
            'C' => 20,
            'D' => 16,
            'E' => 18,
            'F' => 10,
            'G' => 10,
            'H' => 16,
            'I' => 14,
            'J' => 30,
        ];
    }

    /**
     * Style the header row — bold white text on a blue background.
     */
    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2563EB'],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            ],
        ];
    }

    /**
     * Post-render formatting: freeze header row, add borders, and zebra-stripe rows.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet      = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestCol = $sheet->getHighestColumn();

                // Freeze header row so it stays visible while scrolling
                $sheet->freezePane('A2');

                // Apply thin borders to the whole data range
                $sheet->getStyle("A1:{$highestCol}{$highestRow}")->getBorders()
                    ->getAllBorders()->setBorderStyle(Border::BORDER_THIN)
                    ->getColor()->setRGB('E2E8F0');

                // Row height for header
                $sheet->getRowDimension(1)->setRowHeight(22);

                // Zebra striping for readability (skip header row)
                for ($row = 2; $row <= $highestRow; $row++) {
                    if ($row % 2 === 0) {
                        $sheet->getStyle("A{$row}:{$highestCol}{$row}")
                            ->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('F8FAFC');
                    }
                }

                // Center-align the index, value, unit, and status columns
                $sheet->getStyle("A2:A{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("F2:I{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
