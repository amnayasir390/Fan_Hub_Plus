@extends('layouts.app')
@section('title', 'Forgot Password')

@section('content')
<div style="min-height:calc(100vh - 130px);display:flex;align-items:center;justify-content:center;padding:2rem 1rem;">
    <div style="width:100%;max-width:420px;">
        <div class="card" style="padding:2rem;">
            <div style="text-align:center;margin-bottom:2rem;">
                <div style="font-size:2.5rem;margin-bottom:0.5rem;">🔑</div>
                <h1 style="font-size:1.5rem;font-weight:900;margin-bottom:0.25rem;">Forgot Password?</h1>
                <p style="color:var(--text-secondary);font-size:0.875rem;">No worries — enter your email and we'll send a reset link.</p>
            </div>

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">Email address</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">Send Reset Link</button>
            </form>

            <div style="text-align:center;margin-top:1.5rem;font-size:0.875rem;">
                <a href="{{ route('login') }}" style="color:var(--purple-light);">← Back to login</a>
            </div>
        </div>
    </div>
</div>
@endsection
