<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\HandlesImageUploads;
use App\Models\Category;
use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCharacterController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request)
    {
        $query = Character::with('category')->latest();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $characters = $query->paginate(20)->withQueryString();
        $categories = Category::orderBy('name')->get();
        return view('admin.characters.index', compact('characters', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.characters.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateCharacter($request);
        $data['slug'] = Str::slug($request->name) . '-' . Str::random(4);
        if ($image = $this->storeUploadedImage($request, 'image', 'characters')) {
            $data['image'] = $image;
        }
        Character::create($data);
        return redirect()->route('admin.characters.index')->with('success', 'Character created.');
    }

    public function edit(Character $character)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.characters.form', compact('character', 'categories'));
    }

    public function update(Request $request, Character $character)
    {
        $data = $this->validateCharacter($request);
        if ($image = $this->storeUploadedImage($request, 'image', 'characters', $character->image)) {
            $data['image'] = $image;
        }
        $character->update($data);
        return redirect()->route('admin.characters.index')->with('success', 'Character updated.');
    }

    public function destroy(Character $character)
    {
        $character->delete();
        return back()->with('success', 'Character deleted.');
    }

    private function validateCharacter(Request $request): array
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'series'      => ['nullable', 'string', 'max:255'],
            'bio'         => ['nullable', 'string'],
            'genre'       => ['nullable', 'string', 'max:100'],
            'abilities'   => ['nullable', 'string'],
            'tags'        => ['nullable', 'string'],
            'is_featured' => ['boolean'],
            'popularity'  => ['nullable', 'integer', 'min:0', 'max:100'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['abilities']   = $request->filled('abilities') ? array_map('trim', explode(',', $request->abilities)) : null;
        $validated['tags']        = $request->filled('tags') ? array_map('trim', explode(',', $request->tags)) : null;
        return $validated;
    }
}
