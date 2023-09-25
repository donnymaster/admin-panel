@extends('admin-panel.layouts.main')

@section('title', 'Категории')

@section('content')
    <div class="drop-down-list-container">
    </div>

    <div id="nestedDemo" class="list-group col nested-sortable">
        <div class="list-group-item nested-1">Item 1.1
            <div class="list-group nested-sortable">
                <div class="list-group-item nested-2">Item 2.1</div>
                <div data-id="5" class="list-group-item nested-2">
                    <div class="head category">
                        <div class="title">Item 2.2</div>
                        <div class="count-products">
                            20
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 30 30" fill="none">
                                <path d="M8.5 14.25C8.5 16.17 10.08 17.75 12 17.75C13.92 17.75 15.5 16.17 15.5 14.25" stroke="black" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M8.80994 2L5.18994 5.63" stroke="black" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M15.1899 2L18.8099 5.63" stroke="black" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M2 7.8501C2 6.0001 2.99 5.8501 4.22 5.8501H19.78C21.01 5.8501 22 6.0001 22 7.8501C22 10.0001 21.01 9.8501 19.78 9.8501H4.22C2.99 9.8501 2 10.0001 2 7.8501Z" stroke="black" stroke-width="1.5"></path>
                                <path d="M3.5 10L4.91 18.64C5.23 20.58 6 22 8.86 22H14.89C18 22 18.46 20.64 18.82 18.76L20.5 10" stroke="black" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg>
                        </div>
                        <div class="pagination">
                            <div class="left"><</div>
                            <div class="right">></div>
                        </div>
                    </div>
                    <div class="list-group nested-sortable">
                        <div class="list-group-item nested-3">Item 3.1</div>
                        <div class="list-group-item nested-3" draggable="false">Item 3.2</div>
                        <div class="list-group-item nested-3">Item 3.3</div>
                        <div class="list-group-item nested-3">Item 3.4</div>

                    </div>
                </div>
                <div class="list-group-item nested-2">Item 2.3</div>
                <div class="list-group-item nested-2 new-element">Item 2.4</div>
            </div>
        </div>
    </div>

    @vite(['resources/js/pages/categoryPage.js'])
@endsection

@section('sidebar')
    <x-admin.sidebar.categories />
@endsection
