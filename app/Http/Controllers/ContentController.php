<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        $query = Content::where('status', 'published')->with('category');

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Filter by genre
        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        // Filter by release year
        if ($request->filled('year')) {
            $query->where('release_year', $request->year);
        }

        // Filter by content type
        if ($request->filled('type')) {
            $query->where('content_type', $request->type);
        }

        // Search
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($sq) => $sq->where('title', 'like', "%{$q}%")->orWhere('excerpt', 'like', "%{$q}%"));
        }

        // Sort
        match ($request->get('sort', 'popular')) {
            'latest'      => $query->orderByDesc('created_at'),
            'alpha'       => $query->orderBy('title'),
            'year'        => $query->orderByDesc('release_year'),
            default       => $query->orderByDesc('popularity'),
        };

        $contents = $query->paginate(12)->withQueryString();

        // Available filter values
        $genres = Content::where('status', 'published')->whereNotNull('genre')->distinct()->pluck('genre')->sort()->values();
        $years  = Content::where('status', 'published')->whereNotNull('release_year')->distinct()->pluck('release_year')->sortDesc()->values();

        return view('content.index', compact('contents', 'categories', 'genres', 'years'));
    }

    public function show(string $slug)
    {
        $content = Content::where('slug', $slug)->where('status', 'published')->with('category')->firstOrFail();

        // Increment view count
        $content->increment('view_count');

        // Related content
        $related = Content::where('status', 'published')
            ->where('category_id', $content->category_id)
            ->where('id', '!=', $content->id)
            ->orderByDesc('popularity')
            ->take(4)
            ->get();

        $isBookmarked = false;
        if (auth()->check()) {
            $isBookmarked = $content->bookmarks()->where('user_id', auth()->id())->exists();
        }

        return view('content.show', compact('content', 'related', 'isBookmarked'));
    }

    public function byCategory(string $slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $contents = Content::where('category_id', $category->id)
            ->where('status', 'published')
            ->orderByDesc('popularity')
            ->paginate(12);

        return view('content.category', compact('category', 'contents'));
    }
}
