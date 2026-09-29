@extends('layouts.app')
@section('title', $category->name)

@section('content')
<div style="background:linear-gradient(135deg,{{ $category->color }}22,var(--bg-main));border-bottom:1px solid var(--border);padding:3rem 0 2rem;">
    <div class="container">
        <div class="breadcrumbs">
            <a href="{{ route('home') }}">Home</a>
            <span class="breadcrumb-sep">/</span>
            <a href="{{ route('content.index') }}">Explore</a>
            <span class="breadcrumb-sep">/</span>
            <span>{{ $category->name }}</span>
        </div>
        <div style="display:flex;align-items:center;gap:1.5rem;margin-top:0.5rem;">
            <div style="font-size:4rem;">{{ $category->icon }}</div>
            <div>
                <h1 style="font-size:2.5rem;font-weight:900;">{{ $category->name }}</h1>
                <p style="color:var(--text-secondary);max-width:500px;">{{ $category->description }}</p>
            </div>
        </div>
    </div>
</div>

<div class="container py-section">
    @if($contents->count())
    <div class="grid-cards grid-auto">
        @foreach($contents as $item)
        <a href="{{ route('content.show', $item->slug) }}" class="card" style="text-decoration:none;">
            <div class="card-img" style="background:linear-gradient(135deg,{{ $category->color }}33,var(--bg-card));display:flex;align-items:center;justify-content:center;font-size:3rem;">
                {{ $category->icon }}
            </div>
            <div class="card-body">
                <div class="card-title">{{ $item->title }}</div>
                <div class="card-excerpt">{{ $item->excerpt }}</div>
                <div class="card-meta" style="margin-top:0.5rem;">
                    @if($item->genre)<span class="badge badge-gray">{{ $item->genre }}</span>@endif
                    👁 {{ number_format($item->view_count) }} · ⭐ {{ $item->popularity }}%
                </div>
            </div>
        </a>
        @endforeach
    </div>
    <div class="pagination">{{ $contents->links('vendor.pagination.custom') }}</div>
    @else
    <div style="text-align:center;padding:4rem;">
        <div style="font-size:3rem;margin-bottom:1rem;">{{ $category->icon }}</div>
        <p style="color:var(--text-secondary);">No content yet in {{ $category->name }}. Check back soon!</p>
    </div>
    @endif
</div>
@endsection
