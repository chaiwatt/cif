@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link p-0 d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; color: #EAECF0; background-color: #F9FAFB;" aria-hidden="true">
                        <span class="material-symbols-outlined">
                            keyboard_arrow_left
                        </span>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link p-0 d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; color: #101828;" href="{{ $paginator->previousPageUrl() }}" rel="prev" style="width: 40px; height: 40px;" aria-label="@lang('pagination.previous')">
                        <span class="material-symbols-outlined">
                            keyboard_arrow_left
                        </span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    <li class="page-item">
                        <div class="page-link p-0 d-flex justify-content-center align-items-center gap-1 text-primary" style="width: 60px; height: 40px;">
                            <span>{{ $paginator->currentPage() }}</span> <span style="color: #667085;">/ {{ count($element) }}</span> 
                        </div>
                    </li>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link p-0 d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; color: #101828;" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <span class="material-symbols-outlined">
                            keyboard_arrow_right
                        </span>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" style="width: 40px; height: 40px;" aria-label="@lang('pagination.next')">
                    <span class="page-link p-0 d-flex justify-content-center align-items-center" aria-hidden="true" style="width: 40px; height: 40px; color: #EAECF0; background-color: #F9FAFB;">
                        <span class="material-symbols-outlined">
                            keyboard_arrow_right
                        </span>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
