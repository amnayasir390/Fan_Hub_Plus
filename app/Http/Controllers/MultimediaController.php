<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MediaItem;
use App\Models\Rating;
use Illuminate\Http\Request;

class MultimediaController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        $query = MediaItem::with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('type')) {
            $query->where('media_type', $request->type);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('title', 'like', "%{$s}%")->orWhere('description', 'like', "%{$s}%"));
        }

        match ($request->get('sort', 'featured')) {
            'popular'  => $query->orderByDesc('view_count'),
            'latest'   => $query->orderByDesc('created_at'),
            default    => $query->orderByDesc('is_featured')->orderByDesc('created_at'),
        };

        $mediaItems = $query->paginate(12)->withQueryString();

        return view('multimedia.index', compact('mediaItems', 'categories'));
    }

    public function show(int $id)
    {
        $item = MediaItem::with('category')->findOrFail($id);
        $item->increment('view_count');

        $related = MediaItem::where('category_id', $item->category_id)
            ->where('id', '!=', $item->id)
            ->orderByDesc('view_count')
            ->take(4)
            ->get();

        $userRating = null;
        $isBookmarked = false;
        if (auth()->check()) {
            $userRating   = Rating::where('user_id', auth()->id())->where('ratable_type', MediaItem::class)->where('ratable_id', $item->id)->first();
            $isBookmarked = $item->bookmarks()->where('user_id', auth()->id())->exists();
        }

        return view('multimedia.show', compact('item', 'related', 'userRating', 'isBookmarked'));
    }

    public function rate(Request $request, int $id)
    {
        $request->validate(['score' => ['nullable', 'integer', 'min:1', 'max:5'], 'thumbs_up' => ['nullable', 'boolean']]);

        $item = MediaItem::findOrFail($id);

        Rating::updateOrCreate(
            ['user_id' => auth()->id(), 'ratable_type' => MediaItem::class, 'ratable_id' => $id],
            ['score' => $request->score, 'thumbs_up' => $request->thumbs_up]
        );

        return back()->with('success', 'Your rating has been saved.');
    }
}
