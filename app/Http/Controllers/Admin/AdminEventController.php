<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('category')->orderBy('start_date');
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        $events     = $query->paginate(20)->withQueryString();
        $categories = Category::orderBy('name')->get();
        return view('admin.events.index', compact('events', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.events.form', compact('categories'));
    }

    public function store(Request $request)
    {
        Event::create($this->validateEvent($request));
        return redirect()->route('admin.events.index')->with('success', 'Event created.');
    }

    public function edit(Event $event)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.events.form', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        $event->update($this->validateEvent($request));
        return redirect()->route('admin.events.index')->with('success', 'Event updated.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return back()->with('success', 'Event deleted.');
    }

    private function validateEvent(Request $request): array
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_type'  => ['required', 'in:convention,meetup,screening,premiere,release'],
            'start_date'  => ['required', 'date'],
            'end_date'    => ['nullable', 'date', 'after_or_equal:start_date'],
            'venue'       => ['nullable', 'string', 'max:255'],
            'city'        => ['nullable', 'string', 'max:100'],
            'country'     => ['nullable', 'string', 'max:100'],
            'latitude'    => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'   => ['nullable', 'numeric', 'between:-180,180'],
            'ticket_link' => ['nullable', 'url', 'max:500'],
            'is_featured' => ['boolean'],
        ]);
        $validated['is_featured'] = $request->boolean('is_featured');
        return $validated;
    }
}
