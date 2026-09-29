<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fan Hub Plus') — Fan Hub Plus</title>
    <meta name="description" content="@yield('meta_description', 'Your ultimate fandom universe — Anime, Gaming, Movies, TV Shows, K-Pop, Comics, Manga & Cosplay in one place.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body style="background:var(--bg-main);color:var(--text-main);">

<div id="page-loader" class="page-loader">
    <div style="display:flex;flex-direction:column;align-items:center;gap:1rem;">
        <div style="font-size:2rem;font-weight:900;color:#8B5CF6;">Fan Hub Plus</div>
        <div class="spinner"></div>
    </div>
</div>

@php
    $isAdmin = auth()->check() && auth()->user()->isAdmin();

    $links = [
        ['home',              'home',           'fa-house',         'Home'],
        ['content.index',     'content.*',      'fa-compass',       'Explore'],
        ['multimedia.index',  'multimedia.*',   'fa-film',          'Media'],
        ['characters.index',  'characters.*',   'fa-users',         'Characters'],
        ['articles.index',    'articles.*',     'fa-pen-to-square', 'Articles'],
        ['merchandise.index', 'merchandise.*',  'fa-bag-shopping',  'Merchandise'],
        ['events.index',      'events.*',       'fa-calendar-days', 'Events'],
    ];

    if (! $isAdmin) {
        $links[] = ['feedback.create', 'feedback.*', 'fa-comments', 'Feedback'];
    }
@endphp

<div id="overlay" onclick="toggleSidebar()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:150;"></div>

<aside id="sidebar" style="position:fixed;top:0;left:0;bottom:0;width:240px;z-index:200;background:var(--bg-sidebar);border-right:1px solid var(--border);display:flex;flex-direction:column;padding:1.25rem 1rem;overflow-y:auto;transition:transform .3s;">

    <a href="{{ route('home') }}" style="display:flex;align-items:center;gap:.6rem;font-size:1.25rem;font-weight:800;color:var(--text-main);margin-bottom:1.5rem;padding:0 .5rem;">
        <i class="fa-solid fa-bolt" style="color:#7C4DFF;"></i> Fan Hub Plus
    </a>

    @foreach($links as [$route, $pattern, $icon, $label])
        <a href="{{ route($route) }}" class="sidebar-link"
           style="{{ request()->routeIs($pattern) ? 'background:#5b2fd6;color:#fff;border-radius:10px;' : '' }}">
            <i class="fa-solid {{ $icon }} fa-fw"></i> {{ $label }}
        </a>
    @endforeach

    @auth
        <hr class="divider">
        <a href="{{ route('dashboard') }}" class="sidebar-link"
           style="{{ request()->routeIs('dashboard') ? 'background:#5b2fd6;color:#fff;border-radius:10px;' : '' }}">
            <i class="fa-solid fa-chart-line fa-fw"></i> Dashboard
        </a>
        <a href="{{ route('profile.edit') }}" class="sidebar-link"
           style="{{ request()->routeIs('profile.*') ? 'background:#5b2fd6;color:#fff;border-radius:10px;' : '' }}">
            <i class="fa-solid fa-user fa-fw"></i> Profile
        </a>
        @unless($isAdmin)
        <a href="{{ route('bookmarks.index') }}" class="sidebar-link"
           style="{{ request()->routeIs('bookmarks.*') ? 'background:#5b2fd6;color:#fff;border-radius:10px;' : '' }}">
            <i class="fa-solid fa-bookmark fa-fw"></i> Bookmarks
        </a>
        @endunless
        @if($isAdmin)
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link" style="color:#A78BFA;">
                <i class="fa-solid fa-gear fa-fw"></i> Admin Panel
            </a>
        @endif
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link" style="width:100%;background:none;border:none;cursor:pointer;color:#FCA5A5;text-align:left;">
                <i class="fa-solid fa-right-from-bracket fa-fw"></i> Log Out
            </button>
        </form>

        <div style="margin-top:auto;display:flex;align-items:center;gap:.7rem;padding:.7rem;background:var(--bg-card);border:1px solid var(--border);border-radius:12px;">
            <x-image-or-icon :path="auth()->user()->avatar" icon="fa-user" size="36px" rounded alt="Avatar" />
            <div style="min-width:0;">
                <div style="font-size:.85rem;font-weight:700;">{{ auth()->user()->name }}</div>
                <div style="font-size:.7rem;color:var(--text-secondary);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ auth()->user()->email }}</div>
            </div>
        </div>
    @else
        <hr class="divider">
        <a href="{{ route('login') }}" class="btn btn-secondary" style="margin-bottom:.5rem;text-align:center;">Login</a>
        <a href="{{ route('register') }}" class="btn btn-primary" style="text-align:center;">Register</a>
    @endauth
</aside>

