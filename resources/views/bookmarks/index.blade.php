@extends('layouts.app')
@section('title', 'My Bookmarks')

@section('content')
<div class="container py-section">
    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">/</span><span>Bookmarks</span>
    </div>

    <div class="section-header">
        <h1 class="section-title">🔖 My Bookmarks</h1>
        <span style="color:var(--text-secondary);font-size:0.875rem;">{{ $bookmarks->total() }} saved items</span>
    </div>

    @if($bookmarks->count())
    <div style="display:flex;flex-direction:column;gap:1rem;">
        @foreach($bookmarks as $bm)
        @php $item = $bm->bookmarkable; @endphp
        @if(!$item) @continue @endif
        <div class="card" style="display:flex;align-items:stretch;overflow:hidden;">
            {{-- Saved item image --}}
            <div style="width:100px;flex-shrink:0;background:rgba(74,38,183,0.15);display:flex;align-items:center;justify-content:center;padding:0.5rem;">
                <x-image-or-icon
                    :path="match(class_basename($item)) { 'Article' => $item->cover_image, 'Character' => $item->image, 'Merchandise' => $item->image, 'Content' => $item->cover_image, default => null }"
                    :icon="match(class_basename($item)) { 'Article' => 'fa-newspaper', 'Character' => 'fa-user', 'MediaItem' => 'fa-film', 'Merchandise' => 'fa-bag-shopping', 'Content' => 'fa-file-lines', default => 'fa-bookmark' }"
                    size="72px" alt="Saved item" />
                <div style="display:none;font-size:0.65rem;color:var(--text-secondary);font-weight:700;text-transform:uppercase;text-align:center;">
                    {{ match(class_basename($item)) { 'Article' => 'Article', 'Character' => 'Char', 'MediaItem' => 'Media', 'Merchandise' => 'Merch', default => 'Item' } }}
                </div>
            </div>

            {{-- Content --}}
            <div style="flex:1;padding:1rem;min-width:0;">
                <div style="font-weight:700;font-size:0.95rem;margin-bottom:0.25rem;color:var(--text-main);">
                    {{ $item->title ?? $item->name ?? 'Unnamed item' }}
                </div>
                @if(isset($item->excerpt) && $item->excerpt)
                <div style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:0.5rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $item->excerpt }}</div>
                @elseif(isset($item->description) && $item->description)
                <div style="font-size:0.82rem;color:var(--text-secondary);margin-bottom:0.5rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $item->description }}</div>
                @endif
                <div style="font-size:0.75rem;color:var(--text-secondary);">Saved {{ $bm->created_at->diffForHumans() }}</div>

                {{-- Note --}}
                @if($bm->note)
                <div style="margin-top:0.5rem;background:rgba(74,38,183,0.1);border-radius:6px;padding:0.4rem 0.6rem;font-size:0.78rem;color:var(--text-secondary);">
                    📌 {{ $bm->note }}
                </div>
                @endif

                {{-- Note form --}}
                <form method="POST" action="{{ route('bookmarks.note', $bm->id) }}" style="margin-top:0.75rem;display:flex;gap:0.5rem;" x-data>
                    @csrf @method('PATCH')
                    <input type="text" name="note" class="form-input" style="font-size:0.8rem;padding:0.35rem 0.6rem;" placeholder="Add a note…" value="{{ $bm->note }}">
                    <button type="submit" class="btn btn-ghost btn-sm">💾</button>
                </form>
            </div>

            {{-- Actions --}}
            <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0.5rem;padding:1rem;flex-shrink:0;border-left:1px solid var(--border);">
                {{-- View link --}}
                @php
                    $viewRoute = match(class_basename($item)) {
                        'Article'     => route('articles.show', $item->slug ?? $item->id),
                        'Character'   => route('characters.show', $item->slug ?? $item->id),
                        'MediaItem'   => route('multimedia.show', $item->id),
                        'Merchandise' => route('merchandise.show', $item->slug ?? $item->id),
                        'Content'     => route('content.show', $item->slug ?? $item->id),
                        default       => '#'
                    };
                @endphp
                <a href="{{ $viewRoute }}" class="btn btn-secondary btn-sm">View</a>
                <form method="POST" action="{{ route('bookmarks.destroy', $bm->id) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Remove this bookmark?')">Remove</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <div class="pagination">{{ $bookmarks->links('vendor.pagination.custom') }}</div>
    @else
    <div style="text-align:center;padding:4rem;background:var(--bg-card);border-radius:12px;border:1px solid var(--border);">
        <div style="font-size:3rem;margin-bottom:1rem;">🔖</div>
        <h3 style="margin-bottom:0.5rem;">No bookmarks yet</h3>
        <p style="color:var(--text-secondary);margin-bottom:1.5rem;">
            Start exploring content and click the 🔖 button to save items you love.
        </p>
        <div style="display:flex;gap:0.75rem;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('content.index') }}"    class="btn btn-primary">Explore Content</a>
            <a href="{{ route('characters.index') }}" class="btn btn-secondary">Browse Characters</a>
            <a href="{{ route('multimedia.index') }}" class="btn btn-secondary">Watch Media</a>
        </div>
    </div>
    @endif
</div>
@endsection
