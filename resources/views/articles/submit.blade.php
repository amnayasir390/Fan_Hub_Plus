@extends('layouts.app')
@section('title', 'Submit Fan Content')

@section('content')
<div class="container py-section" style="max-width:760px;">
    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">/</span>
        <a href="{{ route('articles.index') }}">Articles</a><span class="breadcrumb-sep">/</span>
        <span>Submit Fan Content</span>
    </div>
    <div class="section-header"><h1 class="section-title">✍️ Submit Fan Content</h1></div>
    <div class="alert alert-info">📋 Your submission will be reviewed by the admin team before publishing. High-quality, original content has the best chance of approval!</div>

    <div class="card" style="padding:2rem;margin-top:1rem;">
        @if($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        <form method="POST" action="{{ route('articles.submit.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Category *</label>
                <select name="category_id" class="form-select" required>
                    <option value="">Select a fandom category…</option>
                    @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->icon }} {{ $cat->name }}</option>@endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-input" value="{{ old('title') }}" required placeholder="Your article title" maxlength="255">
            </div>
            <div class="form-group">
                <label class="form-label">Brief Summary * <span style="color:var(--text-secondary);font-weight:400;">(max 500 chars)</span></label>
                <textarea name="excerpt" class="form-textarea" required maxlength="500" rows="2" placeholder="A brief summary of your article…">{{ old('excerpt') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Full Article * <span style="color:var(--text-secondary);font-weight:400;">(min 100 chars)</span></label>
                <textarea name="body" class="form-textarea" required rows="12" style="min-height:300px;" placeholder="Write your full article here…">{{ old('body') }}</textarea>
            </div>
            <div style="display:flex;gap:1rem;flex-wrap:wrap;">
                <button type="submit" class="btn btn-primary">Submit for Review</button>
                <a href="{{ route('articles.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
