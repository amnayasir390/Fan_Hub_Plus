<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\HandlesImageUploads;
use App\Models\Article;
use App\Models\Category;
use App\Models\FanSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminArticleController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request)
    {
        $query = Article::with(['category', 'user'])->latest();
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $articles   = $query->paginate(20)->withQueryString();
        $categories = Category::orderBy('name')->get();
        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.articles.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateArticle($request);
        $data['slug']    = Str::slug($request->title) . '-' . Str::random(4);
        $data['user_id'] = auth()->id();
        if ($image = $this->storeUploadedImage($request, 'cover_image', 'articles')) {
            $data['cover_image'] = $image;
        }
        Article::create($data);
        return redirect()->route('admin.articles.index')->with('success', 'Article created.');
    }

    public function edit(Article $article)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.articles.form', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $this->validateArticle($request);
        if ($image = $this->storeUploadedImage($request, 'cover_image', 'articles', $article->cover_image)) {
            $data['cover_image'] = $image;
        }
        $article->update($data);
        return redirect()->route('admin.articles.index')->with('success', 'Article updated.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return back()->with('success', 'Article deleted.');
    }

    // Fan Submission management
    public function submissions(Request $request)
    {
        $submissions = FanSubmission::with(['user', 'category'])
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20)
            ->withQueryString();
        return view('admin.articles.submissions', compact('submissions'));
    }

    public function approveSubmission(FanSubmission $submission)
    {
        // Convert to article
        Article::create([
            'category_id'  => $submission->category_id,
            'user_id'      => $submission->user_id,
            'title'        => $submission->title,
            'slug'         => Str::slug($submission->title) . '-fan-' . $submission->id,
            'excerpt'      => $submission->excerpt,
            'body'         => $submission->body,
            'article_type' => 'fan_submission',
            'status'       => 'published',
        ]);
        $submission->update(['status' => 'approved']);
        return back()->with('success', 'Fan submission approved and published.');
    }

    public function rejectSubmission(Request $request, FanSubmission $submission)
    {
        $submission->update(['status' => 'rejected', 'admin_notes' => $request->admin_notes]);
        return back()->with('success', 'Fan submission rejected.');
    }

    private function validateArticle(Request $request): array
    {
        $validated = $request->validate([
            'category_id'    => ['required', 'exists:categories,id'],
            'title'          => ['required', 'string', 'max:255'],
            'excerpt'        => ['nullable', 'string', 'max:500'],
            'body'           => ['required', 'string'],
            'article_type'   => ['required', 'in:article,event_highlight,fan_submission'],
            'status'         => ['required', 'in:draft,published,pending'],
            'is_featured'    => ['boolean'],
            'event_date'     => ['nullable', 'date'],
            'event_location' => ['nullable', 'string', 'max:255'],
            'tags'           => ['nullable', 'string'],
            'cover_image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['tags']        = $request->filled('tags') ? array_map('trim', explode(',', $request->tags)) : null;
        return $validated;
    }
}
