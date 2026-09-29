@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')

{{-- Stats Grid --}}
<div class="grid-cards grid-4" style="margin-bottom:2rem;">
    @foreach([
        ['fa-users',          'Users',         $stats['users'],           '#7C4DFF'],
        ['fa-file-lines',     'Content Items', $stats['contents'],        '#06B6D4'],
        ['fa-pen-to-square',  'Articles',      $stats['articles'],        '#10B981'],
        ['fa-user-group',     'Characters',    $stats['characters'],      '#F59E0B'],
        ['fa-film',           'Media Items',   $stats['media_items'],     '#EF4444'],
        ['fa-bag-shopping',   'Merchandise',   $stats['merchandise'],     '#8B5CF6'],
        ['fa-calendar-days',  'Events',        $stats['events'],          '#EC4899'],
        ['fa-eye',            'Total Views',   number_format($stats['total_views']), '#6366F1'],
    ] as [$icon,$label,$value,$color])
    <div class="stat-card">
        <div class="stat-icon" style="background:{{ $color }}22;color:{{ $color }};display:flex;align-items:center;justify-content:center;">
            <i class="fa-solid {{ $icon }}"></i>
        </div>
        <div>
            <div class="stat-value">{{ $value }}</div>
            <div class="stat-label">{{ $label }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- Alerts --}}
@if($stats['feedback'] > 0 || $stats['fan_submissions'] > 0)
<div style="display:flex;gap:1rem;flex-wrap:wrap;margin-bottom:2rem;">
    @if($stats['feedback'] > 0)
    <a href="{{ route('admin.feedback.index') }}" class="alert alert-warning" style="text-decoration:none;flex:1;min-width:200px;">
        <i class="fa-solid fa-comments"></i> {{ $stats['feedback'] }} new feedback message{{ $stats['feedback'] > 1 ? 's' : '' }} waiting for review
    </a>
    @endif
    @if($stats['fan_submissions'] > 0)
    <a href="{{ route('admin.submissions.index') }}" class="alert alert-info" style="text-decoration:none;flex:1;min-width:200px;">
        <i class="fa-solid fa-paper-plane"></i> {{ $stats['fan_submissions'] }} fan submission{{ $stats['fan_submissions'] > 1 ? 's' : '' }} pending approval
    </a>
    @endif
</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">

    {{-- Popular Content --}}
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:14px;padding:1.25rem;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
            <h2 style="font-size:0.95rem;font-weight:700;color:var(--text-main);"><i class="fa-solid fa-fire" style="color:#F59E0B;"></i> Most Viewed Content</h2>
            <a href="{{ route('admin.content.index') }}" style="font-size:0.78rem;color:#A78BFA;">Manage <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <table class="admin-table">
            <thead><tr><th>Title</th><th>Category</th><th>Views</th></tr></thead>
            <tbody>
                @foreach($popularContent as $c)
                <tr>
                    <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:var(--text-main);">{{ $c->title }}</td>
                    <td><span class="badge badge-purple">{{ $c->category->name }}</span></td>
                    <td style="color:var(--text-secondary);">{{ number_format($c->view_count) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Recent Users --}}
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:14px;padding:1.25rem;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
            <h2 style="font-size:0.95rem;font-weight:700;color:var(--text-main);"><i class="fa-solid fa-users" style="color:#7C4DFF;"></i> Recent Users</h2>
        </div>
        <table class="admin-table">
            <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Joined</th></tr></thead>
            <tbody>
                @foreach($recentUsers as $u)
                <tr>
                    <td style="color:var(--text-main);">{{ $u->name }}</td>
                    <td style="font-size:0.8rem;color:var(--text-secondary);">{{ $u->email }}</td>
                    <td><span class="badge {{ $u->role === 'admin' ? 'badge-purple' : 'badge-gray' }}">{{ $u->role }}</span></td>
                    <td style="font-size:0.78rem;color:var(--text-secondary);">{{ $u->created_at->format('M d') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Recent Feedback --}}
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:14px;padding:1.25rem;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
            <h2 style="font-size:0.95rem;font-weight:700;color:var(--text-main);"><i class="fa-solid fa-comments" style="color:#06B6D4;"></i> Recent Feedback</h2>
            <a href="{{ route('admin.feedback.index') }}" style="font-size:0.78rem;color:#A78BFA;">View All <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        @foreach($recentFeedback as $fb)
        <div style="padding:0.6rem 0;border-bottom:1px solid var(--border);display:flex;gap:0.75rem;align-items:flex-start;">
            <span class="badge {{ $fb->type === 'bug' ? 'badge-red' : ($fb->type === 'suggestion' ? 'badge-yellow' : 'badge-purple') }}" style="flex-shrink:0;">{{ ucfirst($fb->type) }}</span>
            <div>
                <div style="font-size:0.85rem;font-weight:600;color:var(--text-main);">{{ $fb->subject }}</div>
                <div style="font-size:0.75rem;color:var(--text-secondary);">{{ $fb->name }} · {{ $fb->created_at->diffForHumans() }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pending Submissions --}}
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:14px;padding:1.25rem;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
            <h2 style="font-size:0.95rem;font-weight:700;color:var(--text-main);"><i class="fa-solid fa-paper-plane" style="color:#EC4899;"></i> Pending Submissions</h2>
            <a href="{{ route('admin.submissions.index') }}" style="font-size:0.78rem;color:#A78BFA;">View All <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        @foreach($pendingSubmissions as $sub)
        <div style="padding:0.6rem 0;border-bottom:1px solid var(--border);">
            <div style="font-size:0.85rem;font-weight:600;color:var(--text-main);">{{ Str::limit($sub->title, 45) }}</div>
            <div style="font-size:0.75rem;color:var(--text-secondary);">
                by {{ $sub->user?->name }} · {{ $sub->category?->name }} · {{ $sub->created_at->diffForHumans() }}
            </div>
            <div style="display:flex;gap:0.4rem;margin-top:0.4rem;">
                <form method="POST" action="{{ route('admin.submissions.approve', $sub->id) }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm">Approve</button>
                </form>
                <form method="POST" action="{{ route('admin.submissions.reject', $sub->id) }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Reject this submission?')">Reject</button>
                </form>
            </div>
        </div>
        @endforeach
        @if(!$pendingSubmissions->count())
        <p style="font-size:0.85rem;color:var(--text-secondary);">No pending submissions.</p>
        @endif
    </div>

</div>
@endsection