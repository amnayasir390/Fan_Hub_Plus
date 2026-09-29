@extends('layouts.app')
@section('title', 'Verify Email')

@section('content')
<div style="min-height:calc(100vh - 130px);display:flex;align-items:center;justify-content:center;padding:2rem 1rem;">
    <div style="width:100%;max-width:480px;">
        <div class="card" style="padding:2rem;text-align:center;">
            <div style="font-size:3rem;margin-bottom:1rem;">📧</div>
            <h1 style="font-size:1.5rem;font-weight:900;margin-bottom:0.75rem;">Check your email</h1>
            <p style="color:var(--text-secondary);margin-bottom:1.5rem;line-height:1.7;">
                Thanks for signing up! Before getting started, we need you to verify your email address.
                We sent a verification link to <strong style="color:var(--text-main);">{{ auth()->user()->email }}</strong>.
            </p>

            @if(session('success'))
            <div class="alert alert-success" style="text-align:left;">{{ session('success') }}</div>
            @endif

            <div style="display:flex;flex-direction:column;gap:0.75rem;">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width:100%;">Resend Verification Email</button>
                </form>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-ghost" style="width:100%;">Log Out</button>
                </form>
            </div>

            <div style="margin-top:1.5rem;padding:1rem;background:rgba(74,38,183,0.1);border-radius:8px;font-size:0.8rem;color:var(--text-secondary);">
                💡 Can't find the email? Check your spam or junk folder. The link expires in 60 minutes.
            </div>
        </div>
    </div>
</div>
@endsection
