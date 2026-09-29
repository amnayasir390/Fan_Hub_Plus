@extends('layouts.admin')
@section('title', 'Merchandise')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:0.75rem;">
    <p style="color:var(--text-secondary);font-size:0.875rem;">{{ $merchandise->total() }} items</p>
    <a href="{{ route('admin.merchandise.create') }}" class="btn btn-primary">+ Add Merchandise</a>
</div>
<form method="GET" style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-bottom:1.5rem;">
    <input type="text" name="search" class="form-input" style="flex:1;min-width:200px;" placeholder="Search…" value="{{ request('search') }}">
    <button type="submit" class="btn btn-secondary">Search</button>
    <a href="{{ route('admin.merchandise.index') }}" class="btn btn-ghost">Clear</a>
</form>
<div class="card" style="overflow:auto;">
    <table class="admin-table">
        <thead><tr><th>Image</th><th>Name</th><th>Category</th><th>Badge</th><th>Price</th><th>Status</th><th>Views</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($merchandise as $m)
            <tr>
                <td><x-image-or-icon :path="$m->image" icon="fa-bag-shopping" size="40px" alt="{{ $m->name }}" /></td>
                <td style="font-weight:600;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $m->name }}</td>
                <td><span class="badge badge-purple">{{ $m->category->name }}</span></td>
                <td>{{ $m->badge ?? '—' }}</td>
                <td>{{ $m->price ? '$'.number_format($m->price,2) : '—' }}</td>
                <td><span class="badge {{ $m->status==='available'?'badge-green':($m->status==='pre-order'?'badge-yellow':'badge-gray') }}">{{ ucfirst($m->status) }}</span></td>
                <td>{{ number_format($m->view_count) }}</td>
                <td><div style="display:flex;gap:0.4rem;">
                    <a href="{{ route('admin.merchandise.edit', $m->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.merchandise.destroy', $m->id) }}" style="display:inline;">@csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Del</button></form>
                </div></td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:var(--text-secondary);padding:2rem;">No merchandise.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination">{{ $merchandise->links('vendor.pagination.custom') }}</div>
@endsection
