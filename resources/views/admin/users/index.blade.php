@extends('layouts.admin')
@section('title', 'User Management')

@section('content')

{{-- Header --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
    <div>
        <h2 style="font-size:1.25rem;font-weight:800;margin-bottom:0.25rem;">👥 User Management</h2>
        <p style="color:var(--text-secondary);font-size:0.85rem;">View, manage roles, and delete users.</p>
    </div>
    <div class="badge badge-purple" style="font-size:0.85rem;padding:0.4rem 1rem;">
        {{ $users->total() }} Total Users
    </div>
</div>

{{-- Search & Filter --}}
<form method="GET" action="{{ route('admin.users.index') }}">
    <div style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-bottom:1.5rem;">
        <div class="search-bar" style="flex:1;min-width:220px;">
            <span class="search-icon">🔍</span>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name or email…" class="form-input">
        </div>
        <select name="role" class="form-select" style="width:140px;">
            <option value="">All Roles</option>
            <option value="user"  {{ request('role') === 'user'  ? 'selected' : '' }}>User</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
        @if(request('search') || request('role'))
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Clear</a>
        @endif
    </div>
</form>

{{-- Users Table --}}
<div class="card" style="overflow:hidden;">
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined</th>
                <th>Verified</th>
                <th style="text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td style="color:var(--text-secondary);font-size:0.78rem;">{{ $user->id }}</td>

                {{-- Avatar + Name --}}
                <td>
                    <div style="display:flex;align-items:center;gap:0.65rem;">
                            <x-image-or-icon :path="$user->avatar" icon="fa-user" size="34px" rounded alt="Avatar" style="border:1px solid var(--border);" />
                        <span style="font-weight:600;font-size:0.875rem;">{{ $user->name }}</span>
                    </div>
                </td>

                <td style="font-size:0.82rem;color:var(--text-secondary);">{{ $user->email }}</td>

                {{-- Role Badge + Change --}}
                <td>
                    @if($user->id === auth()->id())
                        <span class="badge badge-purple">admin (you)</span>
                    @else
                        <form method="POST" action="{{ route('admin.users.role', $user->id) }}"
                              style="display:inline-flex;align-items:center;gap:0.4rem;">
                            @csrf @method('PATCH')
                            <select name="role" class="form-select"
                                    style="padding:0.2rem 0.5rem;font-size:0.78rem;width:auto;"
                                    onchange="this.form.submit()">
                                <option value="user"  {{ $user->role === 'user'  ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </form>
                    @endif
                </td>

                <td style="font-size:0.78rem;color:var(--text-secondary);">
                    {{ $user->created_at->format('d M Y') }}
                </td>

                <td>
                    @if($user->email_verified_at)
                        <span class="badge badge-green">✓ Yes</span>
                    @else
                        <span class="badge badge-red">✗ No</span>
                    @endif
                </td>

                {{-- Delete --}}
                <td style="text-align:right;">
                    @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                              onsubmit="return confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">🗑 Delete</button>
                        </form>
                    @else
                        <span style="font-size:0.75rem;color:var(--text-secondary);">—</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:2rem;color:var(--text-secondary);">
                    No users found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($users->hasPages())
<div class="pagination" style="margin-top:1.5rem;">
    {{ $users->links() }}
</div>
@endif

@endsection
