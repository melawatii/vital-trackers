<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVitalCategoryRequest;
use App\Http\Requests\UpdateVitalCategoryRequest;
use App\Models\VitalCategory;
use Illuminate\Support\Facades\DB;
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
            'types'    => 0, // Replace with VitalType::count() when available
        ];

        return view('vital-categories.index', compact('stats'));
    }

    /**
     * Server-side DataTable endpoint for vital categories.
     */
    public function datatable()
    {
        $query = VitalCategory::query();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('icon_html', function ($row) {
                // Map icon key to emoji for display
                $icons = [
                    'droplet'     => '💧',
                    'heart'       => '💚',
                    'thermometer' => '🌡️',
                    'blooddrop'   => '🩸',
                    'lungs'       => '🫁',
                    'scale'       => '⚖️',
                    'oxygen'      => '🫧',
                    'brain'       => '🧠',
                ];
                return $icons[$row->icon] ?? '📋';
            })
            ->addColumn('status_html', function ($row) {
                if ($row->status === 'active') {
                    return '<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span> Active
                            </span>';
                }
                return '<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 inline-block"></span> Inactive
                        </span>';
            })
            ->addColumn('actions', function ($row) {
                $editUrl   = route('vital-categories.edit', $row->id);
                $deleteUrl = route('vital-categories.destroy', $row->id);
                return view('vital-categories._actions', compact('row', 'editUrl', 'deleteUrl'))->render();
            })
            ->editColumn('created_at', fn($row) => $row->created_at?->format('M d, Y H:i') ?? '-')
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
     * Store a new vital category with DB transaction.
     */
    public function store(StoreVitalCategoryRequest $request)
    {
        try {
            DB::beginTransaction();

            VitalCategory::create([
                'name'        => $request->name,
                'slug'        => Str::slug($request->name),
                'description' => $request->description,
                'icon'        => $request->icon,
                'status'      => $request->status,
                'created_by'  => auth()->id(),
            ]);

            DB::commit();

            return redirect()
                ->route('vital-categories.index')
                ->with('success', 'Category created successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('VitalCategory store error', ['message' => $e->getMessage()]);

            return back()->withInput()->with('error', 'Failed to create category. Please try again.');
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
     * Update vital category with DB transaction.
     */
    public function update(UpdateVitalCategoryRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $category = VitalCategory::findOrFail($id);
            $category->update([
                'name'        => $request->name,
                'slug'        => Str::slug($request->name),
                'description' => $request->description,
                'icon'        => $request->icon,
                'status'      => $request->status,
            ]);

            DB::commit();

            return redirect()
                ->route('vital-categories.index')
                ->with('success', 'Category updated successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('VitalCategory update error', ['id' => $id, 'message' => $e->getMessage()]);

            return back()->withInput()->with('error', 'Failed to update category. Please try again.');
        }
    }

    /**
     * Delete vital category with DB transaction (AJAX).
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            VitalCategory::findOrFail($id)->delete();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('VitalCategory destroy error', ['id' => $id, 'message' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => 'Failed to delete category.'], 500);
        }
    }
}
