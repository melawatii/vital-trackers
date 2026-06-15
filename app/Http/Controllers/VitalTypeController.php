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

/**
 * Controller responsible for managing vital types CRUD operations and DataTables.
 */
class VitalTypeController extends Controller
{
    /**
     * Display the vital types listing page with summary statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Calculate summary statistics for the index view
        $stats = [
            'total'    => VitalType::count(),
            'active'   => VitalType::active()->count(),
            'inactive' => VitalType::inactive()->count(),
            'numeric'  => VitalType::numeric()->count(),
        ];

        return view('vital-types.index', compact('stats'));
    }

    /**
     * Handle server-side DataTable AJAX request.
     * Uses Collection DataTables since MongoDB does not support query builder methods like toSql().
     *
     * @param Request $request
     * @return mixed
     */
    public function datatable(Request $request)
    {
        // Map icon keys to their respective emoji representations
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

        // Eager-load categories into a keyed collection to prevent N+1 query issues in the loop
        $categoriesMap = VitalCategory::all()->keyBy('id');

        // Fetch all types and map the data for DataTable consumption
        $types = VitalType::orderBy('sort_order')->orderBy('created_at', 'desc')->get()
            ->map(function ($row) use ($iconMap, $categoriesMap) {
                // Retrieve the related category from the preloaded map
                $category = $categoriesMap->get((string) $row->category_id);

                // Format the normal range display string
                $range = ($row->normal_range_min !== null && $row->normal_range_max !== null)
                    ? $row->normal_range_min . ' - ' . $row->normal_range_max
                    : '-';

                // Generate input type badge HTML
                $inputBadge = '<span style="display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;background:#eff6ff;color:#2563eb">'
                    . ucfirst($row->input_type ?? 'number') . '</span>';

                // Generate status badge HTML (Active / Inactive)
                $statusBadge = $row->status === 'active'
                    ? '<span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;background:#f0fdf4;color:#15803d"><span style="width:6px;height:6px;border-radius:50%;background:#22c55e;display:inline-block"></span>Active</span>'
                    : '<span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;background:#fffbeb;color:#d97706"><span style="width:6px;height:6px;border-radius:50%;background:#f59e0b;display:inline-block"></span>Inactive</span>';

                // Generate name HTML with the category icon
                $icon     = $category ? ($iconMap[$category->icon] ?? '📋') : '📋';
                $nameHtml = '<div style="display:flex;align-items:center;gap:10px">'
                    . '<div style="width:34px;height:34px;border-radius:10px;border:1.5px solid #f1f5f9;background:#f8fafc;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0">' . $icon . '</div>'
                    . '<span style="font-weight:600;color:#0f172a">' . e($row->name) . '</span>'
                    . '</div>';

                // Return formatted row data including rendered action buttons partial
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

        // Build and return the DataTables response with raw HTML columns
        return DataTables::of($types)
            ->addIndexColumn()
            ->rawColumns(['name_html', 'input_badge', 'status_html', 'actions'])
            ->make(true);
    }

    /**
     * Display the vital type creation form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Fetch active categories for the dropdown selection
        $categories = VitalCategory::active()->orderBy('name')->get();

        return view('vital-types.create', compact('categories'));
    }

    /**
     * Store a newly created vital type in the database.
     * Note: DB::beginTransaction() is omitted as it is not fully supported by MongoDB.
     *
     * @param StoreVitalTypeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreVitalTypeRequest $request)
    {
        try {
            // Create the type, generating the slug from the name if a custom slug isn't provided
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

            // Redirect to index with success message
            return redirect()
                ->route('vital-types.index')
                ->with('success', 'Vital type created successfully.');

        } catch (\Throwable $e) {
            // Log the error and redirect back with input and error message
            Log::error('VitalType store error', ['message' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Failed to create vital type: ' . $e->getMessage());
        }
    }

    /**
     * Display the vital type edit form.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        // Find the type or fail with a 404 error
        $vitalType = VitalType::findOrFail($id);

        // Fetch active categories for the dropdown selection
        $categories = VitalCategory::active()->orderBy('name')->get();

        return view('vital-types.edit', compact('vitalType', 'categories'));
    }

    /**
     * Update the specified vital type in the database.
     * Note: DB::beginTransaction() is omitted as it is not fully supported by MongoDB.
     *
     * @param UpdateVitalTypeRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateVitalTypeRequest $request, string $id)
    {
        try {
            $type = VitalType::findOrFail($id);

            // Update the type, regenerating the slug from the name if a custom slug isn't provided
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

            // Redirect to index with success message
            return redirect()
                ->route('vital-types.index')
                ->with('success', 'Vital type updated successfully.');

        } catch (\Throwable $e) {
            // Log the error and redirect back with input and error message
            Log::error('VitalType update error', ['id' => $id, 'message' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Failed to update vital type: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified vital type from the database (AJAX request).
     * Note: DB::beginTransaction() is omitted as it is not fully supported by MongoDB.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        try {
            // Find and delete the type
            VitalType::findOrFail($id)->delete();

            // Return JSON success response for AJAX handling
            return response()->json(['success' => true, 'message' => 'Vital type deleted successfully.']);

        } catch (\Throwable $e) {
            // Log the error and return JSON error response
            Log::error('VitalType destroy error', ['id' => $id, 'message' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => 'Failed to delete vital type.'], 500);
        }
    }
}
