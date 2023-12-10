@if ($paginator->hasPages())
    <div class="pagination">
        <div class="icon">
            @if ($paginator->onFirstPage())
                <x-grommet-previous />
            @else
                <a href="{{ $paginator->previousPageUrl() }}"><x-grommet-previous /></a>
            @endif
        </div>

        <div>
            {{ $paginator->currentPage() }}/{{ $paginator->lastPage() }}
        </div>

        <div class="icon">
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"><x-grommet-next /></a>
            @else
                <x-grommet-next />
            @endif
        </div>
    </div>
@endif
