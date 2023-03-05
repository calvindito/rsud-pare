@if($paginator->hasPages())
    <div class="d-flex justify-content-center pt-1 mb-1">
        <ul class="pagination pagination-flat">
            @if(!$paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link rounded-pill" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="ph-arrow-left"></i>
                    </a>
                </li>
            @endif
            @foreach($elements as $element)
                @if(is_string($element))
                    <li class="page-item align-self-center">
                        <span class="mx-2">{{ $element }}</span>
                    </li>
                @endif
                @if(is_array($element))
                    @foreach($element as $page => $url)
                        @if($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <a class="page-link rounded-pill" href="javascript:void(0);">{{ $page }}</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link rounded-pill" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link rounded-pill" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <i class="ph-arrow-right"></i>
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif
