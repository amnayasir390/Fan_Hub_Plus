@extends('layouts.admin')
@section('title', isset($character) ? 'Edit Character' : 'Add Character')

@section('content')
<div style="max-width:700px;">
    <a href="{{ route('admin.characters.index') }}" class="btn btn-ghost btn-sm" style="margin-bottom:1.5rem;display:inline-flex;">← Back</a>
    <div class="card" style="padding:2rem;">
        <form method="POST" enctype="multipart/form-data" action="{{ isset($character) ? route('admin.characters.update', $character->id) : route('admin.characters.store') }}">
            @csrf @if(isset($character)) @method('PUT') @endif
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group" style="grid-column:1/-1;display:flex;align-items:center;gap:1rem;">
                    <x-image-or-icon :path="$character->image ?? null" icon="fa-user" size="96px" alt="Character image" />
                    <div>
                        <label class="form-label">Character Image</label>
                        <input type="file" name="image" class="form-input" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                        <div class="form-hint">Optional. JPG, PNG, or WEBP up to 2 MB.</div>
                    </div>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Name *</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name', $character->name ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ old('category_id', $character->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Series</label>
                    <input type="text" name="series" class="form-input" value="{{ old('series', $character->series ?? '') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Genre</label>
                    <input type="text" name="genre" class="form-input" value="{{ old('genre', $character->genre ?? '') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Popularity (0-100)</label>
                    <input type="number" name="popularity" class="form-input" value="{{ old('popularity', $character->popularity ?? 50) }}" min="0" max="100">
                </div>
                <div class="form-group">
                    <label class="form-label">Featured?</label>
                    <label style="display:flex;align-items:center;gap:0.5rem;margin-top:0.5rem;cursor:pointer;">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $character->is_featured ?? false) ? 'checked' : '' }} style="accent-color:var(--purple);">
                        <span style="font-size:0.875rem;">Mark as featured</span>
                    </label>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Bio</label>
                    <textarea name="bio" class="form-textarea" rows="4">{{ old('bio', $character->bio ?? '') }}</textarea>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Abilities (comma-separated)</label>
                    <input type="text" name="abilities" class="form-input" value="{{ old('abilities', isset($character->abilities) ? implode(', ', $character->abilities) : '') }}" placeholder="Water Breathing, Enhanced Smell">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Tags (comma-separated)</label>
                    <input type="text" name="tags" class="form-input" value="{{ old('tags', isset($character->tags) ? implode(', ', $character->tags) : '') }}">
                </div>
            </div>
            <div style="display:flex;gap:0.75rem;margin-top:0.5rem;">
                <button type="submit" class="btn btn-primary">{{ isset($character) ? 'Update' : 'Create' }}</button>
                <a href="{{ route('admin.characters.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
