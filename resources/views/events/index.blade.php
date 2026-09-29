@extends('layouts.app')
@section('title', 'Events & Calendar')

@section('content')
<div class="container py-section">
    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">/</span><span>Events</span>
    </div>

    <div class="section-header">
        <h1 class="section-title">📅 Events & Calendar</h1>
        <span style="color:var(--text-secondary);font-size:0.875rem;">{{ $events->total() }} events</span>
    </div>

    {{-- Interactive Map --}}
    <div style="margin-bottom:2rem;">
        <div id="events-map" style="height:380px;width:100%;background:var(--bg-card);border:1px solid var(--border);border-radius:12px;display:flex;align-items:center;justify-content:center;overflow:hidden;">
            <div id="map-loading" style="text-align:center;color:var(--text-secondary);">
                <div style="font-size:2.5rem;margin-bottom:0.5rem;">🗺️</div>
                <p style="font-size:0.875rem;">Loading map…</p>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('events.index') }}">
        <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:12px;padding:1.25rem;margin-bottom:1.5rem;display:flex;flex-wrap:wrap;gap:0.75rem;align-items:center;">
            <div class="search-bar" style="flex:1;min-width:200px;">
                <span class="search-icon">🔍</span>
                <input type="text" name="search" class="form-input" placeholder="Search events…" value="{{ request('search') }}">
            </div>
            <select name="category" class="form-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Fandoms</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->icon }} {{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="type" class="form-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Types</option>
                <option value="convention" {{ request('type') === 'convention' ? 'selected' : '' }}>Convention</option>
                <option value="meetup"     {{ request('type') === 'meetup'     ? 'selected' : '' }}>Meetup</option>
                <option value="screening"  {{ request('type') === 'screening'  ? 'selected' : '' }}>Screening</option>
                <option value="premiere"   {{ request('type') === 'premiere'   ? 'selected' : '' }}>Premiere</option>
                <option value="release"    {{ request('type') === 'release'    ? 'selected' : '' }}>Release</option>
            </select>
            <select name="city" class="form-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Cities</option>
                @foreach($cities as $city)
                <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Apply</button>
            <a href="{{ route('events.index') }}" class="btn btn-secondary">Clear</a>
        </div>
    </form>

    @if($events->count())
    <div class="grid-cards grid-3">
        @foreach($events as $event)
        <a href="{{ route('events.show', $event->id) }}" class="card" style="text-decoration:none;">
            <div style="padding:1.25rem;display:flex;gap:1rem;">
                {{-- Date badge --}}
                <div style="background:rgba(74,38,183,0.2);border-radius:10px;padding:0.75rem 0.875rem;text-align:center;flex-shrink:0;">
                    <div style="font-size:1.4rem;font-weight:900;color:var(--purple-light);line-height:1;">{{ $event->start_date->format('d') }}</div>
                    <div style="font-size:0.65rem;color:var(--text-secondary);font-weight:700;text-transform:uppercase;">{{ $event->start_date->format('M') }}</div>
                    <div style="font-size:0.6rem;color:var(--text-secondary);">{{ $event->start_date->format('Y') }}</div>
                </div>
                <div style="min-width:0;">
                    <div style="display:flex;flex-wrap:wrap;gap:0.3rem;margin-bottom:0.4rem;">
                        <span class="badge badge-purple">{{ ucfirst($event->event_type) }}</span>
                        @if($event->is_featured)<span class="badge badge-yellow">⭐</span>@endif
                    </div>
                    <div style="font-weight:700;font-size:0.9rem;color:var(--text-main);margin-bottom:0.25rem;">{{ $event->title }}</div>
                    @if($event->venue)<div style="font-size:0.78rem;color:var(--text-secondary);">🏛️ {{ $event->venue }}</div>@endif
                    <div style="font-size:0.78rem;color:var(--text-secondary);">📍 {{ $event->city }}@if($event->country), {{ $event->country }}@endif</div>
                    @if($event->ticket_link)
                    <div style="margin-top:0.5rem;">
                        <span style="font-size:0.75rem;color:var(--purple-light);font-weight:600;">🎟️ Tickets Available</span>
                    </div>
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
    <div class="pagination">{{ $events->links('vendor.pagination.custom') }}</div>
    @else
    <div style="text-align:center;padding:4rem;background:var(--bg-card);border-radius:12px;border:1px solid var(--border);">
        <div style="font-size:3rem;margin-bottom:1rem;">📅</div>
        <h3>No events found</h3>
        <p style="color:var(--text-secondary);margin-bottom:1rem;">Try different filters or check back later.</p>
        <a href="{{ route('events.index') }}" class="btn btn-primary">Clear Filters</a>
    </div>
    @endif
</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapEl = document.getElementById('events-map');
    const loading = document.getElementById('map-loading');
    if (!mapEl) return;

    loading.style.display = 'none';

    const map = L.map('events-map', { zoomControl: true }).setView([25, 10], 2);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap © CARTO',
        subdomains: 'abcd',
        maxZoom: 19
    }).addTo(map);

    const events = @json($mapEvents);

    const icon = L.divIcon({
        html: '<div style="width:14px;height:14px;border-radius:50%;background:#4A26B7;border:2px solid #A78BFA;box-shadow:0 0 8px rgba(74,38,183,0.8);"></div>',
        className: '',
        iconSize: [14, 14],
        iconAnchor: [7, 7],
        popupAnchor: [0, -10]
    });

    events.forEach(function (ev) {
        if (ev.latitude && ev.longitude) {
            const marker = L.marker([ev.latitude, ev.longitude], { icon }).addTo(map);
            marker.bindPopup(`
                <div style="font-family:Inter,sans-serif;min-width:160px;">
                    <div style="font-weight:700;font-size:0.85rem;margin-bottom:0.25rem;">${ev.title}</div>
                    <div style="font-size:0.75rem;color:#687589;">📍 ${ev.city}</div>
                    <div style="font-size:0.75rem;color:#687589;margin-top:0.2rem;">📅 ${new Date(ev.start_date).toLocaleDateString()}</div>
                    ${ev.ticket_link ? `<a href="${ev.ticket_link}" target="_blank" style="font-size:0.75rem;color:#6B47D6;font-weight:600;display:block;margin-top:0.4rem;">🎟️ Get Tickets</a>` : ''}
                </div>
            `);
        }
    });
});
</script>
@endpush
@endsection
