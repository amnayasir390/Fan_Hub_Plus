@if ($paginator->hasPages())
<div class="pagination" role="navigation" aria-label="Pagination">
    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span class="disabled">← Prev</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}">← Prev</a>
    @endif

    {{-- Pages --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="disabled">{{ $element }}</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="active" aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}">Next →</a>
    @else
        <span class="disabled">Next →</span>
    @endif
</div>
@endif
