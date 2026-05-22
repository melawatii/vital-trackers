<?php

namespace App\Exports;

use App\Models\VitalRecord;

use Maatwebsite\Excel\Concerns\FromCollection;

/**
 * Export vital records into excel file.
 */
class VitalRecordExport implements FromCollection
{
    /**
     * Return export collection.
     */
    public function collection()
    {
        /**
         * Build query.
         */
        $query = VitalRecord::query();

        /**
         * Restrict user access.
         */
        if (auth()->user()->role === 'user') {

            $query->where(
                'user_id',
                (string) auth()->user()->_id
            );
        }

        return $query
            ->latest()
            ->get();
    }
}