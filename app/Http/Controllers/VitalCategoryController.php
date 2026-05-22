<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVitalCategoryRequest;
use App\Http\Requests\UpdateVitalCategoryRequest;
use App\Models\VitalCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class VitalCategoryController extends Controller
{
    // ─────────────────────────────────────────────
    // Index – list all categories
    // ─────────────────────────────────────────────

    /**
     * Display the vital categories listing page with summary stats.
     */
    public function index(): View
    {
        $stats = [
            'total'    => VitalCategory::count(),
            'active'   => VitalCategory::active()->count(),
            'inactive' => VitalCategory::inactive()->count(),
        ];

        return view('vital-categories.index', compact('stats'));
    }

    // ─────────────────────────────────────────────
    // DataTables – server-side data endpoint
    // ─────────────────────────────────────────────

    /**
     * Return paginated, searchable, sortable data for DataTables.
     * Uses collection-based DataTables (MongoDB compatible).
     */
    public function data(Request $request): JsonResponse
    {
        try {
            $draw   = (int) $request->input('draw', 1);
            $start  = (int) $request->input('start', 0);
            $length = (int) $request->input('length', 25);
            $search = $request->input('search.value', '');
            $orderColumnIndex = (int) $request->input('order.0.column', 0);
            $orderDir = $request->input('order.0.dir', 'asc');

            $columns = ['', 'name', 'description', 'status', 'created_at', ''];

            // Base query
            $query = VitalCategory::query();

            // Global search across name, description, status
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
                });
            }

            $recordsTotal    = VitalCategory::count();
            $recordsFiltered = $query->count();

            // Sorting
            $orderColumn = $columns[$orderColumnIndex] ?? 'created_at';
            if ($orderColumn) {
                $query->orderBy($orderColumn, $orderDir);
            }

            // Pagination
            $items = $query->skip($start)->take($length)->get();

            // Build rows
            $data = $items->map(function ($row, $index) use ($start) {
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
                $emoji = $iconMap[$row->icon] ?? '📋';

                $editUrl   = route('vital-categories.edit',    $row->id);
                $deleteUrl = route('vital-categories.destroy', $row->id);

                $statusBadge = $row->status === 'active'
                    ? '<span class="status-badge status-active">Active</span>'
                    : '<span class="status-badge status-inactive">Inactive</span>';

                $actions = view('vital-categories._actions', [
                    'row'       => $row,
                    'editUrl'   => $editUrl,
                    'deleteUrl' => $deleteUrl,
                ])->render();

                $createdAt = $row->created_at
                    ? $row->created_at->format('M d, Y H:i')
                    : '—';

                return [
                    'DT_RowIndex'  => $start + $index + 1,
                    'name'         => "<div class='flex items-center gap-2.5'>
                                        <span class='w-8 h-8 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-base'>{$emoji}</span>
                                        <span class='font-semibold text-gray-800'>{$row->name}</span>
                                    </div>",
                    'description'  => $row->description ?? '—',
                    'status_badge' => $statusBadge,
                    'created_at'   => $createdAt,
                    'actions'      => $actions,
                ];
            });

            return response()->json([
                'draw'            => $draw,
                'recordsTotal'    => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data'            => $data,
            ]);

        } catch (\Exception $e) {
            Log::error('VitalCategory DataTable error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────
    // Create – show form
    // ─────────────────────────────────────────────

    /**
     * Show the form to create a new vital category.
     */
    public function create(): View
    {
        return view('vital-categories.create');
    }

    // ─────────────────────────────────────────────
    // Store – save new record
    // ─────────────────────────────────────────────

    /**
     * Validate and persist a new vital category inside a DB transaction.
     */
    public function store(StoreVitalCategoryRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            VitalCategory::create([
                'name'        => $request->name,
                'icon'        => $request->icon,
                'description' => $request->description,
                'status'      => $request->status,
                'created_by'  => auth()->id(),
            ]);

            DB::commit();

            return redirect()
                ->route('vital-categories.index')
                ->with('success', 'Vital category created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('VitalCategory store error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Failed to create category. Please try again.');
        }
    }

    // ─────────────────────────────────────────────
    // Edit – show edit form
    // ─────────────────────────────────────────────

    /**
     * Show the form to edit an existing vital category.
     */
    public function edit(VitalCategory $vitalCategory): View
    {
        return view('vital-categories.edit', compact('vitalCategory'));
    }

    // ─────────────────────────────────────────────
    // Update – save changes
    // ─────────────────────────────────────────────

    /**
     * Validate and update an existing vital category inside a DB transaction.
     */
    public function update(UpdateVitalCategoryRequest $request, VitalCategory $vitalCategory): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $vitalCategory->update([
                'name'        => $request->name,
                'icon'        => $request->icon,
                'description' => $request->description,
                'status'      => $request->status,
            ]);

            DB::commit();

            return redirect()
                ->route('vital-categories.index')
                ->with('success', 'Vital category updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('VitalCategory update error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Failed to update category. Please try again.');
        }
    }

    // ─────────────────────────────────────────────
    // Destroy – delete record
    // ─────────────────────────────────────────────

    /**
     * Delete a vital category inside a DB transaction.
     */
    public function destroy(VitalCategory $vitalCategory): JsonResponse
    {
        try {
            DB::beginTransaction();

            $vitalCategory->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('VitalCategory destroy error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category.',
            ], 500);
        }
    }
}
