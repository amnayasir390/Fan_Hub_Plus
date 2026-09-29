<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    // Morph map for bookmarkable types
    protected array $morphMap = [
        'article'     => \App\Models\Article::class,
        'character'   => \App\Models\Character::class,
        'media'       => \App\Models\MediaItem::class,
        'merchandise' => \App\Models\Merchandise::class,
        'content'     => \App\Models\Content::class,
    ];

    public function index()
    {
        $bookmarks = Bookmark::where('user_id', auth()->id())
            ->with('bookmarkable')
            ->latest()
            ->paginate(16);

        return view('bookmarks.index', compact('bookmarks'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'type' => ['required', 'in:article,character,media,merchandise,content'],
            'id'   => ['required', 'integer'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $morphClass = $this->morphMap[$request->type];

        $existing = Bookmark::where('user_id', auth()->id())
            ->where('bookmarkable_type', $morphClass)
            ->where('bookmarkable_id', $request->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $bookmarked = false;
            $message    = 'Bookmark removed.';
        } else {
            Bookmark::create([
                'user_id'          => auth()->id(),
                'bookmarkable_type'=> $morphClass,
                'bookmarkable_id'  => $request->id,
                'note'             => $request->note,
            ]);
            $bookmarked = true;
            $message    = 'Bookmarked successfully!';
        }

        if ($request->wantsJson()) {
            return response()->json(['bookmarked' => $bookmarked, 'message' => $message]);
        }

        return back()->with('success', $message);
    }

    public function destroy(int $id)
    {
        $bookmark = Bookmark::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $bookmark->delete();
        return back()->with('success', 'Bookmark removed.');
    }

    public function updateNote(Request $request, int $id)
    {
        $request->validate(['note' => ['nullable', 'string', 'max:500']]);
        $bookmark = Bookmark::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $bookmark->update(['note' => $request->note]);
        return back()->with('success', 'Note updated.');
    }
}
