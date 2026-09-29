@extends('layouts.admin')
@section('title', isset($mediaItem) ? 'Edit Media' : 'Add Media')

@section('content')
<div style="max-width:700px;">
    <a href="{{ route('admin.media.index') }}" class="btn btn-ghost btn-sm" style="margin-bottom:1.5rem;display:inline-flex;">← Back</a>
    <div class="card" style="padding:2rem;">
        <form method="POST" action="{{ isset($mediaItem) ? route('admin.media.update', $mediaItem->id) : route('admin.media.store') }}">
            @csrf @if(isset($mediaItem)) @method('PUT') @endif
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" class="form-input" value="{{ old('title', $mediaItem->title ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ old('category_id', $mediaItem->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Media Type *</label>
                    <select name="media_type" class="form-select" required>
                        @foreach(['video','audio','image','trailer'] as $t)<option value="{{ $t }}" {{ old('media_type', $mediaItem->media_type ?? 'video') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">URL * <span style="color:var(--text-secondary);font-weight:400;">(YouTube, SoundCloud, or direct link)</span></label>
                    <input type="text" name="url" class="form-input" value="{{ old('url', $mediaItem->url ?? '') }}" required placeholder="https://www.youtube.com/watch?v=...">
                </div>
                <div class="form-group">
                    <label class="form-label">Duration</label>
                    <input type="text" name="duration" class="form-input" value="{{ old('duration', $mediaItem->duration ?? '') }}" placeholder="e.g. 3:45">
                </div>
                <div class="form-group">
                    <label class="form-label">Featured?</label>
                    <label style="display:flex;align-items:center;gap:0.5rem;margin-top:0.5rem;cursor:pointer;">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $mediaItem->is_featured ?? false) ? 'checked' : '' }} style="accent-color:var(--purple);">
                        <span style="font-size:0.875rem;">Mark as featured</span>
                    </label>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-textarea" rows="3">{{ old('description', $mediaItem->description ?? '') }}</textarea>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Tags (comma-separated)</label>
                    <input type="text" name="tags" class="form-input" value="{{ old('tags', isset($mediaItem->tags) ? implode(', ', $mediaItem->tags) : '') }}">
                </div>
            </div>
            <div style="display:flex;gap:0.75rem;margin-top:0.5rem;">
                <button type="submit" class="btn btn-primary">{{ isset($mediaItem) ? 'Update' : 'Create' }}</button>
                <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
