@extends('layouts.admin')
@section('title', 'Events')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:0.75rem;">
    <p style="color:var(--text-secondary);font-size:0.875rem;">{{ $events->total() }} events</p>
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">+ Add Event</a>
</div>
<form method="GET" style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-bottom:1.5rem;">
    <input type="text" name="search" class="form-input" style="flex:1;min-width:200px;" placeholder="Search events…" value="{{ request('search') }}">
    <button type="submit" class="btn btn-secondary">Search</button>
    <a href="{{ route('admin.events.index') }}" class="btn btn-ghost">Clear</a>
</form>
<div class="card" style="overflow:auto;">
    <table class="admin-table">
        <thead>
            <tr><th>Title</th><th>Type</th><th>Category</th><th>Date</th><th>City</th><th>Featured</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td style="font-weight:600;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $event->title }}</td>
                <td><span class="badge badge-purple">{{ ucfirst($event->event_type) }}</span></td>
                <td>{{ $event->category?->name ?? '—' }}</td>
                <td style="font-size:0.82rem;color:var(--text-secondary);">{{ $event->start_date->format('M d, Y') }}</td>
                <td style="font-size:0.82rem;color:var(--text-secondary);">{{ $event->city ?? '—' }}</td>
                <td>{{ $event->is_featured ? '⭐' : '—' }}</td>
                <td>
                    <div style="display:flex;gap:0.4rem;">
                        <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.events.destroy', $event->id) }}" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this event?')">Del</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:var(--text-secondary);padding:2rem;">No events found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination">{{ $events->links('vendor.pagination.custom') }}</div>
@endsection
