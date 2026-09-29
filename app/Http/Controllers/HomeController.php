<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Character;
use App\Models\Content;
use App\Models\Event;
use App\Models\MediaItem;
use App\Models\Merchandise;

class HomeController extends Controller
{
    public function index()
    {
        $categories     = Category::where('is_active', true)->orderBy('sort_order')->get();
        $featuredItems  = Content::where('status', 'published')->orderByDesc('popularity')->take(6)->with('category')->get();
        $featuredMedia  = MediaItem::where('is_featured', true)->take(4)->with('category')->get();
        $featuredArticles = Article::where('status', 'published')->where('is_featured', true)->take(4)->with('category')->get();
        $upcomingEvents = Event::upcoming()->take(3)->with('category')->get();
        $featuredChars  = Character::where('is_featured', true)->take(6)->with('category')->get();
        $featuredMerch  = Merchandise::where('is_featured', true)->take(4)->with('category')->get();

        return view('home', compact(
            'categories',
            'featuredItems',
            'featuredMedia',
            'featuredArticles',
            'upcomingEvents',
            'featuredChars',
            'featuredMerch'
        ));
    }
}
