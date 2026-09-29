@extends('layouts.auth')
@section('title', 'Register')

@section('content')
<div style="width:100%;max-width:600px;">
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:16px;padding:2rem 2.5rem;box-shadow:0 20px 60px rgba(0,0,0,.35);">

        <div style="text-align:center;margin-bottom:1.5rem;">
            <div style="width:48px;height:48px;border-radius:12px;background:#7C4DFF;display:flex;align-items:center;justify-content:center;margin:0 auto .75rem;font-size:1.3rem;color:#fff;">
                <i class="fa-solid fa-bolt"></i>
            </div>
            <h1 style="font-size:1.4rem;font-weight:900;margin-bottom:.25rem;color:var(--text-main);">Join Fan Hub Plus</h1>
            <p style="color:var(--text-secondary);font-size:.85rem;">Create your free fandom account</p>
        </div>

        @if($errors->any())
        <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:10px;padding:.7rem 1rem;margin-bottom:1rem;">
            <ul style="margin:0;padding-left:1.1rem;color:#FCA5A5;font-size:.8rem;line-height:1.5;">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.9rem;margin-bottom:.9rem;">
                <div>
                    <label for="name" style="display:block;font-size:.78rem;font-weight:600;color:var(--text-secondary);margin-bottom:.35rem;">Display Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Your name"
                        style="width:100%;background:var(--bg-main);border:1px solid var(--border);border-radius:10px;padding:.6rem .85rem;color:var(--text-main);font-size:.875rem;">
                </div>

                <div>
                    <label for="email" style="display:block;font-size:.78rem;font-weight:600;color:var(--text-secondary);margin-bottom:.35rem;">Email address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com"
                        style="width:100%;background:var(--bg-main);border:1px solid var(--border);border-radius:10px;padding:.6rem .85rem;color:var(--text-main);font-size:.875rem;">
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.9rem;margin-bottom:1rem;">
                <div>
                    <label for="password" style="display:block;font-size:.78rem;font-weight:600;color:var(--text-secondary);margin-bottom:.35rem;">Password</label>
                    <input type="password" id="password" name="password" required placeholder="At least 8 characters"
                        style="width:100%;background:var(--bg-main);border:1px solid var(--border);border-radius:10px;padding:.6rem .85rem;color:var(--text-main);font-size:.875rem;">
                </div>

                <div>
                    <label for="password_confirmation" style="display:block;font-size:.78rem;font-weight:600;color:var(--text-secondary);margin-bottom:.35rem;">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Repeat your password"
                        style="width:100%;background:var(--bg-main);border:1px solid var(--border);border-radius:10px;padding:.6rem .85rem;color:var(--text-main);font-size:.875rem;">
                </div>
            </div>

            <div style="background:rgba(124,77,255,.1);border:1px solid rgba(124,77,255,.3);border-radius:10px;padding:.7rem 1rem;margin-bottom:1.1rem;font-size:.78rem;color:var(--text-secondary);line-height:1.5;">
                <i class="fa-solid fa-lock" style="color:#A78BFA;"></i>
                By registering, you agree to explore fandoms responsibly. We'll send a verification email to activate your account.
            </div>

            <button type="submit"
                onmouseover="this.style.background= '#301a6e'" 
                onmouseout="this.style.background='#5b2fd6'"
                style="width:100%;background:#7C4DFF;color:#fff;border:0;border-radius:10px;padding:.8rem;font-size:.9rem;font-weight:700;cursor:pointer;transition:background .2s;">
                Create Account
            </button>
        </form>

        <div style="text-align:center;margin-top:1.1rem;font-size:.85rem;color:var(--text-secondary);">
            Already have an account?
            <a href="{{ route('login') }}" style="color:#A78BFA;font-weight:600;" onmouseover="this.style.color='#5b2fd6'">Sign in</a>
        </div>
    </div>
</div>
@endsection