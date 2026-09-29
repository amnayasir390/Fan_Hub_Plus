@extends('layouts.admin')
@section('title', 'Fan Submissions')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
    <div style="display:flex;gap:0.5rem;">
        @foreach(['' => 'All', 'pending' => '⏳ Pending', 'approved' => '✅ Approved', 'rejected' => '❌ Rejected'] as $val => $label)
        <a href="{{ route('admin.submissions.index', ['status' => $val ?: null]) }}" class="btn {{ request('status',$val===''?'':null) === ($val ?: null) ? 'btn-primary' : 'btn-secondary' }} btn-sm">{{ $label }}</a>
        @endforeach
    </div>
</div>
<div class="card" style="overflow:auto;">
    <table class="admin-table">
        <thead><tr><th>Title</th><th>Submitted By</th><th>Category</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($submissions as $sub)
            <tr>
                <td style="max-width:200px;font-weight:600;">{{ Str::limit($sub->title, 40) }}</td>
                <td>{{ $sub->user?->name }}</td>
                <td>{{ $sub->category?->name ?? '—' }}</td>
                <td><span class="badge {{ $sub->status==='approved'?'badge-green':($sub->status==='rejected'?'badge-red':'badge-yellow') }}">{{ ucfirst($sub->status) }}</span></td>
                <td style="font-size:0.78rem;color:var(--text-secondary);">{{ $sub->created_at->format('M d, Y') }}</td>
                <td>
                    @if($sub->status === 'pending')
                    <div style="display:flex;gap:0.4rem;">
                        <form method="POST" action="{{ route('admin.submissions.approve', $sub->id) }}" style="display:inline;">@csrf
                        <button type="submit" class="btn btn-primary btn-sm">Approve</button></form>
                        <form method="POST" action="{{ route('admin.submissions.reject', $sub->id) }}" style="display:inline;">@csrf
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Reject?')">Reject</button></form>
                    </div>
                    @else
                    <span style="font-size:0.78rem;color:var(--text-secondary);">{{ ucfirst($sub->status) }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:var(--text-secondary);padding:2rem;">No submissions found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="pagination">{{ $submissions->links('vendor.pagination.custom') }}</div>
@endsection
