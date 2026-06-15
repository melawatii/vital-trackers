<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVitalRecordRequest;
use App\Http\Requests\UpdateVitalRecordRequest;
use App\Models\User;
use App\Models\VitalCategory;
use App\Models\VitalRecord;
use App\Models\VitalType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

/**
 * Controller responsible for managing vital records CRUD operations and DataTables.
 */
class VitalRecordController extends Controller
{
    /**
     * Display the vital records listing page with summary statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Calculate summary statistics for the index view
        $stats = [
            'total'        => VitalRecord::count(),
            'this_month'   => VitalRecord::thisMonth()->count(),
            'danger'       => VitalRecord::danger()->count(),
            'unique_users' => count(VitalRecord::distinct('user_id')->pluck('user_id')->toArray()),
        ];

        return view('vital-records.index', compact('stats'));
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

        // Map category icons to their respective background and text colors for badges
        $categoryColors = [
            'droplet'     => ['#eff6ff', '#1d4ed8'],
            'heart'       => ['#f0fdf4', '#15803d'],
            'thermometer' => ['#fefce8', '#a16207'],
            'blooddrop'   => ['#fff1f2', '#be123c'],
            'lungs'       => ['#eef2ff', '#4338ca'],
            'scale'       => ['#f8fafc', '#475569'],
            'oxygen'      => ['#ecfeff', '#0e7490'],
            'brain'       => ['#fdf4ff', '#7e22ce'],
        ];

        // Eager load related data into keyBy maps to prevent N+1 query issues in the loop
        $categoriesMap = VitalCategory::all()->keyBy('id');
        $typesMap      = VitalType::all()->keyBy('id');
        $usersMap      = User::all()->keyBy('id');

        // Fetch all records and map the data for DataTable consumption
        $records = VitalRecord::orderBy('recorded_at', 'desc')->get()
            ->map(function ($row) use ($iconMap, $categoryColors, $categoriesMap, $typesMap, $usersMap) {
                // Retrieve related models from the preloaded maps
                $category = $categoriesMap->get((string) $row->category_id);
                $type     = $typesMap->get((string) $row->type_id);
                $user     = $usersMap->get((string) $row->user_id);

                // Generate category badge HTML with icon and custom colors
                $icon       = $category ? ($iconMap[$category->icon] ?? '📋') : '📋';
                $colors     = $category ? ($categoryColors[$category->icon] ?? ['#f1f5f9', '#475569']) : ['#f1f5f9', '#475569'];
                $catBadge   = $category
                    ? '<span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;background:' . $colors[0] . ';color:' . $colors[1] . '">'
                      . $icon . ' ' . e($category->name)
                      . '</span>'
                    : '-';

                // Generate status badge HTML (Normal / High-Low)
                $statusBadge = match($row->status) {
                    'normal'   => '<span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;background:#f0fdf4;color:#15803d"><span style="width:6px;height:6px;border-radius:50%;background:#22c55e;display:inline-block"></span>Normal</span>',
                    'high_low' => '<span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;background:#fff1f2;color:#be123c"><span style="width:6px;height:6px;border-radius:50%;background:#ef4444;display:inline-block"></span>High</span>',
                    default    => '<span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;background:#f8fafc;color:#64748b">-</span>',
                };

                // Generate user avatar with initials and name HTML
                $userName = $user ? e($user->name) : 'Unknown';
                $initials = collect(explode(' ', $userName))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->join('');
                $userHtml = '<div style="display:flex;align-items:center;gap:8px">'
                    . '<div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#60a5fa,#2563eb);display:flex;align-items:center;justify-content:center;font-size:.65rem;font-weight:700;color:#fff;flex-shrink:0">' . $initials . '</div>'
                    . '<span style="font-weight:500;color:#374151">' . $userName . '</span>'
                    . '</div>';

                // Return formatted row data including rendered action buttons partial
                return [
                    'id'           => (string) $row->id,
                    'recorded_at'  => $row->recorded_at?->format('M d, Y') . '<br><span style="font-size:.72rem;color:#94a3b8">' . $row->recorded_at?->format('h:i A') . '</span>',
                    'user_html'    => $userHtml,
                    'category'     => $catBadge,
                    'type'         => $type ? e($type->name) : '-',
                    'value'        => '<span style="font-weight:600">' . e($row->value) . '</span>',
                    'unit'         => e($row->unit ?? '-'),
                    'status_html'  => $statusBadge,
                    'note'         => $row->note ? '<span style="color:#64748b">' . e(Str::limit($row->note, 30)) . '</span>' : '<span style="color:#cbd5e1">-</span>',
                    'actions'      => view('vital-records._actions', [
                        'row'       => $row,
                        'showUrl'   => route('vital-records.show', $row->id),
                        'editUrl'   => route('vital-records.edit', $row->id),
                        'deleteUrl' => route('vital-records.destroy', $row->id),
                    ])->render(),
                ];
            });

        // Build and return the DataTables response with raw HTML columns
        return DataTables::of($records)
            ->addIndexColumn()
            ->rawColumns(['recorded_at', 'user_html', 'category', 'value', 'status_html', 'note', 'actions'])
            ->make(true);
    }

    /**
     * Get vital types by category (AJAX) — used for cascading dropdowns in forms.
     *
     * @param string $categoryId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTypesByCategory(string $categoryId)
    {
        // Fetch active types for the specified category
        $types = VitalType::where('category_id', $categoryId)->active()->orderBy('name')->get()
            ->map(fn($t) => [
                'id'               => (string) $t->id,
                'name'             => $t->name,
                'unit'             => $t->unit,
                'normal_range_min' => $t->normal_range_min,
                'normal_range_max' => $t->normal_range_max,
            ]);

        return response()->json($types);
    }

    /**
     * Display the vital record creation form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Fetch active categories and types for the dropdowns
        $categories = VitalCategory::active()->orderBy('name')->get();
        $types = VitalType::active()->orderBy('name')->get();

        // Admins can assign records to any user, so pass all users for selection
        $users = [];
        if (auth()->check() && auth()->user()->role === 'admin') {
            $users = User::orderBy('name')->get();
        }

        return view('vital-records.create', compact('categories', 'types', 'users'));
    }

    /**
     * Store a newly created vital record in the database.
     * Note: DB::beginTransaction() is omitted as it is not fully supported by MongoDB.
     *
     * @param StoreVitalRecordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreVitalRecordRequest $request)
    {
        try {
            // Determine user_id: Admins can specify another user; regular users default to themselves
            $userId = auth()->user()->role === 'admin' && $request->user_id
                ? $request->user_id
                : auth()->id();

            VitalRecord::create([
                'user_id'     => $userId,
                'category_id' => $request->category_id,
                'type_id'     => $request->type_id,
                'value'       => (float) $request->value,
                'unit'        => $request->unit,
                'status'      => $request->status,
                'note'        => $request->note,
                'recorded_at' => $request->recorded_at,
            ]);

            // Redirect to index with success message
            return redirect()
                ->route('vital-records.index')
                ->with('success', 'Vital record saved successfully.');

        } catch (\Throwable $e) {
            // Log the error and redirect back with input and error message
            Log::error('VitalRecord store error', ['message' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Failed to save record: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified vital record details.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        // Find the record or fail with a 404 error, then retrieve related data for the view
        $record     = VitalRecord::findOrFail($id);
        $category   = VitalCategory::find($record->category_id);
        $type       = VitalType::find($record->type_id);
        $user       = User::find($record->user_id);

        return view('vital-records.show', compact('record', 'category', 'type', 'user'));
    }

    /**
     * Display the vital record edit form.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        // Find the record, and fetch active categories and types for the dropdowns
        $record     = VitalRecord::findOrFail($id);
        $categories = VitalCategory::active()->orderBy('name')->get();

        // Fetch types specific to the record's current category to populate the dependent dropdown
        $types      = VitalType::where('category_id', $record->category_id)->active()->orderBy('name')->get();

        return view('vital-records.edit', compact('record', 'categories', 'types'));
    }

    /**
     * Update the specified vital record in the database.
     * Note: DB::beginTransaction() is omitted as it is not fully supported by MongoDB.
     *
     * @param UpdateVitalRecordRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateVitalRecordRequest $request, string $id)
    {
        try {
            $record = VitalRecord::findOrFail($id);

            // Update the record with validated data, casting value to float
            $record->update([
                'category_id' => $request->category_id,
                'type_id'     => $request->type_id,
                'value'       => (float) $request->value,
                'unit'        => $request->unit,
                'status'      => $request->status,
                'note'        => $request->note,
                'recorded_at' => $request->recorded_at,
            ]);

            // Redirect to index with success message
            return redirect()
                ->route('vital-records.index')
                ->with('success', 'Vital record updated successfully.');

        } catch (\Throwable $e) {
            // Log the error and redirect back with input and error message
            Log::error('VitalRecord update error', ['id' => $id, 'message' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Failed to update record: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified vital record from the database (AJAX request).
     * Note: DB::beginTransaction() is omitted as it is not fully supported by MongoDB.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        try {
            // Find and delete the record
            VitalRecord::findOrFail($id)->delete();

            // Return JSON success response for AJAX handling
            return response()->json(['success' => true, 'message' => 'Record deleted successfully.']);

        } catch (\Throwable $e) {
            // Log the error and return JSON error response
            Log::error('VitalRecord destroy error', ['id' => $id, 'message' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => 'Failed to delete record.'], 500);
        }
    }
}
