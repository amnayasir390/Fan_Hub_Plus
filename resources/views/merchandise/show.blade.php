@extends('layouts.app')
@section('title', $item->name)

@section('content')
<div class="container py-section">
    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">/</span>
        <a href="{{ route('merchandise.index') }}">Merchandise</a><span class="breadcrumb-sep">/</span>
        <span>{{ Str::limit($item->name, 40) }}</span>
    </div>

    <div style="display:grid;grid-template-columns:1fr 320px;gap:2rem;align-items:start;">
        <div>
            {{-- Main image --}}
            <div style="border:1px solid var(--border);border-radius:16px;height:360px;margin-bottom:1.5rem;position:relative;overflow:hidden;">
                <x-image-or-icon :path="$item->image" icon="fa-bag-shopping" size="100%" alt="{{ $item->name }}" style="height:100%;width:100%;border-radius:0;" />
                @if($item->status === 'sold-out')
                <div style="position:absolute;inset:0;background:rgba(0,0,0,0.55);display:flex;align-items:center;justify-content:center;border-radius:16px;">
                    <span style="font-size:1.5rem;font-weight:900;color:#FCA5A5;border:3px solid #FCA5A5;padding:0.5rem 1.5rem;border-radius:8px;transform:rotate(-8deg);">SOLD OUT</span>
                </div>
                @endif
            </div>

            <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:1rem;">
                <span class="badge badge-purple">{{ $item->category->name }}</span>
                @if($item->badge)
                    <span class="badge {{ $item->badge === 'Limited Edition' ? 'badge-red' : ($item->badge === 'Pre-Order' ? 'badge-yellow' : 'badge-green') }}">{{ $item->badge }}</span>
                @endif
                @if($item->status === 'pre-order')<span class="badge badge-yellow">Pre-Order</span>@endif
            </div>

            <h1 style="font-size:1.75rem;font-weight:900;margin-bottom:0.5rem;">{{ $item->name }}</h1>

            @if($item->price)
            <div style="font-size:2rem;font-weight:900;color:var(--purple-light);margin-bottom:1rem;">${{ number_format($item->price, 2) }}</div>
            @endif

            @if($item->description)
            <p style="color:var(--text-secondary);line-height:1.7;margin-bottom:1.5rem;font-size:0.95rem;">{{ $item->description }}</p>
            @endif

            <div style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-bottom:2rem;">
                @if($item->buy_link && $item->status !== 'sold-out')
                <a href="{{ $item->buy_link }}" target="_blank" rel="noopener" class="btn btn-primary btn-lg">
                    🛒 {{ $item->status === 'pre-order' ? 'Pre-Order Now' : 'Buy Now' }}
                </a>
                @endif
                @auth
                <button class="btn btn-secondary" data-bookmark-btn data-type="merchandise" data-id="{{ $item->id }}">
                    {{ $isBookmarked ? '🔖 Bookmarked' : '🔖 Bookmark' }}
                </button>
                @endauth
            </div>

            @if($item->release_date && $item->release_date->isFuture())
            <div class="alert alert-info">
                📅 Releases on <strong>{{ $item->release_date->format('F j, Y') }}</strong>
                ({{ $item->release_date->diffForHumans() }})
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div>
            <div class="card" style="padding:1.25rem;margin-bottom:1rem;">
                <h3 style="font-size:0.85rem;font-weight:700;margin-bottom:1rem;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;">Product Details</h3>
                <div style="display:flex;flex-direction:column;gap:0.7rem;font-size:0.875rem;">
                    <div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Category</span><span>{{ $item->category->name }}</span></div>
                    @if($item->badge)<div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Badge</span><span>{{ $item->badge }}</span></div>@endif
                    <div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Status</span>
                        <span class="badge {{ $item->status === 'available' ? 'badge-green' : ($item->status === 'pre-order' ? 'badge-yellow' : 'badge-gray') }}">{{ ucfirst($item->status) }}</span>
                    </div>
                    @if($item->release_date)<div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Release Date</span><span>{{ $item->release_date->format('M d, Y') }}</span></div>@endif
                    <div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Views</span><span>{{ number_format($item->view_count) }}</span></div>
                    <div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Popularity</span><span>{{ $item->popularity }}%</span></div>
                </div>
            </div>

            @if($related->count())
            <div class="card" style="padding:1.25rem;">
                <h3 style="font-size:0.85rem;font-weight:700;margin-bottom:1rem;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;">More from {{ $item->category->name }}</h3>
                <div style="display:flex;flex-direction:column;gap:0.75rem;">
                    @foreach($related as $r)
                    <a href="{{ route('merchandise.show', $r->slug) }}" style="display:flex;gap:0.75rem;text-decoration:none;align-items:center;">
                        <div style="width:44px;height:44px;border-radius:8px;background:rgba(74,38,183,0.2);display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0;">
                            {{ $item->category->icon ?? '🛍️' }}
                        </div>
                        <div style="min-width:0;">
                            <div style="font-size:0.82rem;font-weight:600;color:var(--text-main);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ Str::limit($r->name, 35) }}</div>
                            @if($r->price)<div style="font-size:0.75rem;color:var(--purple-light);">${{ number_format($r->price, 2) }}</div>@endif
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
