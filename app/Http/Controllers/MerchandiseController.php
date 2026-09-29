<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Merchandise;
use Illuminate\Http\Request;

class MerchandiseController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        $query = Merchandise::with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('badge')) {
            $query->where('badge', $request->badge);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%{$s}%")->orWhere('description', 'like', "%{$s}%"));
        }

        match ($request->get('sort', 'popular')) {
            'latest'   => $query->orderByDesc('created_at'),
            'price_lo' => $query->orderBy('price'),
            'price_hi' => $query->orderByDesc('price'),
            'alpha'    => $query->orderBy('name'),
            default    => $query->orderByDesc('popularity'),
        };

        $merchandise = $query->paginate(12)->withQueryString();

        // Upcoming releases
        $upcomingReleases = Merchandise::whereNotNull('release_date')
            ->where('release_date', '>', now())
            ->orderBy('release_date')
            ->take(6)
            ->with('category')
            ->get();

        return view('merchandise.index', compact('merchandise', 'categories', 'upcomingReleases'));
    }

    public function show(string $slug)
    {
        $item = Merchandise::where('slug', $slug)->with('category')->firstOrFail();
        $item->increment('view_count');

        $related = Merchandise::where('category_id', $item->category_id)
            ->where('id', '!=', $item->id)
            ->orderByDesc('popularity')
            ->take(4)
            ->get();

        $isBookmarked = false;
        if (auth()->check()) {
            $isBookmarked = $item->bookmarks()->where('user_id', auth()->id())->exists();
        }

        return view('merchandise.show', compact('item', 'related', 'isBookmarked'));
    }
}
