@extends('layouts.app')
@section('title', 'Multimedia Center')

@section('content')
<div class="container py-section">

    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-sep">/</span>
        <span>Multimedia Center</span>
    </div>

    <div class="section-header">
        <h1 class="section-title">🎬 Multimedia Center</h1>
        <span style="color:var(--text-secondary);font-size:0.875rem;">{{ $mediaItems->total() }} items</span>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('multimedia.index') }}">
        <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:12px;padding:1.25rem;margin-bottom:2rem;display:flex;flex-wrap:wrap;gap:0.75rem;align-items:center;">
            <div class="search-bar" style="flex:1;min-width:200px;">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" class="form-input" placeholder="Search media…" value="{{ request('search') }}">
            </div>
            <select name="category" class="form-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->icon }} {{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="type" class="form-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Types</option>
                <option value="trailer" {{ request('type') === 'trailer' ? 'selected' : '' }}>🎬 Trailers</option>
                <option value="video"   {{ request('type') === 'video'   ? 'selected' : '' }}>▶️ Videos</option>
                <option value="audio"   {{ request('type') === 'audio'   ? 'selected' : '' }}>🎵 Audio</option>
                <option value="image"   {{ request('type') === 'image'   ? 'selected' : '' }}>🖼️ Gallery</option>
            </select>
            <select name="sort" class="form-select" style="width:auto;" onchange="this.form.submit()">
                <option value="featured" {{ request('sort','featured') === 'featured' ? 'selected' : '' }}>Featured First</option>
                <option value="popular"  {{ request('sort') === 'popular'  ? 'selected' : '' }}>Most Viewed</option>
                <option value="latest"   {{ request('sort') === 'latest'   ? 'selected' : '' }}>Latest</option>
            </select>
            <button type="submit" class="btn btn-primary">Apply</button>
            <a href="{{ route('multimedia.index') }}" class="btn btn-secondary">Clear</a>
        </div>
    </form>

    {{-- Type quick-tabs --}}
    <div style="display:flex;gap:0.5rem;flex-wrap:wrap;margin-bottom:1.5rem;">
        @foreach(['' => 'All', 'trailer' => '🎬 Trailers', 'video' => '▶️ Videos', 'audio' => '🎵 Audio', 'image' => '🖼️ Gallery'] as $val => $label)
        <a href="{{ route('multimedia.index', array_merge(request()->all(), ['type' => $val ?: null])) }}"
           class="category-chip {{ request('type', '') === $val ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
    </div>

    @if($mediaItems->count())
    <div class="grid-cards grid-auto">
        @foreach($mediaItems as $item)
        <a href="{{ route('multimedia.show', $item->id) }}" class="card" style="text-decoration:none;">
            <div style="position:relative;">
                <div class="card-img" style="background:linear-gradient(135deg,#0f0c29,#302b63);display:flex;align-items:center;justify-content:center;font-size:3.5rem;">
                    {{ match($item->media_type) { 'trailer' => '🎬', 'video' => '▶️', 'audio' => '🎵', default => '🖼️' } }}
                </div>
                <div style="position:absolute;top:0.5rem;left:0.5rem;">
                    <span class="badge {{ match($item->media_type) { 'trailer'=>'badge-red','audio'=>'badge-green','image'=>'badge-yellow',default=>'badge-purple' } }}">
                        {{ ucfirst($item->media_type) }}
                    </span>
                </div>
                @if($item->is_featured)
                <div style="position:absolute;top:0.5rem;right:0.5rem;">
                    <span class="badge badge-yellow">⭐ Featured</span>
                </div>
                @endif
                {{-- Play button overlay --}}
                @if(in_array($item->media_type, ['video','trailer']))
                <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity 0.2s;" class="play-overlay">
                    <div style="width:56px;height:56px;border-radius:50%;background:rgba(74,38,183,0.85);display:flex;align-items:center;justify-content:center;font-size:1.5rem;">▶</div>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="card-title">{{ $item->title }}</div>
                <div class="card-meta">{{ $item->category->name }}@if($item->duration) · {{ $item->duration }}@endif · 👁 {{ number_format($item->view_count) }}</div>
            </div>
        </a>
        @endforeach
    </div>
    <div class="pagination">{{ $mediaItems->links('vendor.pagination.custom') }}</div>
    @else
    <div style="text-align:center;padding:4rem;background:var(--bg-card);border-radius:12px;border:1px solid var(--border);">
        <div style="font-size:3rem;margin-bottom:1rem;">🎬</div>
        <h3>No media found</h3>
        <p style="color:var(--text-secondary);margin-bottom:1rem;">Try different filters.</p>
        <a href="{{ route('multimedia.index') }}" class="btn btn-primary">Clear Filters</a>
    </div>
    @endif
</div>

<style>
.card:hover .play-overlay { opacity: 1 !important; }
</style>
@endsection
