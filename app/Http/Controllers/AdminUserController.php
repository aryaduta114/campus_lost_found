<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * Display all users.
     */
    public function index(Request $request): View
{
    $search = $request->string('search')->trim()->toString();
    $role = $request->string('role')->toString();

    $users = User::query()
        ->when($search, function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nim_nidn', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        })
        ->when(
            in_array($role, ['USER', 'STAFF', 'ADMIN']),
            function ($query) use ($role) {
                $query->where('role', $role);
            }
        )
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin.users.index', compact('users', 'search', 'role'));
}

    /**
     * Update user role.
     */
    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'in:USER,STAFF'],
        ]);

        $user->update([
            'role' => $request->role,
        ]);

        return back()->with('status', 'Role user berhasil diperbarui.');
    }
}