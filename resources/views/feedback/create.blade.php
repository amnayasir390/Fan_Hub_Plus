@extends('layouts.app')
@section('title', 'Feedback')

@section('content')
<div class="container py-section" style="max-width:700px;">
    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">/</span><span>Feedback</span>
    </div>

    <div class="section-header"><h1 class="section-title">💬 Feedback</h1></div>

    <p style="color:var(--text-secondary);margin-bottom:2rem;line-height:1.7;">
        Found a bug? Have a suggestion? Just want to say hi? We read every message and use your feedback to make Fan Hub Plus better.
    </p>

    {{-- Type cards --}}
    <div class="grid-cards grid-3" style="margin-bottom:2rem;">
        @foreach([['bug','🐛','Bug Report','Something broken?','badge-red'],['suggestion','💡','Suggestion','Got a great idea?','badge-yellow'],['query','❓','General Query','Just want to chat?','badge-purple']] as [$val,$icon,$label,$desc,$badge])
        <div class="card" style="padding:1.25rem;text-align:center;cursor:pointer;transition:border-color 0.2s;" onclick="document.getElementById('type-{{ $val }}').click();" id="type-card-{{ $val }}">
            <div style="font-size:2rem;margin-bottom:0.5rem;">{{ $icon }}</div>
            <div style="font-weight:700;font-size:0.9rem;margin-bottom:0.25rem;">{{ $label }}</div>
            <div style="font-size:0.78rem;color:var(--text-secondary);">{{ $desc }}</div>
        </div>
        @endforeach
    </div>

    <div class="card" style="padding:2rem;">
        @if(session('success'))
        <div class="alert alert-success" data-auto-dismiss="5000">{{ session('success') }}</div>
        @endif
        @if($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:1rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <form method="POST" action="{{ route('feedback.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Feedback Type *</label>
                <div style="display:flex;gap:1rem;flex-wrap:wrap;">
                    @foreach([['bug','🐛 Bug Report'],['suggestion','💡 Suggestion'],['query','❓ General Query']] as [$val,$label])
                    <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;font-size:0.875rem;">
                        <input type="radio" id="type-{{ $val }}" name="type" value="{{ $val }}" {{ old('type','query') === $val ? 'checked' : '' }} style="accent-color:var(--purple);" onchange="highlightTypeCard('{{ $val }}')">
                        {{ $label }}
                    </label>
                    @endforeach
                </div>
                @error('type')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="form-group">
                    <label class="form-label">Your Name *</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name', auth()->user()?->name) }}" required placeholder="Your name">
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address *</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email', auth()->user()?->email) }}" required placeholder="you@example.com">
                    @error('email')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Subject *</label>
                <input type="text" name="subject" class="form-input" value="{{ old('subject') }}" required placeholder="Brief subject line">
                @error('subject')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Message * <span style="color:var(--text-secondary);font-weight:400;">(10–2000 chars)</span></label>
                <textarea name="message" class="form-textarea" rows="6" required minlength="10" maxlength="2000" placeholder="Describe your feedback in detail…">{{ old('message') }}</textarea>
                @error('message')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-primary btn-lg">Send Feedback</button>
        </form>
    </div>
</div>

<script>
function highlightTypeCard(type) {
    ['bug','suggestion','query'].forEach(t => {
        const card = document.getElementById('type-card-' + t);
        if (card) card.style.borderColor = t === type ? 'var(--purple)' : 'var(--border)';
    });
}
// Init on load
document.addEventListener('DOMContentLoaded', () => {
    const checked = document.querySelector('input[name="type"]:checked');
    if (checked) highlightTypeCard(checked.value);
    document.querySelectorAll('input[name="type"]').forEach(r => r.addEventListener('change', () => highlightTypeCard(r.value)));
});
</script>
@endsection
