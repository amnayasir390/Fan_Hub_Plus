<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        $query = Character::with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%{$s}%")->orWhere('series', 'like', "%{$s}%")->orWhere('bio', 'like', "%{$s}%"));
        }

        match ($request->get('sort', 'popular')) {
            'alpha'  => $query->orderBy('name'),
            'latest' => $query->orderByDesc('created_at'),
            default  => $query->orderByDesc('popularity'),
        };

        $characters = $query->paginate(16)->withQueryString();
        $genres     = Character::whereNotNull('genre')->distinct()->pluck('genre')->sort()->values();

        return view('characters.index', compact('characters', 'categories', 'genres'));
    }

    public function show(string $slug)
    {
        $character = Character::where('slug', $slug)->with('category')->firstOrFail();

        $related = Character::where('category_id', $character->category_id)
            ->where('id', '!=', $character->id)
            ->orderByDesc('popularity')
            ->take(4)
            ->get();

        $isBookmarked = false;
        if (auth()->check()) {
            $isBookmarked = $character->bookmarks()->where('user_id', auth()->id())->exists();
        }

        return view('characters.show', compact('character', 'related', 'isBookmarked'));
    }
}
