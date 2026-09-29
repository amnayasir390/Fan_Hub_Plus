@extends('layouts.admin')
@section('title', isset($content) ? 'Edit Content' : 'Add Content')

@section('content')
<div style="max-width:800px;">
    <div style="margin-bottom:1.5rem;">
        <a href="{{ route('admin.content.index') }}" class="btn btn-ghost btn-sm">← Back to Content</a>
    </div>

    <div class="card" style="padding:2rem;">
        <form method="POST" enctype="multipart/form-data" action="{{ isset($content) ? route('admin.content.update', $content->id) : route('admin.content.store') }}">
            @csrf
            @if(isset($content)) @method('PUT') @endif

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group" style="grid-column:1/-1;display:flex;align-items:center;gap:1rem;">
                    <x-image-or-icon :path="$content->cover_image ?? null" icon="fa-file-lines" size="140px" alt="Content cover image" />
                    <div>
                        <label class="form-label">Cover Image</label>
                        <input type="file" name="cover_image" class="form-input" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                        <div class="form-hint">Optional. JPG, PNG, or WEBP up to 2 MB.</div>
                    </div>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" class="form-input" value="{{ old('title', $content->title ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $content->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Content Type *</label>
                    <select name="content_type" class="form-select" required>
                        @foreach(['article','profile','media'] as $t)
                        <option value="{{ $t }}" {{ old('content_type', $content->content_type ?? 'article') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        @foreach(['published','draft','pending'] as $s)
                        <option value="{{ $s }}" {{ old('status', $content->status ?? 'published') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Genre</label>
                    <input type="text" name="genre" class="form-input" value="{{ old('genre', $content->genre ?? '') }}" placeholder="e.g. Action, Romance">
                </div>
                <div class="form-group">
                    <label class="form-label">Release Year</label>
                    <input type="number" name="release_year" class="form-input" value="{{ old('release_year', $content->release_year ?? '') }}" min="1900" max="2030">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Excerpt</label>
                    <textarea name="excerpt" class="form-textarea" rows="2" maxlength="500">{{ old('excerpt', $content->excerpt ?? '') }}</textarea>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Body</label>
                    <textarea name="body" class="form-textarea" rows="8">{{ old('body', $content->body ?? '') }}</textarea>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Tags <span style="color:var(--text-secondary);font-weight:400;">(comma-separated)</span></label>
                    <input type="text" name="tags" class="form-input" value="{{ old('tags', isset($content->tags) ? implode(', ', $content->tags) : '') }}" placeholder="anime, action, 2024">
                </div>
            </div>

            <div style="display:flex;gap:0.75rem;margin-top:0.5rem;">
                <button type="submit" class="btn btn-primary">{{ isset($content) ? 'Update Content' : 'Create Content' }}</button>
                <a href="{{ route('admin.content.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
