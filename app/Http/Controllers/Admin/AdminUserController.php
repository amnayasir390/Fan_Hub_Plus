<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        // Prevent admin from changing their own role
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        $request->validate([
            'role' => ['required', 'in:user,admin'],
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', $user->name . '\'s role updated to ' . $request->role . '.');
    }

    public function destroy(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', $name . ' has been deleted.');
    }
}
