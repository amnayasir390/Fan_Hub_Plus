@extends('layouts.app')
@section('title', 'Home')

@push('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
@endpush

@section('content')

{{-- Hero --}}
<section class="hero" style="position:relative;overflow:hidden;margin:1.25rem;border-radius:16px;border:1px solid var(--border);min-height:380px;display:flex;align-items:center;">

    <div class="swiper hero-swiper" style="position:absolute;inset:0;z-index:0;--swiper-theme-color:#7C4DFF;--swiper-pagination-bullet-inactive-color:#fff;">
        <div class="swiper-wrapper">
            <div class="swiper-slide" style="background:linear-gradient(90deg,rgba(11,11,16,.92) 0%,rgba(11,11,16,.35) 100%),url('{{ asset('images/banner1.jpg') }}') center/cover no-repeat;"></div>
            <div class="swiper-slide" style="background:linear-gradient(90deg,rgba(11,11,16,.92) 0%,rgba(11,11,16,.35) 100%),url('{{ asset('images/banner2.jpg') }}') center/cover no-repeat;"></div>
            <div class="swiper-slide" style="background:linear-gradient(90deg,rgba(11,11,16,.92) 0%,rgba(11,11,16,.35) 100%),url('{{ asset('images/banner3.jpg') }}') center/cover no-repeat;"></div>
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <div class="container" style="position:relative;z-index:1;">
        <div style="max-width:700px;">
            <div style="margin-bottom:1rem;color:#A78BFA;"> Your Fandom Universe Awaits</div>
            <h1 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:900;line-height:1.1;margin-bottom:1rem;color:#fff;">
                Explore Every<br>
                <span style="color:#A78BFA;">Fandom Universe</span>
            </h1>
            <p style="font-size:1.1rem;margin-bottom:2rem;max-width:560px;line-height:1.7;color:#fff;">
                Anime, Gaming, Movies, TV Shows, K-Pop, Comics, Manga & Cosplay — all under one roof.
                Discover characters, watch trailers, explore merchandise, and connect with your community.
            </p>
            <div style="display:flex;gap:1rem;flex-wrap:wrap;">
                <a href="{{ route('content.index') }}" class="btn btn-primary btn-lg"> Start Exploring</a>
                @guest
                <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">Join Free</a>
                @endguest
                @auth
                <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-lg"><i class="fa-solid fa-chart-line"></i> My Dashboard</a>
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- BROWSE BY FANDOM -->
<section class="py-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Browse by Fandom</h2>
            <a href="{{ route('content.index') }}" class="btn btn-ghost btn-sm">View All <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="grid-cards grid-4">
            @foreach($categories as $cat)
            <a href="{{ route('content.category', $cat->slug) }}" class="cat-card" style="overflow:hidden;">
                @if($cat->cover_image)
                    <img src="{{ asset('images/categories/' . $cat->cover_image) }}" alt="{{ $cat->name }}" loading="lazy" style="width:100%;height:130px;object-fit:cover;display:block;">
                @endif
                <div class="cat-card-accent" style="background:{{ $cat->color }};"></div>
                <div class="cat-card-body">
                    <div class="cat-card-icon" style="color:{{ $cat->color }};"><i class="{{ $cat->icon }}"></i></div>
                    <div class="cat-card-name">{{ $cat->name }}</div>
                    <div class="cat-card-desc">{{ Str::limit($cat->description, 60) }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- TRENDING NOW -->
<section class="py-section" style="background:var(--bg-sidebar);border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><i class="fa-solid fa-fire"></i> Trending Now</h2>
            <a href="{{ route('content.index') }}" class="btn btn-ghost btn-sm">View All <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="grid-cards grid-auto">
            @foreach($featuredItems as $item)
            <a href="{{ route('content.show', $item->slug) }}" class="card" style="text-decoration:none;">
                <div style="position:relative;">
                    <x-image-or-icon :path="$item->cover_image" icon="fa-file-lines" size="180px" alt="{{ $item->title }}" style="width:100%;border-radius:0;" />
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
                    <div class="card-meta" style="margin-top:0.5rem;display:flex;gap:0.5rem;align-items:center;">
                        @if($item->genre)<span>{{ $item->genre }}</span><span>·</span>@endif
                        <span><i class="fa-solid fa-eye"></i> {{ number_format($item->view_count) }}</span>
                        <span>·</span>
                        <span><i class="fa-solid fa-star"></i> {{ $item->popularity }}%</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Media --}}
