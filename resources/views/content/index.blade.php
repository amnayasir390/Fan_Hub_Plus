@extends('layouts.app')
@section('title', 'Content Explorer')

@section('content')
<div class="container py-section">

    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-sep">/</span>
        <span>Explore</span>
    </div>

    <div class="section-header">
        <h1 class="section-title">🔭 Content Explorer</h1>
        <span style="color:var(--text-secondary);font-size:0.875rem;">{{ $contents->total() }} items found</span>
    </div>

    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('content.index') }}" id="filter-form">
        <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:12px;padding:1.25rem;margin-bottom:2rem;">
            {{-- Search --}}
            <div style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-bottom:1rem;">
                <div class="search-bar" style="flex:1;min-width:200px;">
                    <span class="search-icon">🔍</span>
                    <input type="text" name="search" class="form-input" placeholder="Search titles, excerpts…" value="{{ request('search') }}">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="{{ route('content.index') }}" class="btn btn-secondary">Clear</a>
            </div>
            {{-- Filter chips --}}
            <div style="display:flex;flex-wrap:wrap;gap:0.5rem;align-items:center;">
                {{-- Category --}}
                <select name="category" class="form-select" style="width:auto;" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->icon }} {{ $cat->name }}</option>
                    @endforeach
                </select>
                {{-- Genre --}}
                <select name="genre" class="form-select" style="width:auto;" onchange="this.form.submit()">
                    <option value="">All Genres</option>
                    @foreach($genres as $genre)
                    <option value="{{ $genre }}" {{ request('genre') === $genre ? 'selected' : '' }}>{{ $genre }}</option>
                    @endforeach
                </select>
                {{-- Year --}}
                <select name="year" class="form-select" style="width:auto;" onchange="this.form.submit()">
                    <option value="">All Years</option>
                    @foreach($years as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
                {{-- Type --}}
                <select name="type" class="form-select" style="width:auto;" onchange="this.form.submit()">
                    <option value="">All Types</option>
                    <option value="article" {{ request('type') === 'article' ? 'selected' : '' }}>Article</option>
                    <option value="profile" {{ request('type') === 'profile' ? 'selected' : '' }}>Profile</option>
                    <option value="media"   {{ request('type') === 'media'   ? 'selected' : '' }}>Media</option>
                </select>
                {{-- Sort --}}
                <select name="sort" class="form-select" style="width:auto;" onchange="this.form.submit()">
                    <option value="popular" {{ request('sort','popular') === 'popular' ? 'selected' : '' }}>Most Popular</option>
                    <option value="latest"  {{ request('sort') === 'latest'  ? 'selected' : '' }}>Latest</option>
                    <option value="alpha"   {{ request('sort') === 'alpha'   ? 'selected' : '' }}>A–Z</option>
                    <option value="year"    {{ request('sort') === 'year'    ? 'selected' : '' }}>By Year</option>
                </select>
            </div>
        </div>
    </form>

    {{-- Category quick-chips --}}
    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:1.5rem;">
        <a href="{{ route('content.index', request()->except('category')) }}"
           class="category-chip {{ !request('category') ? 'active' : '' }}">All</a>
        @foreach($categories as $cat)
        <a href="{{ route('content.index', array_merge(request()->all(), ['category' => $cat->slug])) }}"
           class="category-chip {{ request('category') === $cat->slug ? 'active' : '' }}">
            {{ $cat->icon }} {{ $cat->name }}
        </a>
        @endforeach
    </div>

    {{-- Results --}}
    @if($contents->count())
    <div class="grid-cards grid-auto">
        @foreach($contents as $item)
        <a href="{{ route('content.show', $item->slug) }}" class="card" style="text-decoration:none;">
            <div style="position:relative;">
                <x-image-or-icon :path="$item->cover_image" icon="fa-file-lines" size="150px" alt="{{ $item->title }}" style="width:100%;border-radius:0;" />
                <div style="position:absolute;top:0.5rem;left:0.5rem;">
                    <span class="badge badge-purple">{{ $item->category->name }}</span>
                </div>
                @if($item->release_year)
                <div style="position:absolute;top:0.5rem;right:0.5rem;">
                    <span class="badge badge-gray">{{ $item->release_year }}</span>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="card-title">{{ $item->title }}</div>
                <div class="card-excerpt">{{ $item->excerpt }}</div>
                <div class="card-meta" style="margin-top:0.5rem;display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;">
                    @if($item->genre)<span class="badge badge-gray">{{ $item->genre }}</span>@endif
                    <span>👁 {{ number_format($item->view_count) }}</span>
                    <span>⭐ {{ $item->popularity }}%</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="pagination">
        {{ $contents->onEachSide(2)->links('vendor.pagination.custom') }}
    </div>
    @else
    <div style="text-align:center;padding:4rem 2rem;background:var(--bg-card);border-radius:12px;border:1px solid var(--border);">
        <div style="font-size:3rem;margin-bottom:1rem;">🔍</div>
        <h3 style="margin-bottom:0.5rem;">No content found</h3>
        <p style="color:var(--text-secondary);margin-bottom:1.5rem;">Try adjusting your filters or search terms.</p>
        <a href="{{ route('content.index') }}" class="btn btn-primary">Clear All Filters</a>
    </div>
    @endif
</div>
@endsection
