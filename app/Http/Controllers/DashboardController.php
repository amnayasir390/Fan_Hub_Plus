<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Recent content based on user's interests
        $interests  = $user->categories_of_interest ?? [];
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        $recentContent = Content::where('status', 'published')
            ->when(!empty($interests), fn($q) => $q->whereHas('category', fn($c) => $c->whereIn('slug', $interests)))
            ->orderByDesc('created_at')
            ->take(6)
            ->with('category')
            ->get();

        $recentArticles = Article::where('status', 'published')
            ->when(!empty($interests), fn($q) => $q->whereHas('category', fn($c) => $c->whereIn('slug', $interests)))
            ->orderByDesc('created_at')
            ->take(4)
            ->with('category')
            ->get();

        // User's bookmarks (latest 6)
        $bookmarks = Bookmark::where('user_id', $user->id)
            ->with('bookmarkable')
            ->latest()
            ->take(6)
            ->get();

        // Fandom category cards for quick nav
        $favoriteFandoms = collect();
        if (!empty($user->favorite_fandoms)) {
            $favoriteFandoms = Category::whereIn('name', $user->favorite_fandoms)
                ->where('is_active', true)
                ->get();
        }

        return view('dashboard', compact(
            'user',
            'categories',
            'recentContent',
            'recentArticles',
            'bookmarks',
            'favoriteFandoms'
        ));
    }
}
