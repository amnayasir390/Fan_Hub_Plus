@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container py-section">

    {{-- Breadcrumbs --}}
    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-sep">/</span>
        <span>Dashboard</span>
    </div>

    {{-- Greeting --}}
    <div style="margin-bottom:2rem;">
        <h1 style="font-size:1.75rem;font-weight:900;margin-bottom:0.25rem;">
            {{ now()->hour < 12 ? '🌅 Good morning' : (now()->hour < 17 ? '☀️ Good afternoon' : '🌙 Good evening') }},
            {{ explode(' ', $user->name)[0] }}!
        </h1>
        <p style="color:var(--text-secondary);">Here's what's happening in your fandom universe today.</p>
    </div>

    {{-- Quick Stats Row --}}
    <div class="grid-cards grid-4" style="margin-bottom:2.5rem;">
        <div class="stat-card">
            <div class="stat-icon">🔖</div>
            <div>
                <div class="stat-value">{{ $bookmarks->count() }}</div>
                <div class="stat-label">Bookmarks</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">❤️</div>
            <div>
                <div class="stat-value">{{ count($user->favorite_fandoms ?? []) }}</div>
                <div class="stat-label">Favourite Fandoms</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🎯</div>
            <div>
                <div class="stat-value">{{ count($user->categories_of_interest ?? []) }}</div>
                <div class="stat-label">Interests</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div>
                <div class="stat-value">{{ $user->email_verified_at ? '✓' : '✗' }}</div>
                <div class="stat-label">Email Verified</div>
            </div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 320px;gap:2rem;align-items:start;">

        {{-- Left Column --}}
        <div>
            {{-- Favourite Fandoms --}}
            @if($favoriteFandoms->count())
            <div style="margin-bottom:2.5rem;">
                <div class="section-header">
                    <h2 class="section-title">Your Fandoms</h2>
                    <a href="{{ route('profile.edit') }}" class="btn btn-ghost btn-sm">Edit →</a>
                </div>
                <div style="display:flex;flex-wrap:wrap;gap:0.75rem;">
                    @foreach($favoriteFandoms as $cat)
                    <a href="{{ route('content.category', $cat->slug) }}" class="cat-card" style="flex:0 0 auto;width:140px;">
                        <div class="cat-card-accent" style="background:{{ $cat->color }};"></div>
                        <div class="cat-card-body" style="padding:1rem;">
                            <div style="font-size:1.75rem;">{{ $cat->icon }}</div>
                            <div class="cat-card-name" style="font-size:0.9rem;">{{ $cat->name }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Recent Content --}}
            @if($recentContent->count())
            <div style="margin-bottom:2.5rem;">
                <div class="section-header">
                    <h2 class="section-title">Recent Content for You</h2>
                    <a href="{{ route('content.index') }}" class="btn btn-ghost btn-sm">View All →</a>
                </div>
                <div class="grid-cards grid-auto">
                    @foreach($recentContent as $item)
                    <a href="{{ route('content.show', $item->slug) }}" class="card" style="text-decoration:none;">
                        <div class="card-img" style="background:linear-gradient(135deg,{{ $item->category->color ?? '#4A26B7' }}33,var(--bg-card));display:flex;align-items:center;justify-content:center;font-size:2.5rem;">
                            <x-image-or-icon :path="$item->cover_image" icon="fa-file-lines" size="48px" alt="{{ $item->title }}" />
                        </div>
                        <div class="card-body">
                            <div style="margin-bottom:0.25rem;"><span class="badge badge-purple">{{ $item->category->name }}</span></div>
                            <div class="card-title" style="font-size:0.875rem;">{{ Str::limit($item->title, 50) }}</div>
                            <div class="card-meta">👁 {{ number_format($item->view_count) }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Recent Articles --}}
            @if($recentArticles->count())
            <div>
                <div class="section-header">
                    <h2 class="section-title">Recent Articles</h2>
                    <a href="{{ route('articles.index') }}" class="btn btn-ghost btn-sm">View All →</a>
                </div>
                <div style="display:flex;flex-direction:column;gap:0.75rem;">
                    @foreach($recentArticles as $article)
                    <a href="{{ route('articles.show', $article->slug) }}" class="card" style="text-decoration:none;display:flex;align-items:center;gap:0;">
                        <div style="width:80px;height:80px;flex-shrink:0;background:linear-gradient(135deg,{{ $article->category->color ?? '#4A26B7' }}33,var(--bg-card));display:flex;align-items:center;justify-content:center;font-size:1.75rem;">
                            <x-image-or-icon :path="$article->cover_image" icon="fa-newspaper" size="48px" alt="{{ $article->title }}" />
                        </div>
                        <div class="card-body">
                            <span class="badge badge-purple" style="margin-bottom:0.25rem;">{{ $article->category->name }}</span>
                            <div class="card-title" style="font-size:0.875rem;">{{ Str::limit($article->title, 60) }}</div>
                            <div class="card-meta">{{ $article->created_at->diffForHumans() }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            @if(!$recentContent->count() && !$recentArticles->count())
            <div style="text-align:center;padding:3rem;background:var(--bg-card);border-radius:12px;border:1px solid var(--border);">
                <div style="font-size:3rem;margin-bottom:1rem;">🔭</div>
                <h3 style="margin-bottom:0.5rem;">Nothing yet!</h3>
                <p style="color:var(--text-secondary);margin-bottom:1.5rem;">Update your interests in your profile to get personalised content.</p>
                <div style="display:flex;gap:0.75rem;justify-content:center;flex-wrap:wrap;">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Update Interests</a>
                    <a href="{{ route('content.index') }}" class="btn btn-secondary">Explore All Content</a>
                </div>
            </div>
            @endif
        </div>

        {{-- Right Column: Bookmarks Sidebar --}}
        <div>
            <div class="card" style="padding:1.25rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                    <h3 style="font-size:1rem;font-weight:700;">🔖 Recent Bookmarks</h3>
                    <a href="{{ route('bookmarks.index') }}" style="font-size:0.78rem;color:var(--purple-light);">View All</a>
                </div>
                @if($bookmarks->count())
                <div style="display:flex;flex-direction:column;gap:0.75rem;">
                    @foreach($bookmarks as $bm)
                    @php $item = $bm->bookmarkable; @endphp
                    @if($item)
                    <div style="display:flex;align-items:flex-start;gap:0.75rem;padding-bottom:0.75rem;border-bottom:1px solid var(--border);">
                        <div style="width:36px;height:36px;background:rgba(74,38,183,0.2);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;">
                            {{ match(class_basename($item)) { 'Article' => '📝', 'Character' => '👤', 'MediaItem' => '🎬', 'Merchandise' => '🛍️', default => '📄' } }}
                        </div>
                        <div style="min-width:0;">
                            <div style="font-size:0.82rem;font-weight:600;color:var(--text-main);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ Str::limit($item->title ?? $item->name ?? 'Item', 35) }}
                            </div>
                            <div style="font-size:0.72rem;color:var(--text-secondary);">{{ class_basename($item) }} · {{ $bm->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                <a href="{{ route('bookmarks.index') }}" class="btn btn-secondary btn-sm" style="width:100%;margin-top:1rem;justify-content:center;">View All Bookmarks</a>
                @else
                <div style="text-align:center;padding:1.5rem 0;color:var(--text-secondary);">
                    <div style="font-size:2rem;margin-bottom:0.5rem;">🔖</div>
                    <p style="font-size:0.85rem;">No bookmarks yet.<br>Start saving content you love!</p>
                </div>
                @endif
            </div>

            {{-- Profile completion card --}}
            <div class="card" style="padding:1.25rem;margin-top:1.25rem;">
                <h3 style="font-size:1rem;font-weight:700;margin-bottom:1rem;">👤 Your Profile</h3>
                <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;">
                    <x-image-or-icon :path="$user->avatar" icon="fa-user" size="48px" rounded alt="Avatar" style="border:2px solid var(--border);" />
                    <div>
                        <div style="font-weight:700;">{{ $user->name }}</div>
                        <div style="font-size:0.78rem;color:var(--text-secondary);">{{ $user->email }}</div>
                    </div>
                </div>
                @if($user->bio)
                <p style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:1rem;">{{ Str::limit($user->bio, 100) }}</p>
                @endif
                <a href="{{ route('profile.edit') }}" class="btn btn-secondary btn-sm" style="width:100%;justify-content:center;">Edit Profile</a>
            </div>
        </div>

    </div>
</div>
@endsection
