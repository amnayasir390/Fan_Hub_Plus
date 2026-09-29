# ⚡ Fan Hub Plus

A fully functional, responsive fandom universe platform built with **Laravel 12** + **Tailwind CSS v4**.

## Features

| Feature | Details |
|---|---|
| 🔐 Authentication | Register, Login, Email Verification, Forgot/Reset Password |
| 👤 User Profiles | Avatar upload, bio, favourite fandoms, categories, font size, dark mode |
| 📊 Dashboard | Personalised greeting, recent content by interest, bookmarks, fandom shortcuts |
| 🔭 Content Explorer | 26+ seeded items across 8 categories with multi-level filters & sorting |
| 🎬 Multimedia Center | YouTube trailers/videos, audio players, gallery — with ratings |
| 👥 Character Profiles | 19 characters with bio, abilities, series, filtered card grid |
| 📝 Articles | Rich articles, event highlights (timeline), fan submissions (admin approval) |
| 🛍️ Merchandise | Gallery grouped by fandom, badges (Limited/Pre-Order/Collectible), upcoming releases |
| 📅 Events & Calendar | Leaflet.js interactive map, GPS coordinates, city filter, ticket links |
| 🔖 Bookmarks | Polymorphic — save articles, characters, media, merch. Add notes. |
| 💬 Feedback | Categorised form (Bug / Suggestion / Query) |
| 🤖 Chatbot | Keyword-matching FAQ chatbot with chat history |
| ⚙️ Admin Panel | Full CRUD for all content types + fan submissions + feedback + chatbot FAQs |
| 🌙 Dark / Light Mode | Toggle in navbar, persisted in localStorage |
| 🔡 Font Size | A- / A / A+ selector |
| 📍 Breadcrumbs | Present on all inner pages |
| ⏳ Page Loader | Spinner on every page load |

## Color Scheme

| Role | Color | HEX |
|---|---|---|
| Main background | Very dark navy | `#050910` |
| Sidebar / dark panels | Dark charcoal | `#121419` |
| Cards | Charcoal | `#1F2228` |
| Deep black | Black | `#020103` |
| Secondary text | Gray | `#687589` |
| Borders / muted | Gray-blue | `#343A46` |
| Main text | Off-white | `#D6CBD6` |
| Purple accent | Royal purple | `#4A26B7` |

## Quick Start

```powershell
# 1. Run the automated setup script
.\setup.ps1

# OR manually:
composer install
npm install
php artisan migrate:fresh --seed --force
php artisan storage:link
npm run build

# 2. Start development server
php artisan serve
# Visit: http://localhost:8000
```

## Test Accounts

| Role | Email | Password |
|---|---|---|
| Admin | admin@fanhubplus.com | password |
| Fan User | fan@fanhubplus.com | password |
| Gamer User | gamer@fanhubplus.com | password |

## Project Structure

```
app/
  Http/
    Controllers/          # All feature controllers
      Admin/              # Admin panel controllers
      Auth/               # Auth controllers (no Breeze dependency)
    Middleware/
      AdminMiddleware.php
  Models/                 # 14 Eloquent models with relationships
  Providers/

database/
  migrations/             # 13 migration files
  seeders/                # 9 seeders with rich fandom data

resources/
  css/app.css             # Complete design system (no framework deps)
  js/app.js               # Dark mode, chatbot, bookmarks, star ratings
  views/
    layouts/              # app.blade.php, admin.blade.php
    home.blade.php
    dashboard.blade.php
    auth/                 # login, register, forgot, reset, verify
    content/              # index, show, category
    multimedia/           # index, show
    characters/           # index, show
    articles/             # index, show, submit
    merchandise/          # index, show
    events/               # index, show (with Leaflet map)
    bookmarks/            # index
    feedback/             # create
    profile/              # edit
    admin/                # dashboard + CRUD for all types
    vendor/pagination/    # Custom pagination

routes/web.php            # All routes (public, auth, admin)
setup.ps1                 # One-click setup script
```

## Fandom Categories

🎌 Anime · 🎮 Gaming · 🎬 Movies · 📺 TV Shows · 🎤 K-Pop · 💥 Comics · 📖 Manga · 🎭 Cosplay
