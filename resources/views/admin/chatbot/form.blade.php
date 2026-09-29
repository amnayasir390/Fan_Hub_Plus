@extends('layouts.admin')
@section('title', isset($faq) ? 'Edit FAQ' : 'Add FAQ')

@section('content')
<div style="max-width:700px;">
    <a href="{{ route('admin.chatbot.index') }}" class="btn btn-ghost btn-sm" style="margin-bottom:1.5rem;display:inline-flex;">← Back to FAQs</a>
    <div class="card" style="padding:2rem;">
        <form method="POST" action="{{ isset($faq) ? route('admin.chatbot.update', $faq->id) : route('admin.chatbot.store') }}">
            @csrf
            @if(isset($faq)) @method('PUT') @endif

            <div class="form-group">
                <label class="form-label">Question *</label>
                <input type="text" name="question" class="form-input" value="{{ old('question', $faq->question ?? '') }}" required placeholder="e.g. What is Fan Hub Plus?">
            </div>
            <div class="form-group">
                <label class="form-label">Answer *</label>
                <textarea name="answer" class="form-textarea" rows="5" required placeholder="The full answer to show in the chatbot…">{{ old('answer', $faq->answer ?? '') }}</textarea>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-input" value="{{ old('category', $faq->category ?? '') }}" placeholder="e.g. general, account, features">
                </div>
                <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-input" value="{{ old('sort_order', $faq->sort_order ?? 0) }}" min="0">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Keywords <span style="color:var(--text-secondary);font-weight:400;">(comma-separated — used for matching)</span></label>
                <input type="text" name="keywords" class="form-input" value="{{ old('keywords', isset($faq->keywords) ? implode(', ', $faq->keywords) : '') }}" placeholder="what is, about, platform, fan hub">
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $faq->is_active ?? true) ? 'checked' : '' }} style="accent-color:var(--purple);">
                    <span style="font-size:0.875rem;">Active (visible to chatbot)</span>
                </label>
            </div>

            <div style="display:flex;gap:0.75rem;margin-top:0.5rem;">
                <button type="submit" class="btn btn-primary">{{ isset($faq) ? 'Update FAQ' : 'Create FAQ' }}</button>
                <a href="{{ route('admin.chatbot.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
