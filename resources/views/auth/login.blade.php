@extends('layouts.auth')
@section('title', 'Login')

@section('content')
<div style="width:100%;max-width:440px;">
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 2.5rem;box-shadow:0 20px 60px rgba(0,0,0,.35);">

        <div style="text-align:center;margin-bottom:1.5rem;">
            <div style="width:48px;height:48px;border-radius:12px;background:#7C4DFF;display:flex;align-items:center;justify-content:center;margin:0 auto .75rem;font-size:1.3rem;color:#fff;">
                <i class="fa-solid fa-bolt"></i>
            </div>
            <h1 style="font-size:1.4rem;font-weight:900;margin-bottom:.25rem;color:var(--text-main);">Welcome back</h1>
            <p style="color:var(--text-secondary);font-size:.85rem;">Sign in to your Fan Hub Plus account</p>
        </div>

        @if($errors->any())
        <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:10px;padding:.7rem 1rem;margin-bottom:1rem;color:#FCA5A5;font-size:.8rem;">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div style="margin-bottom:1rem;">
                <label for="email" style="display:block;font-size:.78rem;font-weight:600;color:var(--text-secondary);margin-bottom:.35rem;">Email address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com"
                    style="width:100%;background:var(--bg-main);border:1px solid var(--border);border-radius:10px;padding:.65rem .85rem;color:var(--text-main);font-size:.875rem;">
                @error('email')<div style="color:#FCA5A5;font-size:.75rem;margin-top:.35rem;">{{ $message }}</div>@enderror
            </div>

            <div style="margin-bottom:1.1rem;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.35rem;">
                    <label for="password" style="font-size:.78rem;font-weight:600;color:var(--text-secondary);">Password</label>
                    <a href="{{ route('password.request') }}" style="font-size:.75rem;color:#A78BFA;">Forgot password?</a>
                </div>
                <input type="password" id="password" name="password" required placeholder="••••••••"
                    style="width:100%;background:var(--bg-main);border:1px solid var(--border);border-radius:10px;padding:.65rem .85rem;color:var(--text-main);font-size:.875rem;">
                @error('password')<div style="color:#FCA5A5;font-size:.75rem;margin-top:.35rem;">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:1.25rem;">
                <input type="checkbox" id="remember" name="remember" style="accent-color:#7C4DFF;">
                <label for="remember" style="font-size:.85rem;color:var(--text-secondary);cursor:pointer;">Remember me</label>
            </div>

            <button type="submit"
                onmouseover="this.style.background= '#301a6e'"
                onmouseout="this.style.background='#5b2fd6'"
                style="width:100%;background:#7C4DFF;color:#fff;border:0;border-radius:10px;padding:.8rem;font-size:.9rem;font-weight:700;cursor:pointer;transition:background .2s;">
                Sign In
            </button>
        </form>

        <div style="text-align:center;margin-top:1.1rem;font-size:.85rem;color:var(--text-secondary);">
            Don't have an account?
            <a href="{{ route('register') }}" style="color:#A78BFA;font-weight:600;" onmouseover="this.style.color='#5b2fd6'">Create one free</a>
        </div>
    </div>
</div>
@endsection