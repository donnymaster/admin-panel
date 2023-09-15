@extends('admin-panel.layouts.main')

@section('title', '')

@section('content')
    <form action="{{route('admin.settings.store')}}" method="POST">
        @csrf
        <div class="columns-2 mb-9">
            <div class="input-group">
                <label for="tinymce_key" class="label flex">
                    <span>TinyMCE KEY</span>
                </label>
                <input id="tinymce_key" name="tinymce_key" type="text" class="input @error('tinymce_key') is-invalid @enderror" value="{{config('app.tinymce_key')}}">
                @error('tinymce_key')
                    <div class="alert-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-group">
                <label for="tinymce_link" class="label">
                    TinyMCE Link
                </label>
                <input id="tinymce_link" name="tinymce_link" type="text" class="input @error('tinymce_link') is-invalid @enderror" value="{{config('app.tinymce_link')}}">
                @error('tinymce_link')
                    <div class="alert-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="flex">
            <button type="submit" class="btn bg-green ml-auto">
                <span class="icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="vuesax/broken/additem">
                            <g id="additem">
                                <path id="Vector" d="M2 5.43C2 3.14 3.14 2 5.43 2H10C12.29 2 13.43 3.14 13.43 5.43"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path id="Vector_2" d="M8 16H5.43C3.14 16 2 14.86 2 12.57V9.98001" stroke="white"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path id="Vector_3"
                                    d="M18.5701 22H14.0001C11.7101 22 10.5701 20.86 10.5701 18.57V11.43C10.5701 9.14 11.7101 8 14.0001 8H18.5701C20.8601 8 22.0001 9.14 22.0001 11.43V18.57C22.0001 20.86 20.8601 22 18.5701 22Z"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path id="Vector_4" d="M14.8701 15H18.1301" stroke="white" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path id="Vector_5" d="M16.5 16.63V13.37" stroke="white" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                        </g>
                    </svg>
                </span>
                Обновить
            </button>
        </div>
    </form>
@endsection

@section('sidebar')
    <div class="sidebar"></div>
@endsection
