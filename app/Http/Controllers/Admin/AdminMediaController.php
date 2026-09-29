<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MediaItem;
use Illuminate\Http\Request;

class AdminMediaController extends Controller
{
    public function index(Request $request)
    {
        $query = MediaItem::with('category')->latest();
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('type')) {
            $query->where('media_type', $request->type);
        }
        $mediaItems = $query->paginate(20)->withQueryString();
        $categories = Category::orderBy('name')->get();
        return view('admin.media.index', compact('mediaItems', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.media.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateMedia($request);
        $data['uploaded_by'] = auth()->id();
        MediaItem::create($data);
        return redirect()->route('admin.media.index')->with('success', 'Media item created.');
    }

    public function edit(MediaItem $mediaItem)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.media.form', compact('mediaItem', 'categories'));
    }

    public function update(Request $request, MediaItem $mediaItem)
    {
        $mediaItem->update($this->validateMedia($request));
        return redirect()->route('admin.media.index')->with('success', 'Media item updated.');
    }

    public function destroy(MediaItem $mediaItem)
    {
        $mediaItem->delete();
        return back()->with('success', 'Media item deleted.');
    }

    private function validateMedia(Request $request): array
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'media_type'  => ['required', 'in:video,audio,image,trailer'],
            'url'         => ['required', 'string', 'max:500'],
            'thumbnail'   => ['nullable', 'string', 'max:500'],
            'duration'    => ['nullable', 'string', 'max:20'],
            'is_featured' => ['boolean'],
            'tags'        => ['nullable', 'string'],
        ]);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['tags']        = $request->filled('tags') ? array_map('trim', explode(',', $request->tags)) : null;
        return $validated;
    }
}
