@extends('layouts.admin')
@section('title', 'Multimedia')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:0.75rem;">
    <p style="color:var(--text-secondary);font-size:0.875rem;">{{ $mediaItems->total() }} items</p>
    <a href="{{ route('admin.media.create') }}" class="btn btn-primary">+ Add Media</a>
</div>
<form method="GET" style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-bottom:1.5rem;">
    <input type="text" name="search" class="form-input" style="flex:1;min-width:200px;" placeholder="Search…" value="{{ request('search') }}">
    <select name="type" class="form-select" style="width:auto;" onchange="this.form.submit()">
        <option value="">All Types</option>
        @foreach(['video','audio','image','trailer'] as $t)<option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>@endforeach
    </select>
    <button type="submit" class="btn btn-secondary">Filter</button>
    <a href="{{ route('admin.media.index') }}" class="btn btn-ghost">Clear</a>
</form>
<div class="card" style="overflow:auto;">
    <table class="admin-table">
        <thead><tr><th>Title</th><th>Type</th><th>Category</th><th>Featured</th><th>Views</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($mediaItems as $m)
            <tr>
                <td style="max-width:200px;font-weight:600;">{{ Str::limit($m->title, 40) }}</td>
                <td><span class="badge badge-purple">{{ ucfirst($m->media_type) }}</span></td>
                <td>{{ $m->category->name }}</td>
                <td>{{ $m->is_featured ? '⭐' : '—' }}</td>
                <td>{{ number_format($m->view_count) }}</td>
                <td><div style="display:flex;gap:0.4rem;">
                    <a href="{{ route('admin.media.edit', $m->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.media.destroy', $m->id) }}" style="display:inline;">@csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Del</button></form>
                </div></td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:var(--text-secondary);padding:2rem;">No media items.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination">{{ $mediaItems->links('vendor.pagination.custom') }}</div>
@endsection
