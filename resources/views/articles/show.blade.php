@extends('layouts.app')
@section('title', $article->title)

@section('content')
<div class="container py-section">

    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-sep">/</span>
        <a href="{{ route('articles.index') }}">Articles</a>
        <span class="breadcrumb-sep">/</span>
        <span>{{ Str::limit($article->title, 40) }}</span>
    </div>

    <div style="display:grid;grid-template-columns:1fr 280px;gap:2rem;align-items:start;">
        <div>
            <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:1rem;">
                <span class="badge badge-purple">{{ $article->category->name }}</span>
                @if($article->article_type === 'event_highlight')<span class="badge badge-yellow">🗓️ Event Highlight</span>@endif
                @if($article->article_type === 'fan_submission')<span class="badge badge-green">✍️ Fan Submission</span>@endif
                @if($article->is_featured)<span class="badge badge-yellow">⭐ Featured</span>@endif
            </div>

            <h1 style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:900;line-height:1.2;margin-bottom:1rem;">{{ $article->title }}</h1>

            <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;font-size:0.875rem;color:var(--text-secondary);flex-wrap:wrap;">
                @if($article->user)
                <div style="display:flex;align-items:center;gap:0.5rem;">
                    <x-image-or-icon :path="$article->user->avatar" icon="fa-user" size="28px" rounded alt="{{ $article->user->name }}" />
                    <span>{{ $article->user->name }}</span>
                </div>
                @endif
                <span>{{ $article->created_at->format('F j, Y') }}</span>
                <span>👁 {{ number_format($article->view_count) }} views</span>
                @if($article->event_date)
                <span>📅 {{ $article->event_date->format('M d, Y') }}</span>
                @endif
                @if($article->event_location)
                <span>📍 {{ $article->event_location }}</span>
                @endif
            </div>

            @if($article->excerpt)
            <p style="font-size:1.1rem;color:var(--text-secondary);line-height:1.7;border-left:3px solid var(--purple);padding-left:1rem;margin-bottom:1.5rem;">
                {{ $article->excerpt }}
            </p>
            @endif

            {{-- Cover image placeholder --}}
            <div style="width:100%;border-radius:12px;margin-bottom:1.5rem;height:300px;border:1px solid var(--border);overflow:hidden;">
                <x-image-or-icon :path="$article->cover_image" icon="fa-newspaper" size="100%" alt="{{ $article->title }}" style="width:100%;height:100%;border-radius:0;" />
            </div>

            <div style="font-size:0.95rem;line-height:1.9;color:var(--text-main);">
                {!! nl2br(e($article->body)) !!}
            </div>

            @if($article->tags)
            <div style="margin-top:1.5rem;display:flex;flex-wrap:wrap;gap:0.5rem;">
                @foreach($article->tags as $tag)
                <span class="badge badge-purple">#{{ $tag }}</span>
                @endforeach
            </div>
            @endif

            <div class="divider"></div>

            <div style="display:flex;gap:0.75rem;flex-wrap:wrap;align-items:center;">
                @auth
                <button class="btn btn-secondary btn-sm" data-bookmark-btn data-type="article" data-id="{{ $article->id }}">
                    {{ $isBookmarked ? '🔖 Bookmarked' : '🔖 Bookmark' }}
                </button>
                @endauth
            </div>
        </div>

        <div>
            @if($related->count())
            <div class="card" style="padding:1.25rem;">
                <h3 style="font-size:0.9rem;font-weight:700;margin-bottom:1rem;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;">Related Articles</h3>
                <div style="display:flex;flex-direction:column;gap:0.75rem;">
                    @foreach($related as $r)
                    <a href="{{ route('articles.show', $r->slug) }}" style="display:flex;gap:0.75rem;text-decoration:none;align-items:flex-start;">
                        <div style="width:44px;height:44px;border-radius:8px;background:rgba(74,38,183,0.2);display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;">
                            {{ $article->category->icon ?? '📄' }}
                        </div>
                        <div>
                            <div style="font-size:0.82rem;font-weight:600;color:var(--text-main);">{{ Str::limit($r->title, 45) }}</div>
                            <div style="font-size:0.72rem;color:var(--text-secondary);">{{ $r->created_at->format('M d, Y') }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
