@extends('layouts.app')
@section('title', $content->title)

@section('content')
<div class="container py-section">

    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-sep">/</span>
        <a href="{{ route('content.index') }}">Explore</a>
        <span class="breadcrumb-sep">/</span>
        <a href="{{ route('content.category', $content->category->slug) }}">{{ $content->category->name }}</a>
        <span class="breadcrumb-sep">/</span>
        <span>{{ Str::limit($content->title, 40) }}</span>
    </div>

    <div style="display:grid;grid-template-columns:1fr 300px;gap:2rem;align-items:start;">

        {{-- Main Content --}}
        <div>
            <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:1rem;align-items:center;">
                <span class="badge badge-purple">{{ $content->category->name }}</span>
                @if($content->genre)<span class="badge badge-gray">{{ $content->genre }}</span>@endif
                @if($content->release_year)<span class="badge badge-gray">{{ $content->release_year }}</span>@endif
                <span class="badge badge-gray">{{ ucfirst($content->content_type) }}</span>
            </div>

            <h1 style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:900;margin-bottom:1rem;line-height:1.2;">{{ $content->title }}</h1>

            @if($content->excerpt)
            <p style="font-size:1.1rem;color:var(--text-secondary);line-height:1.7;margin-bottom:1.5rem;border-left:3px solid var(--purple);padding-left:1rem;">
                {{ $content->excerpt }}
            </p>
            @endif

            {{-- Cover image placeholder --}}
            <div style="width:100%;border-radius:12px;overflow:hidden;margin-bottom:1.5rem;height:280px;border:1px solid var(--border);">
                <x-image-or-icon :path="$content->cover_image" icon="fa-file-lines" size="100%" alt="{{ $content->title }}" style="height:100%;width:100%;border-radius:0;" />
            </div>

            <div style="font-size:0.95rem;line-height:1.8;color:var(--text-main);">
                {!! nl2br(e($content->body)) !!}
            </div>

            {{-- Tags --}}
            @if($content->tags)
            <div style="margin-top:1.5rem;display:flex;flex-wrap:wrap;gap:0.5rem;">
                @foreach($content->tags as $tag)
                <span class="badge badge-purple">#{{ $tag }}</span>
                @endforeach
            </div>
            @endif

            <div class="divider"></div>

            {{-- Actions --}}
            <div style="display:flex;gap:0.75rem;flex-wrap:wrap;align-items:center;">
                @auth
                <button class="btn btn-secondary btn-sm" data-bookmark-btn data-type="content" data-id="{{ $content->id }}" {{ $isBookmarked ? 'class=btn btn-secondary btn-sm active' : '' }}" title="{{ $isBookmarked ? 'Remove bookmark' : 'Bookmark' }}">
                    {{ $isBookmarked ? '🔖 Bookmarked' : '🔖 Bookmark' }}
                </button>
                @endauth
                <span style="color:var(--text-secondary);font-size:0.85rem;">👁 {{ number_format($content->view_count) }} views</span>
                <span style="color:var(--text-secondary);font-size:0.85rem;">⭐ {{ $content->popularity }}% popularity</span>
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
            <div class="card" style="padding:1.25rem;margin-bottom:1.25rem;">
                <h3 style="font-size:0.9rem;font-weight:700;margin-bottom:1rem;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;">About this item</h3>
                <div style="display:flex;flex-direction:column;gap:0.6rem;font-size:0.85rem;">
                    <div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Category</span><span>{{ $content->category->name }}</span></div>
                    @if($content->genre)<div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Genre</span><span>{{ $content->genre }}</span></div>@endif
                    @if($content->release_year)<div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Year</span><span>{{ $content->release_year }}</span></div>@endif
                    <div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Views</span><span>{{ number_format($content->view_count) }}</span></div>
                    <div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Popularity</span><span>{{ $content->popularity }}%</span></div>
                </div>
            </div>

            @if($related->count())
            <div class="card" style="padding:1.25rem;">
                <h3 style="font-size:0.9rem;font-weight:700;margin-bottom:1rem;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;">Related Content</h3>
                <div style="display:flex;flex-direction:column;gap:0.75rem;">
                    @foreach($related as $r)
                    <a href="{{ route('content.show', $r->slug) }}" style="display:flex;gap:0.75rem;align-items:center;text-decoration:none;">
                        <div style="width:44px;height:44px;border-radius:8px;background:rgba(74,38,183,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.2rem;">
                            {{ $content->category->icon ?? '📄' }}
                        </div>
                        <div style="min-width:0;">
                            <div style="font-size:0.82rem;font-weight:600;color:var(--text-main);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ Str::limit($r->title, 40) }}</div>
                            <div style="font-size:0.72rem;color:var(--text-secondary);">👁 {{ number_format($r->view_count) }}</div>
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
