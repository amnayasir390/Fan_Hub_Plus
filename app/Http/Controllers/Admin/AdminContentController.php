<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\HandlesImageUploads;
use App\Models\Category;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminContentController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request)
    {
        $query = Content::with('category')->latest();
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        $contents   = $query->paginate(20)->withQueryString();
        $categories = Category::orderBy('name')->get();
        return view('admin.content.index', compact('contents', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.content.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateContent($request);
        $data['slug']    = Str::slug($request->title) . '-' . Str::random(4);
        $data['user_id'] = auth()->id();
        if ($image = $this->storeUploadedImage($request, 'cover_image', 'articles')) {
            $data['cover_image'] = $image;
        }
        Content::create($data);
        return redirect()->route('admin.content.index')->with('success', 'Content created.');
    }

    public function edit(Content $content)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.content.form', compact('content', 'categories'));
    }

    public function update(Request $request, Content $content)
    {
        $data = $this->validateContent($request);
        if ($image = $this->storeUploadedImage($request, 'cover_image', 'articles', $content->cover_image)) {
            $data['cover_image'] = $image;
        }
        $content->update($data);
        return redirect()->route('admin.content.index')->with('success', 'Content updated.');
    }

    public function destroy(Content $content)
    {
        $content->delete();
        return back()->with('success', 'Content deleted.');
    }

    private function validateContent(Request $request): array
    {
        return $request->validate([
            'category_id'  => ['required', 'exists:categories,id'],
            'title'        => ['required', 'string', 'max:255'],
            'excerpt'      => ['nullable', 'string', 'max:500'],
            'body'         => ['nullable', 'string'],
            'content_type' => ['required', 'in:article,profile,media'],
            'genre'        => ['nullable', 'string', 'max:100'],
            'release_year' => ['nullable', 'integer', 'min:1900', 'max:2030'],
            'status'       => ['required', 'in:draft,published,pending'],
            'tags'         => ['nullable', 'string'],
            'cover_image'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]) + ['tags' => $request->filled('tags') ? array_map('trim', explode(',', $request->tags)) : null];
    }
}
