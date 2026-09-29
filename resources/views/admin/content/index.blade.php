@extends('layouts.admin')
@section('title', 'Content Items')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:0.75rem;">
    <div>
        <p style="color:var(--text-secondary);font-size:0.875rem;">{{ $contents->total() }} items total</p>
    </div>
    <a href="{{ route('admin.content.create') }}" class="btn btn-primary">+ Add Content</a>
</div>

<form method="GET" style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-bottom:1.5rem;">
    <input type="text" name="search" class="form-input" style="flex:1;min-width:200px;" placeholder="Search titles…" value="{{ request('search') }}">
    <select name="category" class="form-select" style="width:auto;" onchange="this.form.submit()">
        <option value="">All Categories</option>
        @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach
    </select>
    <button type="submit" class="btn btn-secondary">Filter</button>
    <a href="{{ route('admin.content.index') }}" class="btn btn-ghost">Clear</a>
</form>

<div class="card" style="overflow:auto;">
    <table class="admin-table">
        <thead><tr><th>Cover</th><th>Title</th><th>Category</th><th>Type</th><th>Status</th><th>Views</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($contents as $item)
            <tr>
                <td><x-image-or-icon :path="$item->cover_image" icon="fa-file-lines" size="48px" alt="{{ $item->title }}" /></td>
                <td style="max-width:220px;"><div style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-weight:600;">{{ $item->title }}</div></td>
                <td><span class="badge badge-purple">{{ $item->category->name }}</span></td>
                <td>{{ ucfirst($item->content_type) }}</td>
                <td><span class="badge {{ $item->status === 'published' ? 'badge-green' : 'badge-gray' }}">{{ ucfirst($item->status) }}</span></td>
                <td>{{ number_format($item->view_count) }}</td>
                <td>
                    <div style="display:flex;gap:0.4rem;">
                        <a href="{{ route('admin.content.edit', $item->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.content.destroy', $item->id) }}" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this content?')">Del</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:var(--text-secondary);padding:2rem;">No content found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination">{{ $contents->links('vendor.pagination.custom') }}</div>
@endsection
