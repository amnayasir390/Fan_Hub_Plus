@extends('layouts.admin')
@section('title', 'Articles')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:0.75rem;">
    <p style="color:var(--text-secondary);font-size:0.875rem;">{{ $articles->total() }} articles</p>
    <div style="display:flex;gap:0.5rem;">
        <a href="{{ route('admin.submissions.index') }}" class="btn btn-secondary">📨 Fan Submissions</a>
        <a href="{{ route('admin.articles.create') }}"  class="btn btn-primary">+ Add Article</a>
    </div>
</div>
<form method="GET" style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-bottom:1.5rem;">
    <input type="text" name="search" class="form-input" style="flex:1;min-width:200px;" placeholder="Search titles…" value="{{ request('search') }}">
    <select name="status" class="form-select" style="width:auto;" onchange="this.form.submit()">
        <option value="">All Status</option>
        @foreach(['published','draft','pending'] as $s)<option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>@endforeach
    </select>
    <button type="submit" class="btn btn-secondary">Filter</button>
    <a href="{{ route('admin.articles.index') }}" class="btn btn-ghost">Clear</a>
</form>
<div class="card" style="overflow:auto;">
    <table class="admin-table">
        <thead><tr><th>Cover</th><th>Title</th><th>Category</th><th>Type</th><th>Status</th><th>Views</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($articles as $a)
            <tr>
                <td><x-image-or-icon :path="$a->cover_image" icon="fa-newspaper" size="48px" alt="{{ $a->title }}" /></td>
                <td style="max-width:200px;"><div style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-weight:600;">{{ $a->title }}</div></td>
                <td><span class="badge badge-purple">{{ $a->category->name }}</span></td>
                <td><span class="badge badge-gray">{{ str_replace('_',' ',ucfirst($a->article_type)) }}</span></td>
                <td><span class="badge {{ $a->status==='published'?'badge-green':'badge-gray' }}">{{ ucfirst($a->status) }}</span></td>
                <td>{{ number_format($a->view_count) }}</td>
                <td><div style="display:flex;gap:0.4rem;">
                    <a href="{{ route('admin.articles.edit', $a->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.articles.destroy', $a->id) }}" style="display:inline;">@csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Del</button></form>
                </div></td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:var(--text-secondary);padding:2rem;">No articles.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination">{{ $articles->links('vendor.pagination.custom') }}</div>
@endsection