@if($featuredMedia->count())
<section class="py-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><i class="fa-solid fa-film"></i> Latest Media</h2>
            <a href="{{ route('multimedia.index') }}" class="btn btn-ghost btn-sm">View All <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="grid-cards grid-4">
            @foreach($featuredMedia as $media)
            <a href="{{ route('multimedia.show', $media->id) }}" class="card" style="text-decoration:none;">
                <div style="position:relative;">
                    <div class="card-img" style="background:linear-gradient(135deg,#1a1a2e,#16213e);display:flex;align-items:center;justify-content:center;font-size:3rem;">
                        <i class="fa-solid {{ match($media->media_type) { 'trailer' => 'fa-film', 'video' => 'fa-play', 'audio' => 'fa-music', default => 'fa-image' } }}"></i>
                    </div>
                    <div style="position:absolute;bottom:0.5rem;left:0.5rem;">
                        <span class="badge {{ match($media->media_type) { 'trailer'=>'badge-red','audio'=>'badge-green',default=>'badge-purple' } }}">
                            {{ ucfirst($media->media_type) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-title">{{ $media->title }}</div>
                    <div class="card-meta">{{ $media->category->name }} · <i class="fa-solid fa-eye"></i> {{ number_format($media->view_count) }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Featured Articles --}}
@if($featuredArticles->count())
<section class="py-section" style="background:var(--bg-sidebar);border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><i class="fa-solid fa-pen-to-square"></i> Featured Articles</h2>
            <a href="{{ route('articles.index') }}" class="btn btn-ghost btn-sm">View All <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="grid-cards grid-2" style="gap:1.5rem;">
            @foreach($featuredArticles as $article)
            <a href="{{ route('articles.show', $article->slug) }}" class="card" style="text-decoration:none;display:flex;gap:0;flex-direction:row;">
                <div style="width:120px;flex-shrink:0;background:linear-gradient(135deg,{{ $article->category->color ?? '#4A26B7' }}33,var(--bg-card));display:flex;align-items:center;justify-content:center;font-size:2.5rem;">
                    <x-image-or-icon :path="$article->cover_image" icon="fa-newspaper" size="120px" alt="{{ $article->title }}" style="width:100%;height:100%;border-radius:0;" />
                </div>
                <div class="card-body" style="flex:1;">
                    <div style="margin-bottom:0.25rem;"><span class="badge badge-purple">{{ $article->category->name }}</span></div>
                    <div class="card-title">{{ $article->title }}</div>
                    <div class="card-excerpt">{{ $article->excerpt }}</div>
                    <div class="card-meta" style="margin-top:0.5rem;"><i class="fa-solid fa-eye"></i> {{ number_format($article->view_count) }} views</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Featured Characters --}}
@if($featuredChars->count())
<section class="py-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><i class="fa-solid fa-users"></i> Fan Favourite Characters</h2>
            <a href="{{ route('characters.index') }}" class="btn btn-ghost btn-sm">View All <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="grid-cards grid-auto" style="grid-template-columns:repeat(auto-fill,minmax(180px,1fr));">
            @foreach($featuredChars as $char)
            <a href="{{ route('characters.show', $char->slug) }}" class="card" style="text-decoration:none;text-align:center;">
                <div style="padding:1.5rem 1rem 0.5rem;display:flex;flex-direction:column;align-items:center;gap:0.75rem;">
                    <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,{{ $char->category->color ?? '#4A26B7' }},#1F2228);display:flex;align-items:center;justify-content:center;font-size:2rem;border:2px solid var(--border);">
                        <x-image-or-icon :path="$char->image" icon="fa-user" size="80px" rounded alt="{{ $char->name }}" />
                    </div>
                    <div>
                        <div class="card-title" style="font-size:0.9rem;">{{ $char->name }}</div>
                        <div class="card-meta">{{ $char->series }}</div>
                    </div>
                    <span class="badge badge-purple">{{ $char->category->name }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Upcoming Events --}}
