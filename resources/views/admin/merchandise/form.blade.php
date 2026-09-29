@extends('layouts.admin')
@section('title', isset($merchandise) ? 'Edit Merchandise' : 'Add Merchandise')

@section('content')
<div style="max-width:700px;">
    <a href="{{ route('admin.merchandise.index') }}" class="btn btn-ghost btn-sm" style="margin-bottom:1.5rem;display:inline-flex;">← Back</a>
    <div class="card" style="padding:2rem;">
        <form method="POST" enctype="multipart/form-data" action="{{ isset($merchandise) ? route('admin.merchandise.update', $merchandise->id) : route('admin.merchandise.store') }}">
            @csrf @if(isset($merchandise)) @method('PUT') @endif
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group" style="grid-column:1/-1;display:flex;align-items:center;gap:1rem;">
                    <x-image-or-icon :path="$merchandise->image ?? null" icon="fa-bag-shopping" size="110px" alt="Merchandise image" />
                    <div>
                        <label class="form-label">Product Image</label>
                        <input type="file" name="image" class="form-input" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                        <div class="form-hint">Optional. JPG, PNG, or WEBP up to 2 MB.</div>
                    </div>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Name *</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name', $merchandise->name ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ old('category_id', $merchandise->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        @foreach(['available','pre-order','sold-out'] as $s)<option value="{{ $s }}" {{ old('status', $merchandise->status ?? 'available') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Price</label>
                    <input type="number" name="price" class="form-input" step="0.01" min="0" value="{{ old('price', $merchandise->price ?? '') }}" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label class="form-label">Badge</label>
                    <select name="badge" class="form-select">
                        <option value="">None</option>
                        @foreach(['Limited Edition','Pre-Order','Collectible'] as $b)<option value="{{ $b }}" {{ old('badge', $merchandise->badge ?? '') === $b ? 'selected' : '' }}>{{ $b }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Release Date</label>
                    <input type="date" name="release_date" class="form-input" value="{{ old('release_date', isset($merchandise->release_date) ? $merchandise->release_date->format('Y-m-d') : '') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Featured?</label>
                    <label style="display:flex;align-items:center;gap:0.5rem;margin-top:0.5rem;cursor:pointer;">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $merchandise->is_featured ?? false) ? 'checked' : '' }} style="accent-color:var(--purple);">
                        <span style="font-size:0.875rem;">Mark as featured</span>
                    </label>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Buy Link</label>
                    <input type="url" name="buy_link" class="form-input" value="{{ old('buy_link', $merchandise->buy_link ?? '') }}" placeholder="https://...">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-textarea" rows="4">{{ old('description', $merchandise->description ?? '') }}</textarea>
                </div>
            </div>
            <div style="display:flex;gap:0.75rem;margin-top:0.5rem;">
                <button type="submit" class="btn btn-primary">{{ isset($merchandise) ? 'Update' : 'Create' }}</button>
                <a href="{{ route('admin.merchandise.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
