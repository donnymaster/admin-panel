@extends('admin-panel.layouts.main')

@section('title', 'Статьи')

@section('content')
    <div class="flex mb-9 items-center text-2xl text-white justify-between">
        <div class="title">
            <span class="pr-1">Статьи</span>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="btn bg-green mr-2">
            <span class="icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="vuesax/broken/additem">
                        <g id="additem">
                            <path id="Vector" d="M2 5.43C2 3.14 3.14 2 5.43 2H10C12.29 2 13.43 3.14 13.43 5.43"
                                stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path id="Vector_2" d="M8 16H5.43C3.14 16 2 14.86 2 12.57V9.98001" stroke="white"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path id="Vector_3"
                                d="M18.5701 22H14.0001C11.7101 22 10.5701 20.86 10.5701 18.57V11.43C10.5701 9.14 11.7101 8 14.0001 8H18.5701C20.8601 8 22.0001 9.14 22.0001 11.43V18.57C22.0001 20.86 20.8601 22 18.5701 22Z"
                                stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path id="Vector_4" d="M14.8701 15H18.1301" stroke="white" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path id="Vector_5" d="M16.5 16.63V13.37" stroke="white" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                    </g>
                </svg>
            </span>
            Добавить
        </a>
    </div>

    {{ $dataTable->table() }}


    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endsection

@section('sidebar')
    <x-admin.sidebar.statistics item_show="articles" />
@endsection


@section('scripts')
    @vite(['resources/js/pages/articlesPage.js'])
@endsection