@if($upcomingEvents->count())
<section class="py-section" style="background:var(--bg-sidebar);border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><i class="fa-solid fa-calendar-days"></i> Upcoming Events</h2>
            <a href="{{ route('events.index') }}" class="btn btn-ghost btn-sm">View All <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="grid-cards grid-3">
            @foreach($upcomingEvents as $event)
            <a href="{{ route('events.show', $event->id) }}" class="card" style="text-decoration:none;">
                <div style="padding:1.25rem;display:flex;gap:1rem;align-items:flex-start;">
                    <div style="background:rgba(74,38,183,0.2);border-radius:10px;padding:0.75rem;text-align:center;min-width:56px;flex-shrink:0;">
                        <div style="font-size:1.25rem;font-weight:900;color:var(--purple-light);line-height:1;">{{ $event->start_date->format('d') }}</div>
                        <div style="font-size:0.65rem;color:var(--text-secondary);text-transform:uppercase;font-weight:700;">{{ $event->start_date->format('M') }}</div>
                    </div>
                    <div>
                        <div class="card-title" style="font-size:0.9rem;">{{ $event->title }}</div>
                        <div class="card-meta"><i class="fa-solid fa-location-dot"></i> {{ $event->city }}, {{ $event->country }}</div>
                        <div class="card-meta" style="margin-top:0.25rem;">
                            <span class="badge badge-purple" style="margin-top:0.25rem;">{{ ucfirst($event->event_type) }}</span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Featured Merch --}}
@if($featuredMerch->count())
<section class="py-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title"><i class="fa-solid fa-bag-shopping"></i> Featured Merchandise</h2>
            <a href="{{ route('merchandise.index') }}" class="btn btn-ghost btn-sm">View All <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="grid-cards grid-4">
            @foreach($featuredMerch as $merch)
            <a href="{{ route('merchandise.show', $merch->slug) }}" class="card" style="text-decoration:none;">
                <div style="position:relative;">
                    <div class="card-img" style="background:linear-gradient(135deg,{{ $merch->category->color ?? '#4A26B7' }}22,var(--bg-card));display:flex;align-items:center;justify-content:center;font-size:3rem;">
                        <x-image-or-icon :path="$merch->image" icon="fa-bag-shopping" size="180px" alt="{{ $merch->name }}" style="width:100%;border-radius:0;" />
                    </div>
                    @if($merch->badge)
                    <div style="position:absolute;top:0.5rem;right:0.5rem;">
                        <span class="badge {{ $merch->badge === 'Limited Edition' ? 'badge-red' : ($merch->badge === 'Pre-Order' ? 'badge-yellow' : 'badge-green') }}">{{ $merch->badge }}</span>
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="card-title" style="font-size:0.9rem;">{{ $merch->name }}</div>
                    <div class="card-meta">{{ $merch->category->name }}</div>
                    @if($merch->price)
                    <div style="margin-top:0.4rem;font-weight:700;color:var(--purple-light);">${{ number_format($merch->price, 2) }}</div>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
@guest
<section class="py-section" style="background:linear-gradient(135deg,#0D0820,var(--bg-main));border-top:1px solid var(--border);text-align:center;">
    <div class="container" style="max-width:600px;">
        <div style="font-size:3rem;margin-bottom:1rem;color:#A78BFA;"><i class="fa-solid fa-bolt"></i></div>
        <h2 style="font-size:2rem;font-weight:900;margin-bottom:0.75rem;">Join Fan Hub Plus Today</h2>
        <p style="color:var(--text-secondary);margin-bottom:2rem;line-height:1.7;">
            Create your free account to bookmark content, track your favourite fandoms,
            submit fan articles, and get personalised recommendations.
        </p>
        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Create Free Account</a>
            <a href="{{ route('login') }}" class="btn btn-secondary btn-lg">Sign In</a>
        </div>
    </div>
</section>
@endguest

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    new Swiper('.hero-swiper', {
        loop: true,
        effect: 'fade',
        speed: 1200,
        autoplay: { delay: 5000, disableOnInteraction: false },
        pagination: { el: '.swiper-pagination', clickable: true },
    });
</script>
@endpush