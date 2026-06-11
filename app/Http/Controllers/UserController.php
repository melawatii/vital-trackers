<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display users listing.
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Server-side DataTable endpoint.
     * Uses Collection DataTables — MongoDB does not support toSql() (Query DataTables).
     */
    public function datatable(Request $request)
    {
        // Role badge styles map
        $roleBadge = [
            'admin' => ['#ede9fe', '#6d28d9', 'Administrator'],
            'user'  => ['#dbeafe', '#1d4ed8', 'User'],
        ];

        $users = User::orderBy('created_at', 'desc')->get()
            ->map(function ($row) use ($roleBadge) {
                // Avatar initials from name
                $initials = collect(explode(' ', $row->name))
                    ->map(fn($w) => strtoupper($w[0] ?? ''))
                    ->take(2)->join('');

                // Avatar HTML
                $avatarHtml = '<div style="display:flex;align-items:center;gap:10px">'
                    . '<div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#60a5fa,#2563eb);display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;color:#fff;flex-shrink:0">' . $initials . '</div>'
                    . '<div><p style="font-weight:600;color:#0f172a;font-size:.875rem">' . e($row->name) . '</p></div>'
                    . '</div>';

                // Role badge
                $role     = $row->role ?? 'user';
                $colors   = $roleBadge[$role] ?? ['#f1f5f9', '#475569', ucfirst($role)];
                $roleHtml = '<span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;background:' . $colors[0] . ';color:' . $colors[1] . '">' . $colors[2] . '</span>';

                // Status badge
                $statusHtml = $row->status === 'active'
                    ? '<span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;background:#f0fdf4;color:#15803d"><span style="width:6px;height:6px;border-radius:50%;background:#22c55e;display:inline-block"></span>Active</span>'
                    : '<span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;background:#f8fafc;color:#94a3b8"><span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;display:inline-block"></span>Inactive</span>';

                // Last login display
                $lastLogin = $row->last_login_at
                    ? \Carbon\Carbon::parse($row->last_login_at)->format('d M Y, h:i A')
                    : '–';

                return [
                    'id'          => (string) $row->id,
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

        return DataTables::of($users)
            ->addIndexColumn()
            ->rawColumns(['name_html', 'role_html', 'status_html', 'actions'])
            ->make(true);
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a new user.
     * Note: DB::beginTransaction() not supported by MongoDB — omitted intentionally.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            User::create([
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'phone'    => $request->phone,
                'role'     => $request->role,
                'status'   => $request->status ?? 'active',
            ]);

            return redirect()
                ->route('users.index')
                ->with('success', "User \"{$request->name}\" created successfully.");

        } catch (\Throwable $e) {
            Log::error('User store error', ['message' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    /**
     * Show edit form.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update user.
     * Note: DB::beginTransaction() not supported by MongoDB — omitted intentionally.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        try {
            $user = User::findOrFail($id);

            $data = [
                'name'     => $request->name,
                'username' => $request->username,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'role'     => $request->role,
                'status'   => $request->status,
            ];

            // Only update password if provided
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return redirect()
                ->route('users.index')
                ->with('success', "User \"{$user->name}\" updated successfully.");

        } catch (\Throwable $e) {
            Log::error('User update error', ['id' => $id, 'message' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    /**
     * Delete user (AJAX).
     * Note: DB::beginTransaction() not supported by MongoDB — omitted intentionally.
     */
    public function destroy(string $id)
    {
        try {
            // Prevent deleting currently authenticated user
            if ((string) auth()->id() === $id) {
                return response()->json(['success' => false, 'message' => 'You cannot delete your own account.'], 403);
            }

            User::findOrFail($id)->delete();

            return response()->json(['success' => true, 'message' => 'User deleted successfully.']);

        } catch (\Throwable $e) {
            Log::error('User destroy error', ['id' => $id, 'message' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => 'Failed to delete user.'], 500);
        }
    }
}