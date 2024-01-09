@if ($paginator->hasPages())
    <div class="row my-5">
        <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
        </div>
        <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
            <div class="dataTables_paginate paging_simple_numbers" id="kt_table_users_paginate">
                <ul class="pagination">

                    @if ($paginator->onFirstPage())
                        <li class="paginate_button page-item previous disabled" id="kt_table_users_previous"><a
                                id="paginator-onFirstPage"
                                href="#" aria-controls="kt_table_users" data-dt-idx="0" tabindex="0"
                                class="page-link"><i class="previous"></i></a></li>
                    @else
                        <li class="paginate_button page-item previous" id="kt_table_users_previous"><a
                                id="paginator-previousPageUrl"
                                href="{{ $paginator->previousPageUrl() }}" aria-controls="kt_table_users"
                                data-dt-idx="0" tabindex="0" class="page-link"><i class="previous"></i></a></li>
                    @endif

                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <li class="paginate_button page-item disabled"><a href="#" id="paginator-element"
                                                                              aria-controls="kt_table_users"
                                                                              data-dt-idx="1" tabindex="0"
                                                                              class="page-link">{{ $element }}</a></li>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="paginate_button page-item active"><a href="#" id="paginator-currentPage"
                                                                                    aria-controls="kt_table_users"
                                                                                    data-dt-idx="1" tabindex="0"
                                                                                    class="page-link">{{ $page }}</a>
                                    </li>
                                @else
                                    <li class="paginate_button page-item"><a href="{{ $url }}" id="paginator-url"
                                                                             aria-controls="kt_table_users"
                                                                             data-dt-idx="1" tabindex="0"
                                                                             class="page-link">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif

                    @endforeach

                    @if ($paginator->hasMorePages())
                        <li class="paginate_button page-item next" id="kt_table_users_next"><a
                                id="paginator-nextPageUrl"
                                href="{{ $paginator->nextPageUrl() }}" aria-controls="kt_table_users" data-dt-idx="2"
                                tabindex="0" class="page-link"><i class="next"></i></a></li>
                    @else
                        <li class="paginate_button page-item next disabled" id="kt_table_users_next"><a href="#"
                                                                                                        id="paginator-hasMorePages"
                                                                                                        aria-controls="kt_table_users"
                                                                                                        data-dt-idx="2"
                                                                                                        tabindex="0"
                                                                                                        class="page-link"><i
                                    class="next"></i></a></li>
                    @endif

                </ul>
            </div>
        </div>
    </div>
@endif
