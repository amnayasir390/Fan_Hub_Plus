@extends('layouts.admin')
@section('title', 'Feedback')

@section('content')
<div style="display:flex;gap:0.5rem;flex-wrap:wrap;margin-bottom:1.5rem;">
    @foreach(['' => 'All', 'new' => '🆕 New', 'reviewed' => '👁 Reviewed', 'resolved' => '✅ Resolved'] as $val => $label)
    <a href="{{ route('admin.feedback.index', ['status' => $val ?: null]) }}"
       class="btn {{ request('status', '') === $val ? 'btn-primary' : 'btn-secondary' }} btn-sm">{{ $label }}</a>
    @endforeach
    @foreach(['' => 'All Types', 'bug' => '🐛 Bug', 'suggestion' => '💡 Suggestion', 'query' => '❓ Query'] as $val => $label)
    <a href="{{ route('admin.feedback.index', array_merge(request()->all(), ['type' => $val ?: null])) }}"
       class="btn {{ request('type', '') === $val ? 'btn-primary' : 'btn-secondary' }} btn-sm">{{ $label }}</a>
    @endforeach
</div>

<div class="card" style="overflow:auto;">
    <table class="admin-table">
        <thead>
            <tr><th>Type</th><th>Subject</th><th>From</th><th>Status</th><th>Date</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($feedback as $fb)
            <tr>
                <td>
                    <span class="badge {{ $fb->type === 'bug' ? 'badge-red' : ($fb->type === 'suggestion' ? 'badge-yellow' : 'badge-purple') }}">
                        {{ ucfirst($fb->type) }}
                    </span>
                </td>
                <td style="max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-weight:600;">{{ $fb->subject }}</td>
                <td style="font-size:0.82rem;color:var(--text-secondary);">{{ $fb->name }}<br><span style="font-size:0.72rem;">{{ $fb->email }}</span></td>
                <td>
                    <span class="badge {{ $fb->status === 'resolved' ? 'badge-green' : ($fb->status === 'reviewed' ? 'badge-purple' : 'badge-yellow') }}">
                        {{ ucfirst($fb->status) }}
                    </span>
                </td>
                <td style="font-size:0.78rem;color:var(--text-secondary);">{{ $fb->created_at->format('M d, Y') }}</td>
                <td>
                    <div style="display:flex;gap:0.4rem;">
                        <a href="{{ route('admin.feedback.show', $fb->id) }}" class="btn btn-secondary btn-sm">View</a>
                        <form method="POST" action="{{ route('admin.feedback.destroy', $fb->id) }}" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this feedback?')">Del</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:var(--text-secondary);padding:2rem;">No feedback found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination">{{ $feedback->links('vendor.pagination.custom') }}</div>
@endsection
