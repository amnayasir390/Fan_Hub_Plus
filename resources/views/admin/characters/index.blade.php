@extends('layouts.admin')
@section('title', 'Characters')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:0.75rem;">
    <p style="color:var(--text-secondary);font-size:0.875rem;">{{ $characters->total() }} characters</p>
    <a href="{{ route('admin.characters.create') }}" class="btn btn-primary">+ Add Character</a>
</div>
<form method="GET" style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-bottom:1.5rem;">
    <input type="text" name="search" class="form-input" style="flex:1;min-width:200px;" placeholder="Search by name…" value="{{ request('search') }}">
    <button type="submit" class="btn btn-secondary">Search</button>
    <a href="{{ route('admin.characters.index') }}" class="btn btn-ghost">Clear</a>
</form>
<div class="card" style="overflow:auto;">
    <table class="admin-table">
        <thead><tr><th>Image</th><th>Name</th><th>Series</th><th>Category</th><th>Genre</th><th>Featured</th><th>Popularity</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($characters as $c)
            <tr>
                <td><x-image-or-icon :path="$c->image" icon="fa-user" size="40px" rounded alt="{{ $c->name }}" /></td>
                <td style="font-weight:600;">{{ $c->name }}</td>
                <td style="color:var(--text-secondary);">{{ $c->series }}</td>
                <td><span class="badge badge-purple">{{ $c->category->name }}</span></td>
                <td>{{ $c->genre ?? '—' }}</td>
                <td>{{ $c->is_featured ? '⭐' : '—' }}</td>
                <td>{{ $c->popularity }}%</td>
                <td><div style="display:flex;gap:0.4rem;">
                    <a href="{{ route('admin.characters.edit', $c->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.characters.destroy', $c->id) }}" style="display:inline;">@csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Del</button></form>
                </div></td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--text-secondary);padding:2rem;">No characters.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination">{{ $characters->links('vendor.pagination.custom') }}</div>
@endsection
