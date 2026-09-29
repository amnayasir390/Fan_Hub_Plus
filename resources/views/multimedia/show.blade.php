@extends('layouts.app')
@section('title', $item->title)

@section('content')
<div class="container py-section">

    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-sep">/</span>
        <a href="{{ route('multimedia.index') }}">Multimedia</a>
        <span class="breadcrumb-sep">/</span>
        <span>{{ Str::limit($item->title, 40) }}</span>
    </div>

    <div style="display:grid;grid-template-columns:1fr 300px;gap:2rem;align-items:start;">

        <div>
            {{-- Media Player --}}
            @if(in_array($item->media_type, ['video', 'trailer']))
            <div class="video-container" style="margin-bottom:1.5rem;">
                <iframe src="{{ $item->embed_url }}" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" loading="lazy"></iframe>
            </div>
            @elseif($item->media_type === 'audio')
            <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:12px;padding:2rem;margin-bottom:1.5rem;text-align:center;">
                <div style="font-size:4rem;margin-bottom:1rem;">🎵</div>
                <audio controls style="width:100%;accent-color:var(--purple);">
                    <source src="{{ $item->url }}">
                    Your browser does not support the audio element.
                </audio>
            </div>
            @else
            <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:12px;overflow:hidden;margin-bottom:1.5rem;aspect-ratio:16/9;display:flex;align-items:center;justify-content:center;font-size:5rem;">
                🖼️
            </div>
            @endif

            {{-- Title & Meta --}}
            <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:0.75rem;">
                <span class="badge {{ match($item->media_type) { 'trailer'=>'badge-red','audio'=>'badge-green',default=>'badge-purple' } }}">{{ ucfirst($item->media_type) }}</span>
                <span class="badge badge-gray">{{ $item->category->name }}</span>
                @if($item->is_featured)<span class="badge badge-yellow">⭐ Featured</span>@endif
            </div>
            <h1 style="font-size:1.75rem;font-weight:900;margin-bottom:0.75rem;">{{ $item->title }}</h1>
            @if($item->description)
            <p style="color:var(--text-secondary);line-height:1.7;margin-bottom:1.5rem;">{{ $item->description }}</p>
            @endif

            @if($item->tags)
            <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:1.5rem;">
                @foreach($item->tags as $tag)
                <span class="badge badge-purple">#{{ $tag }}</span>
                @endforeach
            </div>
            @endif

            {{-- Actions --}}
            <div style="display:flex;gap:0.75rem;flex-wrap:wrap;align-items:center;margin-bottom:2rem;">
                @auth
                <button class="btn btn-secondary btn-sm" data-bookmark-btn data-type="media" data-id="{{ $item->id }}" title="{{ $isBookmarked ? 'Remove bookmark' : 'Bookmark' }}">
                    {{ $isBookmarked ? '🔖 Bookmarked' : '🔖 Bookmark' }}
                </button>
                @endauth
                <span style="color:var(--text-secondary);font-size:0.85rem;">👁 {{ number_format($item->view_count) }} views</span>
            </div>

            {{-- Rating --}}
            @auth
            <div class="card" style="padding:1.25rem;margin-bottom:2rem;">
                <h3 style="font-size:0.95rem;font-weight:700;margin-bottom:1rem;">Rate This Media</h3>
                <form method="POST" action="{{ route('multimedia.rate', $item->id) }}">
                    @csrf
                    <div style="display:flex;flex-direction:column;gap:1rem;">
                        <div>
                            <div style="font-size:0.85rem;color:var(--text-secondary);margin-bottom:0.5rem;">Star Rating</div>
                            <div class="star-rating star-rating-interactive">
                                @for($i = 1; $i <= 5; $i++)
                                <span class="star {{ $userRating && $userRating->score >= $i ? 'filled' : '' }}" style="font-size:1.5rem;cursor:pointer;">★</span>
                                @endfor
                                <input type="hidden" name="score" value="{{ $userRating?->score }}">
                            </div>
                        </div>
                        <div>
                            <div style="font-size:0.85rem;color:var(--text-secondary);margin-bottom:0.5rem;">Quick Reaction</div>
                            <div style="display:flex;gap:0.5rem;">
                                <label style="cursor:pointer;">
                                    <input type="radio" name="thumbs_up" value="1" {{ $userRating?->thumbs_up === true ? 'checked' : '' }} style="display:none;" onchange="this.form.submit()">
                                    <span class="btn btn-secondary btn-sm {{ $userRating?->thumbs_up === true ? 'active' : '' }}">👍 Good</span>
                                </label>
                                <label style="cursor:pointer;">
                                    <input type="radio" name="thumbs_up" value="0" {{ $userRating?->thumbs_up === false ? 'checked' : '' }} style="display:none;" onchange="this.form.submit()">
                                    <span class="btn btn-secondary btn-sm {{ $userRating?->thumbs_up === false ? 'active' : '' }}">👎 Not for me</span>
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Save Rating</button>
                    </div>
                </form>
            </div>
            @endauth

            {{-- Average rating display --}}
            <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:2rem;">
                <div class="star-rating">
                    @for($i = 1; $i <= 5; $i++)
                    <span class="star {{ $item->average_rating >= $i ? 'filled' : '' }}">★</span>
                    @endfor
                </div>
                <span style="color:var(--text-secondary);font-size:0.85rem;">{{ $item->average_rating }}/5 ({{ $item->ratings()->count() }} ratings)</span>
            </div>
        </div>

        {{-- Sidebar --}}
        <div>
            <div class="card" style="padding:1.25rem;margin-bottom:1.25rem;">
                <h3 style="font-size:0.9rem;font-weight:700;margin-bottom:1rem;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;">Details</h3>
                <div style="display:flex;flex-direction:column;gap:0.6rem;font-size:0.85rem;">
                    <div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Type</span><span>{{ ucfirst($item->media_type) }}</span></div>
                    <div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Category</span><span>{{ $item->category->name }}</span></div>
                    @if($item->duration)<div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Duration</span><span>{{ $item->duration }}</span></div>@endif
                    <div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Views</span><span>{{ number_format($item->view_count) }}</span></div>
                    <div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Rating</span><span>{{ $item->average_rating }}/5</span></div>
                </div>
            </div>

            @if($related->count())
            <div class="card" style="padding:1.25rem;">
                <h3 style="font-size:0.9rem;font-weight:700;margin-bottom:1rem;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;">More Like This</h3>
                <div style="display:flex;flex-direction:column;gap:0.75rem;">
                    @foreach($related as $r)
                    <a href="{{ route('multimedia.show', $r->id) }}" style="display:flex;gap:0.75rem;text-decoration:none;align-items:center;">
                        <div style="width:44px;height:44px;border-radius:8px;background:rgba(74,38,183,0.2);display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;">
                            {{ match($r->media_type) { 'trailer' => '🎬', 'audio' => '🎵', default => '▶️' } }}
                        </div>
                        <div style="min-width:0;">
                            <div style="font-size:0.82rem;font-weight:600;color:var(--text-main);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Str::limit($r->title, 35) }}</div>
                            <div style="font-size:0.72rem;color:var(--text-secondary);">{{ ucfirst($r->media_type) }}</div>
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
