@if ($paginator->hasPages())
    <div class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="btn" style="opacity: 0.5; cursor: not-allowed;">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn" rel="prev">&laquo;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="btn" style="opacity: 0.5; cursor: not-allowed;">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="btn btn-active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn" rel="next">&raquo;</a>
        @else
            <span class="btn" style="opacity: 0.5; cursor: not-allowed;">&raquo;</span>
        @endif
    </div>
@endif
