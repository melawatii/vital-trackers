<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVitalCategoryRequest;
use App\Http\Requests\UpdateVitalCategoryRequest;
use App\Models\VitalCategory;
use App\Models\VitalType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

/**
 * Controller responsible for managing vital categories CRUD operations and DataTables.
 */
class VitalCategoryController extends Controller
{
    /**
     * Display the vital categories listing page with summary statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Calculate summary statistics for the index view
        $stats = [
            'total'    => VitalCategory::count(),
            'active'   => VitalCategory::active()->count(),
            'inactive' => VitalCategory::inactive()->count(),
            'types'    => VitalType::count(),
        ];

        return view('vital-categories.index', compact('stats'));
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

        // Fetch all categories and map the data for DataTable consumption
        $categories = VitalCategory::latest()->get()->map(function ($row) use ($iconMap) {
            // Generate status badge HTML (Active / Inactive)
            $statusHtml = $row->status === 'active'
                ? '<span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;background:#f0fdf4;color:#15803d"><span style="width:6px;height:6px;border-radius:50%;background:#22c55e;display:inline-block"></span>Active</span>'
                : '<span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;background:#fffbeb;color:#d97706"><span style="width:6px;height:6px;border-radius:50%;background:#f59e0b;display:inline-block"></span>Inactive</span>';

            // Return formatted row data including rendered action buttons partial
            return [
                'id'          => (string) $row->id,
                'name'        => $row->name,
                'description' => $row->description,
                'icon_html'   => $iconMap[$row->icon] ?? '📋',
                'status_html' => $statusHtml,
                'actions'     => view('vital-categories._actions', [
                    'row'       => $row,
                    'editUrl'   => route('vital-categories.edit', $row->id),
                    'deleteUrl' => route('vital-categories.destroy', $row->id),
                ])->render(),
                'created_at'  => $row->created_at?->format('M d, Y H:i') ?? '-',
            ];
        });

        // Build and return the DataTables response with raw HTML columns
        return DataTables::of($categories)
            ->addIndexColumn()
            ->rawColumns(['status_html', 'actions'])
            ->make(true);
    }

    /**
     * Display the vital category creation form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('vital-categories.create');
    }

    /**
     * Store a newly created vital category in the database.
     * Note: DB::beginTransaction() is omitted as it is not fully supported by MongoDB.
     *
     * @param StoreVitalCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreVitalCategoryRequest $request)
    {
        try {
            // Create the category, automatically generating the slug from the name
            VitalCategory::create([
                'name'        => $request->name,
                'slug'        => Str::slug($request->name),
                'description' => $request->description,
                'icon'        => $request->icon,
                'status'      => $request->status,
                'created_by'  => auth()->id(),
            ]);

            // Redirect to index with success message
            return redirect()
                ->route('vital-categories.index')
                ->with('success', 'Category created successfully.');

        } catch (\Throwable $e) {
            // Log the error and redirect back with input and error message
            Log::error('VitalCategory store error', ['message' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    /**
     * Display the vital category edit form.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        // Find the category or fail with a 404 error
        $vitalCategory = VitalCategory::findOrFail($id);

        return view('vital-categories.edit', compact('vitalCategory'));
    }

    /**
     * Update the specified vital category in the database.
     * Note: DB::beginTransaction() is omitted as it is not fully supported by MongoDB.
     *
     * @param UpdateVitalCategoryRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateVitalCategoryRequest $request, string $id)
    {
        try {
            $category = VitalCategory::findOrFail($id);

            // Update the category, regenerating the slug in case the name changed
            $category->update([
                'name'        => $request->name,
                'slug'        => Str::slug($request->name),
                'description' => $request->description,
                'icon'        => $request->icon,
                'status'      => $request->status,
            ]);

            // Redirect to index with success message
            return redirect()
                ->route('vital-categories.index')
                ->with('success', 'Category updated successfully.');

        } catch (\Throwable $e) {
            // Log the error and redirect back with input and error message
            Log::error('VitalCategory update error', ['id' => $id, 'message' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified vital category from the database (AJAX request).
     * Note: DB::beginTransaction() is omitted as it is not fully supported by MongoDB.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        try {
            // Find and delete the category
            VitalCategory::findOrFail($id)->delete();

            // Return JSON success response for AJAX handling
            return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);

        } catch (\Throwable $e) {
            // Log the error and return JSON error response
            Log::error('VitalCategory destroy error', ['id' => $id, 'message' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => 'Failed to delete category.'], 500);
        }
    }
}