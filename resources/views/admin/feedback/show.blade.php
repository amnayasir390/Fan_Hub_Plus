@extends('layouts.admin')
@section('title', 'Feedback Detail')

@section('content')
<div style="max-width:700px;">
    <a href="{{ route('admin.feedback.index') }}" class="btn btn-ghost btn-sm" style="margin-bottom:1.5rem;display:inline-flex;">← Back to Feedback</a>

    <div class="card" style="padding:1.75rem;margin-bottom:1.5rem;">
        <div style="display:flex;gap:0.5rem;flex-wrap:wrap;margin-bottom:1rem;">
            <span class="badge {{ $feedback->type === 'bug' ? 'badge-red' : ($feedback->type === 'suggestion' ? 'badge-yellow' : 'badge-purple') }}">
                {{ ucfirst($feedback->type) }}
            </span>
            <span class="badge {{ $feedback->status === 'resolved' ? 'badge-green' : ($feedback->status === 'reviewed' ? 'badge-purple' : 'badge-yellow') }}">
                {{ ucfirst($feedback->status) }}
            </span>
        </div>

        <h1 style="font-size:1.2rem;font-weight:800;margin-bottom:1rem;">{{ $feedback->subject }}</h1>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:1rem;font-size:0.875rem;">
            <div><span style="color:var(--text-secondary);">From:</span> <strong>{{ $feedback->name }}</strong></div>
            <div><span style="color:var(--text-secondary);">Email:</span> {{ $feedback->email }}</div>
            <div><span style="color:var(--text-secondary);">Submitted:</span> {{ $feedback->created_at->format('M d, Y g:i A') }}</div>
            @if($feedback->user)
            <div><span style="color:var(--text-secondary);">User:</span> {{ $feedback->user->name }}</div>
            @endif
        </div>

        <div style="background:var(--bg-sidebar);border:1px solid var(--border);border-radius:8px;padding:1rem;font-size:0.9rem;line-height:1.7;margin-bottom:1.5rem;">
            {{ $feedback->message }}
        </div>

        @if($feedback->admin_notes)
        <div style="background:rgba(74,38,183,0.1);border:1px solid rgba(74,38,183,0.3);border-radius:8px;padding:1rem;font-size:0.85rem;margin-bottom:1.5rem;">
            <div style="font-weight:700;margin-bottom:0.4rem;color:var(--purple-light);">📝 Admin Notes</div>
            {{ $feedback->admin_notes }}
        </div>
        @endif

        <form method="POST" action="{{ route('admin.feedback.update', $feedback->id) }}">
            @csrf @method('PATCH')
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                <div class="form-group">
                    <label class="form-label">Update Status</label>
                    <select name="status" class="form-select">
                        @foreach(['new','reviewed','resolved'] as $s)
                        <option value="{{ $s }}" {{ $feedback->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Admin Notes</label>
                <textarea name="admin_notes" class="form-textarea" rows="3" placeholder="Internal notes about this feedback…">{{ $feedback->admin_notes }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>
@endsection
