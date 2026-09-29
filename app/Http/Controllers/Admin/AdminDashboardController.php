<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Character;
use App\Models\Content;
use App\Models\Feedback;
use App\Models\FanSubmission;
use App\Models\MediaItem;
use App\Models\Merchandise;
use App\Models\User;
use App\Models\Event;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users'           => User::count(),
            'contents'        => Content::count(),
            'articles'        => Article::count(),
            'characters'      => Character::count(),
            'media_items'     => MediaItem::count(),
            'merchandise'     => Merchandise::count(),
            'events'          => Event::count(),
            'feedback'        => Feedback::where('status', 'new')->count(),
            'fan_submissions' => FanSubmission::where('status', 'pending')->count(),
            'total_views'     => Content::sum('view_count') + Article::sum('view_count'),
        ];

        $recentUsers       = User::latest()->take(5)->get();
        $recentFeedback    = Feedback::latest()->take(5)->get();
        $pendingSubmissions= FanSubmission::where('status', 'pending')->with(['user', 'category'])->latest()->take(5)->get();
        $popularContent    = Content::where('status', 'published')->orderByDesc('view_count')->take(5)->with('category')->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentFeedback', 'pendingSubmissions', 'popularContent'));
    }
}
