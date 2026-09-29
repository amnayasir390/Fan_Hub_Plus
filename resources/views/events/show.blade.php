@extends('layouts.app')
@section('title', $event->title)

@section('content')
<div class="container py-section">
    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">/</span>
        <a href="{{ route('events.index') }}">Events</a><span class="breadcrumb-sep">/</span>
        <span>{{ Str::limit($event->title, 40) }}</span>
    </div>

    <div style="display:grid;grid-template-columns:1fr 300px;gap:2rem;align-items:start;">
        <div>
            <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-bottom:1rem;">
                <span class="badge badge-purple">{{ ucfirst($event->event_type) }}</span>
                @if($event->category)<span class="badge badge-gray">{{ $event->category->name }}</span>@endif
                @if($event->is_featured)<span class="badge badge-yellow">⭐ Featured</span>@endif
                @if($event->start_date->isFuture())<span class="badge badge-green">Upcoming</span>
                @else<span class="badge badge-gray">Past Event</span>@endif
            </div>

            <h1 style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:900;margin-bottom:1.5rem;line-height:1.2;">{{ $event->title }}</h1>

            {{-- Key info cards --}}
            <div class="grid-cards grid-2" style="margin-bottom:1.5rem;">
                <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:10px;padding:1rem;display:flex;gap:0.75rem;align-items:center;">
                    <span style="font-size:1.5rem;">📅</span>
                    <div>
                        <div style="font-size:0.72rem;color:var(--text-secondary);font-weight:700;text-transform:uppercase;letter-spacing:0.05em;">Date</div>
                        <div style="font-weight:700;font-size:0.9rem;">{{ $event->start_date->format('M d, Y') }}</div>
                        @if($event->end_date && $event->end_date->format('Y-m-d') !== $event->start_date->format('Y-m-d'))
                        <div style="font-size:0.78rem;color:var(--text-secondary);">to {{ $event->end_date->format('M d, Y') }}</div>
                        @endif
                    </div>
                </div>
                <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:10px;padding:1rem;display:flex;gap:0.75rem;align-items:center;">
                    <span style="font-size:1.5rem;">⏰</span>
                    <div>
                        <div style="font-size:0.72rem;color:var(--text-secondary);font-weight:700;text-transform:uppercase;letter-spacing:0.05em;">Time</div>
                        <div style="font-weight:700;font-size:0.9rem;">{{ $event->start_date->format('g:i A') }}</div>
                    </div>
                </div>
                <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:10px;padding:1rem;display:flex;gap:0.75rem;align-items:center;">
                    <span style="font-size:1.5rem;">📍</span>
                    <div>
                        <div style="font-size:0.72rem;color:var(--text-secondary);font-weight:700;text-transform:uppercase;letter-spacing:0.05em;">Location</div>
                        @if($event->venue)<div style="font-weight:700;font-size:0.9rem;">{{ $event->venue }}</div>@endif
                        <div style="font-size:0.78rem;color:var(--text-secondary);">{{ $event->city }}@if($event->country), {{ $event->country }}@endif</div>
                    </div>
                </div>
                <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:10px;padding:1rem;display:flex;gap:0.75rem;align-items:center;">
                    <span style="font-size:1.5rem;">🎭</span>
                    <div>
                        <div style="font-size:0.72rem;color:var(--text-secondary);font-weight:700;text-transform:uppercase;letter-spacing:0.05em;">Type</div>
                        <div style="font-weight:700;font-size:0.9rem;">{{ ucfirst($event->event_type) }}</div>
                    </div>
                </div>
            </div>

            @if($event->description)
            <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:12px;padding:1.5rem;margin-bottom:1.5rem;">
                <h2 style="font-size:1rem;font-weight:700;margin-bottom:0.75rem;">About This Event</h2>
                <p style="color:var(--text-secondary);line-height:1.8;">{{ $event->description }}</p>
            </div>
            @endif

            {{-- Map --}}
            @if($event->latitude && $event->longitude)
            <div style="margin-bottom:1.5rem;">
                <h2 style="font-size:1rem;font-weight:700;margin-bottom:0.75rem;">📍 Venue Map</h2>
                <div id="event-detail-map" style="height:280px;border-radius:12px;border:1px solid var(--border);"></div>
            </div>
            @endif

            @if($event->ticket_link)
            <a href="{{ $event->ticket_link }}" target="_blank" rel="noopener" class="btn btn-primary btn-lg">🎟️ Get Tickets</a>
            @endif
        </div>

        {{-- Sidebar --}}
        <div>
            <div class="card" style="padding:1.25rem;margin-bottom:1rem;">
                <h3 style="font-size:0.85rem;font-weight:700;margin-bottom:1rem;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;">Event Details</h3>
                <div style="display:flex;flex-direction:column;gap:0.7rem;font-size:0.875rem;">
                    <div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Starts</span><span>{{ $event->start_date->format('M d, Y g:i A') }}</span></div>
                    @if($event->end_date)<div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Ends</span><span>{{ $event->end_date->format('M d, Y g:i A') }}</span></div>@endif
                    @if($event->city)<div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">City</span><span>{{ $event->city }}</span></div>@endif
                    @if($event->country)<div style="display:flex;justify-content:space-between;"><span style="color:var(--text-secondary);">Country</span><span>{{ $event->country }}</span></div>@endif
                </div>
                @if($event->start_date->isFuture())
                <div style="margin-top:1rem;background:rgba(74,38,183,0.1);border-radius:8px;padding:0.75rem;text-align:center;">
                    <div style="font-size:0.78rem;color:var(--text-secondary);">Time until event</div>
                    <div style="font-weight:700;color:var(--purple-light);">{{ $event->start_date->diffForHumans() }}</div>
                </div>
                @endif
            </div>

            @if($related->count())
            <div class="card" style="padding:1.25rem;">
                <h3 style="font-size:0.85rem;font-weight:700;margin-bottom:1rem;color:var(--text-secondary);text-transform:uppercase;letter-spacing:0.05em;">More Events</h3>
                <div style="display:flex;flex-direction:column;gap:0.75rem;">
                    @foreach($related as $r)
                    <a href="{{ route('events.show', $r->id) }}" style="display:flex;gap:0.75rem;text-decoration:none;align-items:center;">
                        <div style="background:rgba(74,38,183,0.2);border-radius:8px;padding:0.4rem 0.5rem;text-align:center;flex-shrink:0;min-width:42px;">
                            <div style="font-size:0.9rem;font-weight:900;color:var(--purple-light);">{{ $r->start_date->format('d') }}</div>
                            <div style="font-size:0.6rem;color:var(--text-secondary);text-transform:uppercase;">{{ $r->start_date->format('M') }}</div>
                        </div>
                        <div>
                            <div style="font-size:0.82rem;font-weight:600;color:var(--text-main);">{{ Str::limit($r->title, 35) }}</div>
                            <div style="font-size:0.72rem;color:var(--text-secondary);">{{ $r->city }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@if($event->latitude && $event->longitude)
@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('event-detail-map').setView([{{ $event->latitude }}, {{ $event->longitude }}], 14);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap © CARTO', maxZoom: 19
    }).addTo(map);
    const icon = L.divIcon({
        html: '<div style="width:18px;height:18px;border-radius:50%;background:#4A26B7;border:3px solid #A78BFA;box-shadow:0 0 12px rgba(74,38,183,0.9);"></div>',
        className: '', iconSize: [18, 18], iconAnchor: [9, 9]
    });
    L.marker([{{ $event->latitude }}, {{ $event->longitude }}], { icon })
        .addTo(map)
        .bindPopup('<strong>{{ addslashes($event->title) }}</strong><br>{{ addslashes($event->venue ?? '') }}')
        .openPopup();
});
</script>
@endpush
@endif
@endsection
