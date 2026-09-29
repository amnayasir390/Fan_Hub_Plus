<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\HandlesImageUploads;
use App\Models\Category;
use App\Models\Merchandise;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminMerchandiseController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request)
    {
        $query = Merchandise::with('category')->latest();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $merchandise = $query->paginate(20)->withQueryString();
        $categories  = Category::orderBy('name')->get();
        return view('admin.merchandise.index', compact('merchandise', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.merchandise.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateMerchandise($request);
        $data['slug'] = Str::slug($request->name) . '-' . Str::random(4);
        if ($image = $this->storeUploadedImage($request, 'image', 'merchandise')) {
            $data['image'] = $image;
        }
        Merchandise::create($data);
        return redirect()->route('admin.merchandise.index')->with('success', 'Merchandise created.');
    }

    public function edit(Merchandise $merchandise)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('admin.merchandise.form', compact('merchandise', 'categories'));
    }

    public function update(Request $request, Merchandise $merchandise)
    {
        $data = $this->validateMerchandise($request);
        if ($image = $this->storeUploadedImage($request, 'image', 'merchandise', $merchandise->image)) {
            $data['image'] = $image;
        }
        $merchandise->update($data);
        return redirect()->route('admin.merchandise.index')->with('success', 'Merchandise updated.');
    }

    public function destroy(Merchandise $merchandise)
    {
        $merchandise->delete();
        return back()->with('success', 'Merchandise deleted.');
    }

    private function validateMerchandise(Request $request): array
    {
        $validated = $request->validate([
            'category_id'  => ['required', 'exists:categories,id'],
            'name'         => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'price'        => ['nullable', 'numeric', 'min:0'],
            'badge'        => ['nullable', 'in:Limited Edition,Pre-Order,Collectible'],
            'status'       => ['required', 'in:available,pre-order,sold-out'],
            'release_date' => ['nullable', 'date'],
            'buy_link'     => ['nullable', 'url', 'max:500'],
            'is_featured'  => ['boolean'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
        $validated['is_featured'] = $request->boolean('is_featured');
        return $validated;
    }
}