<div id="main" style="margin-left:240px;min-height:100vh;display:flex;flex-direction:column;">

    <header style="position:sticky;top:0;z-index:100;height:64px;padding:0 1.5rem;display:flex;align-items:center;justify-content:flex-end;gap:.75rem;background:var(--bg-sidebar);border-bottom:1px solid var(--border);">
        <button id="burger" class="btn-icon" onclick="toggleSidebar()" style="display:none;margin-right:auto;" aria-label="Menu">
            <i class="fa-solid fa-bars"></i>
        </button>
        <button class="btn-icon" onclick="toggleTheme()" title="Toggle theme" aria-label="Toggle theme">
            <span id="theme-icon"><i class="fa-solid fa-moon"></i></span>
        </button>
        @auth
            @unless($isAdmin)
                <a href="{{ route('bookmarks.index') }}" class="btn-icon" title="Bookmarks"><i class="fa-solid fa-bookmark"></i></a>
            @endunless
        @else
            <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Login</a>
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
        @endauth
    </header>

    <main class="fhp-main" style="flex:1;">
        @if(session('success'))
            <div class="container" style="padding-top:1rem;">
                <div class="alert alert-success" data-auto-dismiss="4000"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="container" style="padding-top:1rem;">
                <div class="alert alert-error" data-auto-dismiss="5000"><i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}</div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="fhp-footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="footer-brand-name"><i class="fa-solid fa-bolt"></i> Fan Hub Plus</div>
                    <p class="footer-desc">Your ultimate fandom universe — bringing Anime, Gaming, Movies, TV Shows, K-Pop, Comics, Manga & Cosplay communities together under one roof.</p>
                </div>
                <div>
                    <div class="footer-heading">Explore</div>
                    <a href="{{ route('content.index') }}" class="footer-link">Content Explorer</a>
                    <a href="{{ route('multimedia.index') }}" class="footer-link">Multimedia Center</a>
                    <a href="{{ route('characters.index') }}" class="footer-link">Characters</a>
                    <a href="{{ route('articles.index') }}" class="footer-link">Articles</a>
                </div>
                <div>
                    <div class="footer-heading">Discover</div>
                    <a href="{{ route('merchandise.index') }}" class="footer-link">Merchandise</a>
                    <a href="{{ route('events.index') }}" class="footer-link">Events</a>
                    @unless($isAdmin)
                        <a href="{{ route('feedback.create') }}" class="footer-link">Feedback</a>
                    @endunless
                    @auth
                        <a href="{{ route('articles.submit') }}" class="footer-link">Submit Fan Content</a>
                    @endauth
                </div>
                <div>
                    <div class="footer-heading">Account</div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="footer-link">Dashboard</a>
                        <a href="{{ route('profile.edit') }}" class="footer-link">Profile</a>
                        @unless($isAdmin)
                            <a href="{{ route('bookmarks.index') }}" class="footer-link">Bookmarks</a>
                        @endunless
                    @else
                      <div style="margin-top:auto;">
                        <a href="{{ route('login') }}" class="footer-link">Login</a>
                        <a href="{{ route('register') }}" class="footer-link">Register</a>
                      </div>
                    @endauth
                </div>
            </div>
            <div class="footer-bottom">
                <span class="footer-bottom-text">© {{ date('Y') }} Fan Hub Plus. Built for fandom enthusiasts everywhere.</span>
            </div>
        </div>
    </footer>
</div>

@auth
<button id="chatbot-toggle" class="chatbot-toggle" title="Chat with Fandom Guide" aria-label="Open chatbot"><i class="fa-solid fa-comment-dots"></i></button>
<div id="chatbot-window" class="chatbot-window" role="dialog" aria-label="Fandom Guide Chatbot">
    <div class="chatbot-header">
        <div class="chatbot-title"><i class="fa-solid fa-robot"></i> Fandom Guide</div>
        <button onclick="document.getElementById('chatbot-window').classList.remove('open')" style="background:none;border:none;color:#fff;cursor:pointer;font-size:1.1rem;" aria-label="Close chatbot"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div id="chatbot-messages" class="chatbot-messages"></div>
    <div class="chatbot-input-area">
        <form id="chatbot-form" style="display:contents;">
            @csrf
            <input type="text" id="chatbot-input" class="chatbot-input" placeholder="Ask me anything…" autocomplete="off">
            <button type="submit" class="btn btn-primary btn-sm">Send</button>
        </form>
    </div>
</div>
@endauth

<script>
const sidebar = document.getElementById('sidebar');
const main = document.getElementById('main');
const overlay = document.getElementById('overlay');
const burger = document.getElementById('burger');

function setLayout() {
    if (window.innerWidth <= 900) {
        sidebar.style.transform = 'translateX(-100%)';
        main.style.marginLeft = '0';
        burger.style.display = 'inline-flex';
        overlay.style.display = 'none';
    } else {
        sidebar.style.transform = 'none';
        main.style.marginLeft = '240px';
        burger.style.display = 'none';
        overlay.style.display = 'none';
    }
}

function toggleSidebar() {
    const isOpen = sidebar.style.transform === 'none';
    sidebar.style.transform = isOpen ? 'translateX(-100%)' : 'none';
    overlay.style.display = isOpen ? 'none' : 'block';
}

setLayout();
window.addEventListener('resize', setLayout);
</script>

@stack('scripts')
</body>
</html>