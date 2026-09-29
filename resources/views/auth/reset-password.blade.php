@extends('layouts.app')
@section('title', 'Reset Password')

@section('content')
<div style="min-height:calc(100vh - 130px);display:flex;align-items:center;justify-content:center;padding:2rem 1rem;">
    <div style="width:100%;max-width:420px;">
        <div class="card" style="padding:2rem;">
            <div style="text-align:center;margin-bottom:2rem;">
                <div style="font-size:2.5rem;margin-bottom:0.5rem;">🔒</div>
                <h1 style="font-size:1.5rem;font-weight:900;margin-bottom:0.25rem;">Set New Password</h1>
                <p style="color:var(--text-secondary);font-size:0.875rem;">Choose a strong new password for your account.</p>
            </div>

            @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <label class="form-label" for="email">Email address</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ $email ?? old('email') }}" required placeholder="you@example.com">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">New Password</label>
                    <input type="password" id="password" name="password" class="form-input" required placeholder="At least 8 characters" autofocus>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required placeholder="Repeat new password">
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">Reset Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
