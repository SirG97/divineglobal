@if ($paginator->hasPages())
    <style>
        .pagination {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.25rem;
        }

        .page-item:first-child .page-link {
            margin-left: 0;
            border-top-left-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
        }

        .page-item:last-child .page-link {
            border-top-right-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
        }

        .page-item.active .page-link {
            z-index: 2;
            color: #fff;
            background-color: #0FACF3;
            border-color: #0FACF3;
        }

        .page-item.disabled .page-link {
            color: #868e96;
            pointer-events: none;
            background-color: #fff;
            border-color: #ddd;
        }

        .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #0FACF3;
            background-color: #fff;
            border: 1px solid #ddd;
        }

        .page-link:focus,
        .page-link:hover {
            color: #097aad;
            text-decoration: none;
            background-color: #e9ecef;
            border-color: #ddd;
        }

        .pagination-lg .page-link {
            padding: 0.75rem 1.5rem;
            font-size: 1.25rem;
            line-height: 1.5;
        }

        .pagination-lg .page-item:first-child .page-link {
            border-top-left-radius: 0.3rem;
            border-bottom-left-radius: 0.3rem;
        }

        .pagination-lg .page-item:last-child .page-link {
            border-top-right-radius: 0.3rem;
            border-bottom-right-radius: 0.3rem;
        }

        .pagination-sm .page-link {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .pagination-sm .page-item:first-child .page-link {
            border-top-left-radius: 0.2rem;
            border-bottom-left-radius: 0.2rem;
        }

        .pagination-sm .page-item:last-child .page-link {
            border-top-right-radius: 0.2rem;
            border-bottom-right-radius: 0.2rem;
        }
    </style>
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
