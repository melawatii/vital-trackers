<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

/**
 * Controller responsible for managing user CRUD operations and DataTables.
 */
class UserController extends Controller
{
    /**
     * Display the user listing page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Summary statistics for users page
        $stats = [
            'total'    => User::count(),
            'active'   => User::where('status', 'active')->count(),
            'admins'   => User::where('role', 'admin')->count(),
            'inactive' => User::where('status', 'inactive')->count(),
        ];

        return view('users.index', compact('stats'));
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
        // Map role keys to their respective badge colors and display labels
        $roleBadge = [
            'admin' => ['#ede9fe', '#6d28d9', 'Administrator'],
            'user'  => ['#dbeafe', '#1d4ed8', 'User'],
        ];

        // Fetch all users and map the data for DataTable consumption
        $users = User::orderBy('created_at', 'desc')->get()
            ->map(function ($row) use ($roleBadge) {
                // Extract initials from the user's name for the avatar
                $initials = collect(explode(' ', $row->name))
                    ->map(fn($w) => strtoupper($w[0] ?? ''))
                    ->take(2)->join('');

                // Generate avatar HTML with initials and user's name
                $avatarHtml = '<div style="display:flex;align-items:center;gap:10px">'
                    . '<div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#60a5fa,#2563eb);display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;color:#fff;flex-shrink:0">' . $initials . '</div>'
                    . '<div><p style="font-weight:600;color:#0f172a;font-size:.875rem">' . e($row->name) . '</p></div>'
                    . '</div>';

                // Generate role badge HTML based on mapping, default to generic style
                $role     = $row->role ?? 'user';
                $colors   = $roleBadge[$role] ?? ['#f1f5f9', '#475569', ucfirst($role)];
                $roleHtml = '<span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;background:' . $colors[0] . ';color:' . $colors[1] . '">' . $colors[2] . '</span>';

                // Generate status badge HTML (Active / Inactive)
                $statusHtml = $row->status === 'active'
                    ? '<span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;background:#f0fdf4;color:#15803d"><span style="width:6px;height:6px;border-radius:50%;background:#22c55e;display:inline-block"></span>Active</span>'
                    : '<span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;background:#f8fafc;color:#94a3b8"><span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block"></span>Inactive</span>';

                // Format the last login timestamp
                $lastLogin = $row->last_login_at
                    ? \Carbon\Carbon::parse($row->last_login_at)->format('d M Y, h:i A')
                    : '–';

                // Return formatted row data including rendered action buttons partial
                return [
                    'id'          => (string) $row->id,
                    'name'        => $row->name,
                    'name_html'   => $avatarHtml,
                    'username'    => e($row->username ?? '–'),
                    'email'       => e($row->email),
                    'role_html'   => $roleHtml,
                    'status_html' => $statusHtml,
                    'last_login'  => $lastLogin,
                    'actions'     => view('users._actions', [
                        'row'       => $row,
                        'editUrl'   => route('users.edit', $row->id),
                        'deleteUrl' => route('users.destroy', $row->id),
                    ])->render(),
                ];
            });

        // Handle sorting if requested by DataTables
        if ($request->input('order') && count($request->input('order')) > 0) {
            $order = $request->input('order')[0];
            $columnIndex = $order['column'];
            $direction = $order['dir'] === 'desc' ? 'desc' : 'asc';

            // Map column indices to fields
            // 0: DT_RowIndex, 1: name, 2: username, 3: email, etc.
            $columnMapping = [
                1 => 'name',
                2 => 'username',
                3 => 'email',
            ];

            if (isset($columnMapping[$columnIndex])) {
                $field = $columnMapping[$columnIndex];
                $users = $users->sortBy($field, SORT_REGULAR, $direction === 'desc');
            }
        }

        // Build and return the DataTables response with raw HTML columns
        return DataTables::of($users)
            ->addIndexColumn()
            ->rawColumns(['name_html', 'role_html', 'status_html', 'actions'])
            ->make(true);
    }

    /**
     * Display the user creation form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in the database.
     * Note: DB::beginTransaction() is omitted as it is not fully supported by MongoDB.
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        try {
            // Create user with hashed password and default active status
            User::create([
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'phone'    => $request->phone,
                'role'     => $request->role,
                'status'   => $request->status ?? 'active',
            ]);

            // Redirect to index with success message
            return redirect()
                ->route('users.index')
                ->with('success', "User \"{$request->name}\" created successfully.");

        } catch (\Throwable $e) {
            // Log the error and redirect back with input and error message
            Log::error('User store error', ['message' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    /**
     * Display the user edit form.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        // Find the user or fail with a 404 error
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in the database.
     * Note: DB::beginTransaction() is omitted as it is not fully supported by MongoDB.
     *
     * @param UpdateUserRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        try {
            $user = User::findOrFail($id);

            // Prepare data for update
            $data = [
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'role'     => $request->role,
                'status'   => $request->status,
            ];

            // Hash and update password only if a new one is provided
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            // Redirect to index with success message
            return redirect()
                ->route('users.index')
                ->with('success', "User \"{$user->name}\" updated successfully.");

        } catch (\Throwable $e) {
            // Log the error and redirect back with input and error message
            Log::error('User update error', ['id' => $id, 'message' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified user from the database (AJAX request).
     * Note: DB::beginTransaction() is omitted as it is not fully supported by MongoDB.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        try {
            // Prevent users from deleting their own account
            if ((string) auth()->id() === $id) {
                return response()->json(['success' => false, 'message' => 'You cannot delete your own account.'], 403);
            }

            // Find and delete the user
            User::findOrFail($id)->delete();

            // Return JSON success response for AJAX handling
            return response()->json(['success' => true, 'message' => 'User deleted successfully.']);

        } catch (\Throwable $e) {
            // Log the error and return JSON error response
            Log::error('User destroy error', ['id' => $id, 'message' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => 'Failed to delete user.'], 500);
        }
    }
}
