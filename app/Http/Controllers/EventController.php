<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        $query = Event::with('category')->orderBy('start_date');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('type')) {
            $query->where('event_type', $request->type);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('title', 'like', "%{$s}%")->orWhere('city', 'like', "%{$s}%")->orWhere('venue', 'like', "%{$s}%"));
        }

        // Show upcoming by default
        if (!$request->filled('show_past')) {
            $query->where('start_date', '>=', now()->subDay());
        }

        $events = $query->paginate(12)->withQueryString();

        // Map data: all events with lat/lng
        $mapEvents = Event::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('start_date', '>=', now()->subDay())
            ->get(['id', 'title', 'latitude', 'longitude', 'city', 'event_type', 'start_date', 'ticket_link']);

        $cities = Event::whereNotNull('city')->distinct()->pluck('city')->sort()->values();

        return view('events.index', compact('events', 'categories', 'mapEvents', 'cities'));
    }

    public function show(int $id)
    {
        $event = Event::with('category')->findOrFail($id);
        $related = Event::where('id', '!=', $id)
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->take(4)
            ->get();

        return view('events.show', compact('event', 'related'));
    }
}
