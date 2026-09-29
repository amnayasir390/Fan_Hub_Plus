@extends('layouts.admin')
@section('title', isset($event) ? 'Edit Event' : 'Add Event')

@section('content')
<div style="max-width:760px;">
    <a href="{{ route('admin.events.index') }}" class="btn btn-ghost btn-sm" style="margin-bottom:1.5rem;display:inline-flex;">← Back to Events</a>
    <div class="card" style="padding:2rem;">
        <form method="POST" action="{{ isset($event) ? route('admin.events.update', $event->id) : route('admin.events.store') }}">
            @csrf
            @if(isset($event)) @method('PUT') @endif

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" class="form-input" value="{{ old('title', $event->title ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Event Type *</label>
                    <select name="event_type" class="form-select" required>
                        @foreach(['convention','meetup','screening','premiere','release'] as $t)
                        <option value="{{ $t }}" {{ old('event_type', $event->event_type ?? 'convention') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">None</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $event->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Start Date & Time *</label>
                    <input type="datetime-local" name="start_date" class="form-input" value="{{ old('start_date', isset($event->start_date) ? $event->start_date->format('Y-m-d\TH:i') : '') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">End Date & Time</label>
                    <input type="datetime-local" name="end_date" class="form-input" value="{{ old('end_date', isset($event->end_date) ? $event->end_date->format('Y-m-d\TH:i') : '') }}">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Venue</label>
                    <input type="text" name="venue" class="form-input" value="{{ old('venue', $event->venue ?? '') }}" placeholder="e.g. Los Angeles Convention Center">
                </div>
                <div class="form-group">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-input" value="{{ old('city', $event->city ?? '') }}" placeholder="e.g. Los Angeles">
                </div>
                <div class="form-group">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" class="form-input" value="{{ old('country', $event->country ?? '') }}" placeholder="e.g. USA">
                </div>
                <div class="form-group">
                    <label class="form-label">Latitude</label>
                    <input type="number" name="latitude" class="form-input" step="0.0000001" value="{{ old('latitude', $event->latitude ?? '') }}" placeholder="e.g. 34.0430">
                </div>
                <div class="form-group">
                    <label class="form-label">Longitude</label>
                    <input type="number" name="longitude" class="form-input" step="0.0000001" value="{{ old('longitude', $event->longitude ?? '') }}" placeholder="e.g. -118.2673">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Ticket Link</label>
                    <input type="url" name="ticket_link" class="form-input" value="{{ old('ticket_link', $event->ticket_link ?? '') }}" placeholder="https://...">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-textarea" rows="4">{{ old('description', $event->description ?? '') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Featured?</label>
                    <label style="display:flex;align-items:center;gap:0.5rem;margin-top:0.5rem;cursor:pointer;">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $event->is_featured ?? false) ? 'checked' : '' }} style="accent-color:var(--purple);">
                        <span style="font-size:0.875rem;">Mark as featured</span>
                    </label>
                </div>
            </div>

            <div style="display:flex;gap:0.75rem;margin-top:1rem;">
                <button type="submit" class="btn btn-primary">{{ isset($event) ? 'Update Event' : 'Create Event' }}</button>
                <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
