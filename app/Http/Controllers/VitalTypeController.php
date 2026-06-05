<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVitalTypeRequest;
use App\Http\Requests\UpdateVitalTypeRequest;
use App\Models\VitalCategory;
use App\Models\VitalType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class VitalTypeController extends Controller
{
    /**
     * Display vital types listing with stats.
     */
    public function index()
    {
        $stats = [
            'total'    => VitalType::count(),
            'active'   => VitalType::active()->count(),
            'inactive' => VitalType::inactive()->count(),
            'numeric'  => VitalType::numeric()->count(),
        ];

        return view('vital-types.index', compact('stats'));
    }

    /**
     * Server-side DataTable endpoint.
     * Uses Collection DataTables — MongoDB does not support toSql() (Query DataTables).
     */
    public function datatable(Request $request)
    {
        // Icon map from VitalCategory for displaying icons
        $iconMap = [
            'droplet'     => '💧',
            'heart'       => '💚',
            'thermometer' => '🌡️',
            'blooddrop'   => '🩸',
            'lungs'       => '🫁',
            'scale'       => '⚖️',
            'oxygen'      => '🫧',
            'brain'       => '🧠',
        ];

        // Eager-load categories into a keyed map to avoid N+1 queries
        $categoriesMap = VitalCategory::all()->keyBy('id');

        $types = VitalType::orderBy('sort_order')->orderBy('created_at', 'desc')->get()
            ->map(function ($row) use ($iconMap, $categoriesMap) {
                $category = $categoriesMap->get((string) $row->category_id);

                // Normal range display
                $range = ($row->normal_range_min !== null && $row->normal_range_max !== null)
                    ? $row->normal_range_min . ' - ' . $row->normal_range_max
                    : '-';

                // Input type badge
                $inputBadge = '<span style="display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;background:#eff6ff;color:#2563eb">'
                    . ucfirst($row->input_type ?? 'number') . '</span>';

                // Status badge
                $statusBadge = $row->status === 'active'
                    ? '<span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;background:#f0fdf4;color:#15803d"><span style="width:6px;height:6px;border-radius:50%;background:#22c55e;display:inline-block"></span>Active</span>'
                    : '<span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;background:#fffbeb;color:#d97706"><span style="width:6px;height:6px;border-radius:50%;background:#f59e0b;display:inline-block"></span>Inactive</span>';

                // Name with category icon
                $icon = $category ? ($iconMap[$category->icon] ?? '📋') : '📋';
                $nameHtml = '<div style="display:flex;align-items:center;gap:10px">'
                    . '<div style="width:34px;height:34px;border-radius:10px;border:1.5px solid #f1f5f9;background:#f8fafc;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0">' . $icon . '</div>'
                    . '<span style="font-weight:600;color:#0f172a">' . e($row->name) . '</span>'
                    . '</div>';

                return [
                    'id'           => (string) $row->id,
                    'name_html'    => $nameHtml,
                    'category'     => $category ? e($category->name) : '-',
                    'input_badge'  => $inputBadge,
                    'unit'         => e($row->unit ?? '-'),
                    'normal_range' => $range,
                    'status_html'  => $statusBadge,
                    'actions'      => view('vital-types._actions', [
                        'row'       => $row,
                        'editUrl'   => route('vital-types.edit', $row->id),
                        'deleteUrl' => route('vital-types.destroy', $row->id),
                    ])->render(),
                ];
            });

        return DataTables::of($types)
            ->addIndexColumn()
            ->rawColumns(['name_html', 'input_badge', 'status_html', 'actions'])
            ->make(true);
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $categories = VitalCategory::active()->orderBy('name')->get();
        return view('vital-types.create', compact('categories'));
    }

    /**
     * Store a new vital type.
     * Note: DB::beginTransaction() not supported by MongoDB — omitted intentionally.
     */
    public function store(StoreVitalTypeRequest $request)
    {
        try {
            VitalType::create([
                'name'             => $request->name,
                'slug'             => $request->slug ? Str::slug($request->slug) : Str::slug($request->name),
                'category_id'      => $request->category_id,
                'input_type'       => $request->input_type,
                'unit'             => $request->unit,
                'min_value'        => (float) $request->min_value,
                'max_value'        => (float) $request->max_value,
                'normal_range_min' => (float) $request->normal_range_min,
                'normal_range_max' => (float) $request->normal_range_max,
                'sort_order'       => (int) ($request->sort_order ?? 0),
                'note'             => $request->note,
                'status'           => $request->status,
                'created_by'       => auth()->id(),
            ]);

            return redirect()
                ->route('vital-types.index')
                ->with('success', 'Vital type created successfully.');

        } catch (\Throwable $e) {
            Log::error('VitalType store error', ['message' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Failed to create vital type: ' . $e->getMessage());
        }
    }

    /**
     * Show edit form.
     */
    public function edit(string $id)
    {
        $vitalType  = VitalType::findOrFail($id);
        $categories = VitalCategory::active()->orderBy('name')->get();
        return view('vital-types.edit', compact('vitalType', 'categories'));
    }

    /**
     * Update vital type.
     * Note: DB::beginTransaction() not supported by MongoDB — omitted intentionally.
     */
    public function update(UpdateVitalTypeRequest $request, string $id)
    {
        try {
            $type = VitalType::findOrFail($id);
            $type->update([
                'name'             => $request->name,
                'slug'             => $request->slug ? Str::slug($request->slug) : Str::slug($request->name),
                'category_id'      => $request->category_id,
                'input_type'       => $request->input_type,
                'unit'             => $request->unit,
                'min_value'        => (float) $request->min_value,
                'max_value'        => (float) $request->max_value,
                'normal_range_min' => (float) $request->normal_range_min,
                'normal_range_max' => (float) $request->normal_range_max,
                'sort_order'       => (int) ($request->sort_order ?? 0),
                'note'             => $request->note,
                'status'           => $request->status,
            ]);

            return redirect()
                ->route('vital-types.index')
                ->with('success', 'Vital type updated successfully.');

        } catch (\Throwable $e) {
            Log::error('VitalType update error', ['id' => $id, 'message' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Failed to update vital type: ' . $e->getMessage());
        }
    }

    /**
     * Delete vital type (AJAX).
     * Note: DB::beginTransaction() not supported by MongoDB — omitted intentionally.
     */
    public function destroy(string $id)
    {
        try {
            VitalType::findOrFail($id)->delete();

            return response()->json(['success' => true, 'message' => 'Vital type deleted successfully.']);

        } catch (\Throwable $e) {
            Log::error('VitalType destroy error', ['id' => $id, 'message' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => 'Failed to delete vital type.'], 500);
        }
    }
}
