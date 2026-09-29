@extends('layouts.admin')
@section('title', isset($article) ? 'Edit Article' : 'Add Article')

@section('content')
<div style="max-width:800px;">
    <a href="{{ route('admin.articles.index') }}" class="btn btn-ghost btn-sm" style="margin-bottom:1.5rem;display:inline-flex;">← Back</a>
    <div class="card" style="padding:2rem;">
        <form method="POST" enctype="multipart/form-data" action="{{ isset($article) ? route('admin.articles.update', $article->id) : route('admin.articles.store') }}">
            @csrf @if(isset($article)) @method('PUT') @endif
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group" style="grid-column:1/-1;display:flex;align-items:center;gap:1rem;">
                    <x-image-or-icon :path="$article->cover_image ?? null" icon="fa-newspaper" size="140px" alt="Article cover image" />
                    <div>
                        <label class="form-label">Cover Image</label>
                        <input type="file" name="cover_image" class="form-input" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                        <div class="form-hint">Optional. JPG, PNG, or WEBP up to 2 MB.</div>
                    </div>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" class="form-input" value="{{ old('title', $article->title ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ old('category_id', $article->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Article Type *</label>
                    <select name="article_type" class="form-select" required>
                        @foreach(['article'=>'Article','event_highlight'=>'Event Highlight','fan_submission'=>'Fan Submission'] as $v=>$l)
                        <option value="{{ $v }}" {{ old('article_type', $article->article_type ?? 'article') === $v ? 'selected' : '' }}>{{ $l }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        @foreach(['published','draft','pending'] as $s)<option value="{{ $s }}" {{ old('status', $article->status ?? 'published') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Featured?</label>
                    <label style="display:flex;align-items:center;gap:0.5rem;margin-top:0.5rem;cursor:pointer;">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $article->is_featured ?? false) ? 'checked' : '' }} style="accent-color:var(--purple);">
                        <span style="font-size:0.875rem;">Mark as featured</span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-label">Event Date</label>
                    <input type="date" name="event_date" class="form-input" value="{{ old('event_date', isset($article->event_date) ? $article->event_date->format('Y-m-d') : '') }}">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Event Location</label>
                    <input type="text" name="event_location" class="form-input" value="{{ old('event_location', $article->event_location ?? '') }}" placeholder="e.g. Los Angeles, CA">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Excerpt</label>
                    <textarea name="excerpt" class="form-textarea" rows="2">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Body *</label>
                    <textarea name="body" class="form-textarea" rows="10" required>{{ old('body', $article->body ?? '') }}</textarea>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Tags (comma-separated)</label>
                    <input type="text" name="tags" class="form-input" value="{{ old('tags', isset($article->tags) ? implode(', ', $article->tags) : '') }}">
                </div>
            </div>
            <div style="display:flex;gap:0.75rem;margin-top:0.5rem;">
                <button type="submit" class="btn btn-primary">{{ isset($article) ? 'Update' : 'Create' }}</button>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
