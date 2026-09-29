@extends('layouts.app')
@section('title', 'Articles & Event Highlights')

@section('content')
<div class="container py-section">

    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-sep">/</span>
        <span>Articles</span>
    </div>

    <div class="section-header">
        <h1 class="section-title">📝 Articles & Highlights</h1>
        @auth
        <a href="{{ route('articles.submit') }}" class="btn btn-primary btn-sm">✍️ Submit Fan Content</a>
        @endauth
    </div>

    {{-- Event Highlights Timeline --}}
    @if($eventHighlights->count())
    <div style="margin-bottom:2.5rem;">
        <h2 style="font-size:1.1rem;font-weight:800;margin-bottom:1.25rem;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;">🗓️ Event Highlights</h2>
        <div class="timeline">
            @foreach($eventHighlights as $event)
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-date">{{ $event->event_date?->format('M d, Y') ?? $event->created_at->format('M d, Y') }}@if($event->event_location) · 📍 {{ $event->event_location }}@endif</div>
                <div class="timeline-title">
                    <a href="{{ route('articles.show', $event->slug) }}" style="color:var(--text-main);">{{ $event->title }}</a>
                </div>
                <div class="timeline-body">{{ $event->excerpt }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Filters --}}
    <form method="GET" action="{{ route('articles.index') }}">
        <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:12px;padding:1.25rem;margin-bottom:1.5rem;display:flex;flex-wrap:wrap;gap:0.75rem;align-items:center;">
            <div class="search-bar" style="flex:1;min-width:200px;">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" class="form-input" placeholder="Search articles…" value="{{ request('search') }}">
            </div>
            <select name="category" class="form-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->icon }} {{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="type" class="form-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Types</option>
                <option value="article"         {{ request('type') === 'article'         ? 'selected' : '' }}>Article</option>
                <option value="event_highlight" {{ request('type') === 'event_highlight' ? 'selected' : '' }}>Event Highlight</option>
                <option value="fan_submission"  {{ request('type') === 'fan_submission'  ? 'selected' : '' }}>Fan Submission</option>
            </select>
            <select name="sort" class="form-select" style="width:auto;" onchange="this.form.submit()">
                <option value="latest"  {{ request('sort','latest') === 'latest'  ? 'selected' : '' }}>Latest</option>
                <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most Read</option>
                <option value="alpha"   {{ request('sort') === 'alpha'   ? 'selected' : '' }}>A–Z</option>
            </select>
            <button type="submit" class="btn btn-primary">Apply</button>
            <a href="{{ route('articles.index') }}" class="btn btn-secondary">Clear</a>
        </div>
    </form>

    @if($articles->count())
    <div class="grid-cards grid-3">
        @foreach($articles as $article)
        <a href="{{ route('articles.show', $article->slug) }}" class="card" style="text-decoration:none;">
            <div style="height:140px;position:relative;overflow:hidden;">
                <x-image-or-icon :path="$article->cover_image" icon="fa-newspaper" size="140px" alt="{{ $article->title }}" style="width:100%;height:100%;border-radius:0;" />
                <div style="position:absolute;top:0.5rem;left:0.5rem;">
                    <span class="badge badge-purple">{{ $article->category->name }}</span>
                </div>
                @if($article->article_type === 'event_highlight')
                <div style="position:absolute;top:0.5rem;right:0.5rem;">
                    <span class="badge badge-yellow">🗓️ Event</span>
                </div>
                @elseif($article->article_type === 'fan_submission')
                <div style="position:absolute;top:0.5rem;right:0.5rem;">
                    <span class="badge badge-green">✍️ Fan</span>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="card-title">{{ $article->title }}</div>
                <div class="card-excerpt">{{ $article->excerpt }}</div>
                <div class="card-meta" style="margin-top:0.5rem;display:flex;gap:0.5rem;align-items:center;">
                    @if($article->user)<span>By {{ $article->user->name }}</span><span>·</span>@endif
                    <span>{{ $article->created_at->format('M d, Y') }}</span>
                    <span>·</span>
                    <span>👁 {{ number_format($article->view_count) }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    <div class="pagination">{{ $articles->links('vendor.pagination.custom') }}</div>
    @else
    <div style="text-align:center;padding:4rem;background:var(--bg-card);border-radius:12px;border:1px solid var(--border);">
        <div style="font-size:3rem;margin-bottom:1rem;">📝</div>
        <h3>No articles found</h3>
        <a href="{{ route('articles.index') }}" class="btn btn-primary" style="margin-top:1rem;">Clear Filters</a>
    </div>
    @endif
</div>
@endsection
