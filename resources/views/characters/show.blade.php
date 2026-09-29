@extends('layouts.app')
@section('title', $character->name)

@section('content')
<div class="container py-section">

    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-sep">/</span>
        <a href="{{ route('characters.index') }}">Characters</a>
        <span class="breadcrumb-sep">/</span>
        <span>{{ $character->name }}</span>
    </div>

    <div style="display:grid;grid-template-columns:280px 1fr;gap:2rem;align-items:start;">

        {{-- Profile Card --}}
        <div>
            <div class="card" style="padding:1.5rem;text-align:center;">
                <x-image-or-icon :path="$character->image" icon="fa-user" size="120px" rounded alt="{{ $character->name }}" style="margin:0 auto 1rem;border:3px solid var(--border);" />
                <h1 style="font-size:1.4rem;font-weight:900;margin-bottom:0.25rem;">{{ $character->name }}</h1>
                <div style="color:var(--text-secondary);font-size:0.875rem;margin-bottom:0.75rem;">{{ $character->series }}</div>
                <div style="display:flex;flex-wrap:wrap;gap:0.4rem;justify-content:center;margin-bottom:1rem;">
                    <span class="badge badge-purple">{{ $character->category->name }}</span>
                    @if($character->genre)<span class="badge badge-gray">{{ $character->genre }}</span>@endif
                </div>
                <div style="font-size:0.85rem;display:flex;justify-content:center;gap:1rem;color:var(--text-secondary);margin-bottom:1rem;">
                    <span>⭐ {{ $character->popularity }}%</span>
                </div>
                @auth
                <button class="btn btn-secondary btn-sm" style="width:100%;" data-bookmark-btn data-type="character" data-id="{{ $character->id }}">
                    {{ $isBookmarked ? '🔖 Bookmarked' : '🔖 Bookmark' }}
                </button>
                @endauth
            </div>

            @if($character->abilities)
            <div class="card" style="padding:1.25rem;margin-top:1rem;">
                <h3 style="font-size:0.85rem;font-weight:700;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.75rem;">Abilities & Powers</h3>
                <div style="display:flex;flex-direction:column;gap:0.5rem;">
                    @foreach($character->abilities as $ability)
                    <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.875rem;">
                        <span style="width:6px;height:6px;border-radius:50%;background:var(--purple);flex-shrink:0;"></span>
                        {{ $ability }}
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($character->tags)
            <div class="card" style="padding:1.25rem;margin-top:1rem;">
                <h3 style="font-size:0.85rem;font-weight:700;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:0.75rem;">Tags</h3>
                <div style="display:flex;flex-wrap:wrap;gap:0.4rem;">
                    @foreach($character->tags as $tag)
                    <span class="badge badge-purple">#{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Main Content --}}
        <div>
            <h2 style="font-size:1.25rem;font-weight:800;margin-bottom:1rem;">About {{ $character->name }}</h2>
            @if($character->bio)
            <div style="font-size:0.95rem;line-height:1.8;color:var(--text-main);background:var(--bg-card);border:1px solid var(--border);border-radius:12px;padding:1.5rem;margin-bottom:2rem;">
                {{ $character->bio }}
            </div>
            @endif

            {{-- Related Characters --}}
            @if($related->count())
            <div>
                <div class="section-header">
                    <h2 class="section-title">More Characters</h2>
                    <a href="{{ route('characters.index', ['category' => $character->category->slug]) }}" class="btn btn-ghost btn-sm">View All →</a>
                </div>
                <div class="grid-cards grid-4">
                    @foreach($related as $r)
                    <a href="{{ route('characters.show', $r->slug) }}" class="card" style="text-decoration:none;text-align:center;padding:1rem;">
                        <x-image-or-icon :path="$r->image" icon="fa-user" size="60px" rounded alt="{{ $r->name }}" style="margin:0 auto 0.5rem;" />
                        <div style="font-size:0.85rem;font-weight:700;">{{ $r->name }}</div>
                        <div style="font-size:0.75rem;color:var(--text-secondary);">{{ $r->series }}</div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
