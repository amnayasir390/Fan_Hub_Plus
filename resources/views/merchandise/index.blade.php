@extends('layouts.app')
@section('title', 'Merchandise Showcase')

@section('content')
<div class="container py-section">

    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">/</span><span>Merchandise</span>
    </div>

    <div class="section-header">
        <h1 class="section-title">🛍️ Merchandise Showcase</h1>
        <span style="color:var(--text-secondary);font-size:0.875rem;">{{ $merchandise->total() }} items</span>
    </div>

    {{-- Upcoming Releases --}}
    @if($upcomingReleases->count())
    <div style="margin-bottom:2.5rem;">
        <h2 style="font-size:1rem;font-weight:800;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:1rem;">🚀 Upcoming Releases</h2>
        <div style="display:flex;gap:1rem;overflow-x:auto;padding-bottom:0.5rem;">
            @foreach($upcomingReleases as $item)
            <a href="{{ route('merchandise.show', $item->slug) }}" class="card" style="text-decoration:none;flex:0 0 200px;min-width:200px;">
                <x-image-or-icon :path="$item->image" icon="fa-bag-shopping" size="100px" alt="{{ $item->name }}" style="width:100%;border-radius:0;" />
                <div class="card-body" style="padding:0.75rem;">
                    <div style="font-size:0.78rem;font-weight:700;color:var(--text-main);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $item->name }}</div>
                    <div style="font-size:0.7rem;color:var(--purple-light);">📅 {{ $item->release_date->format('M d, Y') }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Filters --}}
    <form method="GET" action="{{ route('merchandise.index') }}">
        <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:12px;padding:1.25rem;margin-bottom:1.5rem;display:flex;flex-wrap:wrap;gap:0.75rem;align-items:center;">
            <div class="search-bar" style="flex:1;min-width:200px;">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" class="form-input" placeholder="Search merchandise…" value="{{ request('search') }}">
            </div>
            <select name="category" class="form-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Fandoms</option>
                @foreach($categories as $cat)<option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->icon }} {{ $cat->name }}</option>@endforeach
            </select>
            <select name="badge" class="form-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Badges</option>
                <option value="Limited Edition" {{ request('badge') === 'Limited Edition' ? 'selected' : '' }}>Limited Edition</option>
                <option value="Pre-Order"       {{ request('badge') === 'Pre-Order'       ? 'selected' : '' }}>Pre-Order</option>
                <option value="Collectible"     {{ request('badge') === 'Collectible'     ? 'selected' : '' }}>Collectible</option>
            </select>
            <select name="status" class="form-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
                <option value="pre-order" {{ request('status') === 'pre-order' ? 'selected' : '' }}>Pre-Order</option>
                <option value="sold-out"  {{ request('status') === 'sold-out'  ? 'selected' : '' }}>Sold Out</option>
            </select>
            <select name="sort" class="form-select" style="width:auto;" onchange="this.form.submit()">
                <option value="popular"  {{ request('sort','popular') === 'popular'  ? 'selected' : '' }}>Most Popular</option>
                <option value="latest"   {{ request('sort') === 'latest'   ? 'selected' : '' }}>Newest</option>
                <option value="price_lo" {{ request('sort') === 'price_lo' ? 'selected' : '' }}>Price ↑</option>
                <option value="price_hi" {{ request('sort') === 'price_hi' ? 'selected' : '' }}>Price ↓</option>
                <option value="alpha"    {{ request('sort') === 'alpha'    ? 'selected' : '' }}>A–Z</option>
            </select>
            <button type="submit" class="btn btn-primary">Apply</button>
            <a href="{{ route('merchandise.index') }}" class="btn btn-secondary">Clear</a>
        </div>
    </form>

    @if($merchandise->count())
    <div class="grid-cards grid-auto">
        @foreach($merchandise as $item)
        <a href="{{ route('merchandise.show', $item->slug) }}" class="card" style="text-decoration:none;">
            <div style="position:relative;">
                <x-image-or-icon :path="$item->image" icon="fa-bag-shopping" size="150px" alt="{{ $item->name }}" style="width:100%;border-radius:0;" />
                @if($item->badge)
                <div style="position:absolute;top:0.5rem;left:0.5rem;">
                    <span class="badge {{ $item->badge === 'Limited Edition' ? 'badge-red' : ($item->badge === 'Pre-Order' ? 'badge-yellow' : 'badge-green') }}">{{ $item->badge }}</span>
                </div>
                @endif
                @if($item->status === 'sold-out')
                <div style="position:absolute;inset:0;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;">
                    <span class="badge badge-gray" style="font-size:0.9rem;padding:0.4rem 0.8rem;">SOLD OUT</span>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="card-title">{{ $item->name }}</div>
                <div class="card-meta">{{ $item->category->name }}</div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-top:0.5rem;">
                    @if($item->price)
                    <span style="font-weight:700;color:var(--purple-light);font-size:1rem;">${{ number_format($item->price, 2) }}</span>
                    @else<span></span>@endif
                    @if($item->release_date && $item->release_date->isFuture())
                    <span style="font-size:0.75rem;color:var(--text-secondary);">📅 {{ $item->release_date->format('M d, Y') }}</span>
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
    <div class="pagination">{{ $merchandise->links('vendor.pagination.custom') }}</div>
    @else
    <div style="text-align:center;padding:4rem;background:var(--bg-card);border-radius:12px;border:1px solid var(--border);">
        <div style="font-size:3rem;margin-bottom:1rem;">🛍️</div>
        <h3>No merchandise found</h3>
        <a href="{{ route('merchandise.index') }}" class="btn btn-primary" style="margin-top:1rem;">Clear Filters</a>
    </div>
    @endif
</div>
@endsection
