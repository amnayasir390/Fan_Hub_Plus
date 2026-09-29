<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\FanSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        $query = Article::where('status', 'published')->with(['category', 'user']);

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('type')) {
            $query->where('article_type', $request->type);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('title', 'like', "%{$s}%")->orWhere('excerpt', 'like', "%{$s}%"));
        }

        match ($request->get('sort', 'latest')) {
            'popular' => $query->orderByDesc('view_count'),
            'alpha'   => $query->orderBy('title'),
            default   => $query->orderByDesc('created_at'),
        };

        $articles        = $query->paginate(12)->withQueryString();
        $eventHighlights = Article::where('status', 'published')
            ->where('article_type', 'event_highlight')
            ->orderByDesc('event_date')
            ->take(5)
            ->with('category')
            ->get();

        return view('articles.index', compact('articles', 'categories', 'eventHighlights'));
    }

    public function show(string $slug)
    {
        $article = Article::where('slug', $slug)->where('status', 'published')->with(['category', 'user'])->firstOrFail();
        $article->increment('view_count');

        $related = Article::where('status', 'published')
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->orderByDesc('view_count')
            ->take(3)
            ->get();

        $isBookmarked = false;
        if (auth()->check()) {
            $isBookmarked = $article->bookmarks()->where('user_id', auth()->id())->exists();
        }

        return view('articles.show', compact('article', 'related', 'isBookmarked'));
    }

    public function submitForm()
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        return view('articles.submit', compact('categories'));
    }

    public function submitStore(Request $request)
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'excerpt'     => ['required', 'string', 'max:500'],
            'body'        => ['required', 'string', 'min:100'],
        ]);

        FanSubmission::create([
            'user_id'     => auth()->id(),
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'excerpt'     => $request->excerpt,
            'body'        => $request->body,
            'status'      => 'pending',
        ]);

        return redirect()->route('articles.index')->with('success', 'Your submission has been received and is pending admin review. Thank you!');
    }
}
