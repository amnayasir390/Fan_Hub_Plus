@extends('layouts.app')
@section('title', 'Character Profiles')

@section('content')
<div class="container py-section">

    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-sep">/</span>
        <span>Characters</span>
    </div>

    <div class="section-header">
        <h1 class="section-title">👥 Character Profiles</h1>
        <span style="color:var(--text-secondary);font-size:0.875rem;">{{ $characters->total() }} characters</span>
    </div>

    <form method="GET" action="{{ route('characters.index') }}">
        <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:12px;padding:1.25rem;margin-bottom:2rem;display:flex;flex-wrap:wrap;gap:0.75rem;align-items:center;">
            <div class="search-bar" style="flex:1;min-width:200px;">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" class="form-input" placeholder="Search by name, series…" value="{{ request('search') }}">
            </div>
            <select name="category" class="form-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Fandoms</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->icon }} {{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="genre" class="form-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Genres</option>
                @foreach($genres as $genre)
                <option value="{{ $genre }}" {{ request('genre') === $genre ? 'selected' : '' }}>{{ $genre }}</option>
                @endforeach
            </select>
            <select name="sort" class="form-select" style="width:auto;" onchange="this.form.submit()">
                <option value="popular" {{ request('sort','popular') === 'popular' ? 'selected' : '' }}>Most Popular</option>
                <option value="alpha"   {{ request('sort') === 'alpha'   ? 'selected' : '' }}>A–Z</option>
                <option value="latest"  {{ request('sort') === 'latest'  ? 'selected' : '' }}>Newest</option>
            </select>
            <button type="submit" class="btn btn-primary">Apply</button>
            <a href="{{ route('characters.index') }}" class="btn btn-secondary">Clear</a>
        </div>
    </form>

    {{-- Category quick-chips --}}
    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:1.5rem;">
        <a href="{{ route('characters.index', request()->except('category')) }}" class="category-chip {{ !request('category') ? 'active' : '' }}">All</a>
        @foreach($categories as $cat)
        <a href="{{ route('characters.index', array_merge(request()->all(), ['category' => $cat->slug])) }}"
           class="category-chip {{ request('category') === $cat->slug ? 'active' : '' }}">{{ $cat->icon }} {{ $cat->name }}</a>
        @endforeach
    </div>

    @if($characters->count())
    <div class="grid-cards grid-auto-sm">
        @foreach($characters as $char)
        <a href="{{ route('characters.show', $char->slug) }}" class="card" style="text-decoration:none;text-align:center;">
            <div style="padding:1.5rem 1rem 0.75rem;display:flex;flex-direction:column;align-items:center;gap:0.75rem;">
                <x-image-or-icon :path="$char->image" icon="fa-user" size="90px" rounded alt="{{ $char->name }}" style="border:2px solid var(--border);" />
                <div>
                    <div class="card-title">{{ $char->name }}</div>
                    <div class="card-meta">{{ $char->series }}</div>
                </div>
                <div style="display:flex;flex-wrap:wrap;gap:0.3rem;justify-content:center;">
                    <span class="badge badge-purple">{{ $char->category->name }}</span>
                    @if($char->genre)<span class="badge badge-gray">{{ $char->genre }}</span>@endif
                </div>
                @if($char->abilities)
                <div style="font-size:0.75rem;color:var(--text-secondary);text-align:center;">
                    {{ implode(' · ', array_slice($char->abilities, 0, 2)) }}
                </div>
                @endif
            </div>
        </a>
        @endforeach
    </div>
    <div class="pagination">{{ $characters->links('vendor.pagination.custom') }}</div>
    @else
    <div style="text-align:center;padding:4rem;background:var(--bg-card);border-radius:12px;border:1px solid var(--border);">
        <div style="font-size:3rem;margin-bottom:1rem;">👥</div>
        <h3>No characters found</h3>
        <p style="color:var(--text-secondary);margin-bottom:1rem;">Try different filters.</p>
        <a href="{{ route('characters.index') }}" class="btn btn-primary">Clear Filters</a>
    </div>
    @endif
</div>
@endsection
