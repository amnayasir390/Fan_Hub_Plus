<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title', 'Dashboard') | Fan Hub Plus</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="fhp-wrapper" style="flex-direction:row;min-height:100vh;">

    {{-- ── Admin Sidebar ── --}}
    <aside class="fhp-sidebar" style="position:sticky;top:0;height:100vh;overflow-y:auto;">
        <div style="margin-bottom:1.5rem;">
            <a href="{{ route('home') }}" class="fhp-logo" style="display:block;margin-bottom:0.25rem;">⚡ Fan Hub Plus</a>
            <div style="font-size:0.7rem;color:var(--text-secondary);font-weight:600;letter-spacing:0.08em;text-transform:uppercase;">Admin Panel</div>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Overview</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Content</div>
            <a href="{{ route('admin.content.index') }}"      class="sidebar-link {{ request()->routeIs('admin.content.*') ? 'active' : '' }}">📄 Content Items</a>
            <a href="{{ route('admin.articles.index') }}"     class="sidebar-link {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">📝 Articles</a>
            <a href="{{ route('admin.characters.index') }}"   class="sidebar-link {{ request()->routeIs('admin.characters.*') ? 'active' : '' }}">👥 Characters</a>
            <a href="{{ route('admin.media.index') }}"        class="sidebar-link {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">🎬 Multimedia</a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Shop & Events</div>
            <a href="{{ route('admin.merchandise.index') }}"  class="sidebar-link {{ request()->routeIs('admin.merchandise.*') ? 'active' : '' }}">🛍️ Merchandise</a>
            <a href="{{ route('admin.events.index') }}"       class="sidebar-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">📅 Events</a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Community</div>
            <a href="{{ route('admin.users.index') }}"        class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">👥 Users</a>
            <a href="{{ route('admin.submissions.index') }}"  class="sidebar-link {{ request()->routeIs('admin.submissions.*') ? 'active' : '' }}">📨 Fan Submissions</a>
            <a href="{{ route('admin.feedback.index') }}"     class="sidebar-link {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">💬 Feedback</a>
            <a href="{{ route('admin.chatbot.index') }}"      class="sidebar-link {{ request()->routeIs('admin.chatbot.*') ? 'active' : '' }}">🤖 Chatbot FAQs</a>
        </div>

        <div class="sidebar-section" style="margin-top:auto;padding-top:1rem;border-top:1px solid var(--border);">
            <a href="{{ route('home') }}"        class="sidebar-link">🌐 View Site</a>
            <a href="{{ route('dashboard') }}"   class="sidebar-link">📊 My Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link" style="width:100%;background:none;border:none;cursor:pointer;color:#FCA5A5;text-align:left;">🚪 Log Out</button>
            </form>
        </div>
    </aside>

    {{-- ── Admin Main ── --}}
    <div style="flex:1;min-width:0;display:flex;flex-direction:column;">
        {{-- Top bar --}}
        <div style="background:var(--bg-sidebar);border-bottom:1px solid var(--border);padding:0 1.5rem;height:56px;display:flex;align-items:center;justify-content:space-between;gap:1rem;position:sticky;top:0;z-index:40;">
            <h1 style="font-size:1rem;font-weight:700;margin:0;">@yield('title', 'Dashboard')</h1>
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <button class="btn-icon" onclick="toggleTheme()" title="Toggle theme"><span id="theme-icon">🌙</span></button>
                <div style="font-size:0.85rem;color:var(--text-secondary);">{{ auth()->user()->name }}</div>
                <x-image-or-icon :path="auth()->user()->avatar" icon="fa-user" size="32px" rounded alt="Avatar" style="border:2px solid var(--border);" />
            </div>
        </div>

        {{-- Flash messages --}}
        <div style="padding:0 1.5rem;">
            @if(session('success'))
                <div class="alert alert-success" style="margin-top:1rem;" data-auto-dismiss="4000">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error" style="margin-top:1rem;" data-auto-dismiss="5000">❌ {{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-error" style="margin-top:1rem;">
                    <ul style="margin:0;padding:0;list-style:none;">
                        @foreach($errors->all() as $error)
                            <li>❌ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        {{-- Page content --}}
        <div style="padding:1.5rem;flex:1;">
            @yield('content')
        </div>
    </div>
</div>
@stack('scripts')
</body>
</html>
