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

class VitalCategoryController extends Controller
{
    /**
     * Display vital categories listing with stats.
     */
    public function index()
    {
        $stats = [
            'total'    => VitalCategory::count(),
            'active'   => VitalCategory::active()->count(),
            'inactive' => VitalCategory::inactive()->count(),
            'types'    => VitalType::count(),
        ];

        return view('vital-categories.index', compact('stats'));
    }

    /**
     * Server-side DataTable endpoint.
     * Uses Collection DataTables — MongoDB does not support toSql() (Query DataTables).
     */
    public function datatable(Request $request)
    {
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

        $categories = VitalCategory::latest()->get()->map(function ($row) use ($iconMap) {
            return [
                'id'          => (string) $row->id,
                'name'        => $row->name,
                'description' => $row->description,
                'icon_html'   => $iconMap[$row->icon] ?? '📋',
                'status_html' => $row->status === 'active'
                    ? '<span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;background:#f0fdf4;color:#15803d"><span style="width:6px;height:6px;border-radius:50%;background:#22c55e;display:inline-block"></span>Active</span>'
                    : '<span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;background:#fffbeb;color:#d97706"><span style="width:6px;height:6px;border-radius:50%;background:#f59e0b;display:inline-block"></span>Inactive</span>',
                'actions'     => view('vital-categories._actions', [
                    'row'       => $row,
                    'editUrl'   => route('vital-categories.edit', $row->id),
                    'deleteUrl' => route('vital-categories.destroy', $row->id),
                ])->render(),
                'created_at'  => $row->created_at?->format('M d, Y H:i') ?? '-',
            ];
        });

        return DataTables::of($categories)
            ->addIndexColumn()
            ->rawColumns(['status_html', 'actions'])
            ->make(true);
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('vital-categories.create');
    }

    /**
     * Store a new vital category.
     * Note: DB::beginTransaction() is not supported by MongoDB — omitted intentionally.
     */
    public function store(StoreVitalCategoryRequest $request)
    {
        try {
            VitalCategory::create([
                'name'        => $request->name,
                'slug'        => Str::slug($request->name),
                'description' => $request->description,
                'icon'        => $request->icon,
                'status'      => $request->status,
                'created_by'  => auth()->id(),
            ]);

            return redirect()
                ->route('vital-categories.index')
                ->with('success', 'Category created successfully.');

        } catch (\Throwable $e) {
            Log::error('VitalCategory store error', ['message' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    /**
     * Show edit form.
     */
    public function edit(string $id)
    {
        $vitalCategory = VitalCategory::findOrFail($id);
        return view('vital-categories.edit', compact('vitalCategory'));
    }

    /**
     * Update vital category.
     * Note: DB::beginTransaction() is not supported by MongoDB — omitted intentionally.
     */
    public function update(UpdateVitalCategoryRequest $request, string $id)
    {
        try {
            $category = VitalCategory::findOrFail($id);
            $category->update([
                'name'        => $request->name,
                'slug'        => Str::slug($request->name),
                'description' => $request->description,
                'icon'        => $request->icon,
                'status'      => $request->status,
            ]);

            return redirect()
                ->route('vital-categories.index')
                ->with('success', 'Category updated successfully.');

        } catch (\Throwable $e) {
            Log::error('VitalCategory update error', ['id' => $id, 'message' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    /**
     * Delete vital category (AJAX).
     * Note: DB::beginTransaction() is not supported by MongoDB — omitted intentionally.
     */
    public function destroy(string $id)
    {
        try {
            VitalCategory::findOrFail($id)->delete();

            return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);

        } catch (\Throwable $e) {
            Log::error('VitalCategory destroy error', ['id' => $id, 'message' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => 'Failed to delete category.'], 500);
        }
    }
}
