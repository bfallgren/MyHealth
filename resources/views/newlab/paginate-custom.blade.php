@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>{{ __('Prev') }}</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">{{ __('Prev') }}</a></li>
        @endif
        
        
        
        {{ "Page " . $paginator->currentPage() . "  of  " . $paginator->lastPage() }}
       
        
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">{{ __('Next') }}</a></li>
        @else
            <li class="disabled"><span>{{ __('Next') }}</span></li>
        @endif
    </ul>
@endif