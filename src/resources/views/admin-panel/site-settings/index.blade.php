@extends('admin-panel.layouts.main')

@section('title', 'Настройки сайта')

@section('content')
    <div class="flex mb-9 items-center text-2xl text-white justify-between">
        <span class="pr-5">Конфигурация сайта</span>
        <div class="btn bg-green mr-2 modal-btn" data-modal="update-setting">
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
        </div>
    </div>

    {{ $dataTable->table() }}


    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

@endsection

@section('sidebar')
    <div class="sidebar"></div>
@endsection


@push('modals')
    <div class="modal-container hidden">
        <div class="modal-overlay hidden"></div>
        <div class="modal hidden" data-modal="update-setting">
            <div class="modal-header">
                <div class="title text-center">Новая переменная</div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
            <form action="">
                <div class="modal-content scrollbar">
                    <div class="input-group">
                        <label for="email" class="label">
                            Label
                        </label>
                        <input id="email" type="text" class="input is-invalid" placeholder="Email">
                        <div class="alert-error">Поле Пароль обязательно для заполнения.</div>
                    </div>
                    <div class="input-group">
                        <label for="email" class="label">
                            Label
                        </label>
                        <input id="email" type="text" class="input is-invalid" placeholder="Email">
                        <div class="alert-error">Поле Пароль обязательно для заполнения.</div>
                    </div>
                    <div class="input-group">
                        <label for="email" class="label">
                            Label
                        </label>
                        <input id="email" type="text" class="input is-invalid" placeholder="Email">
                        <div class="alert-error">Поле Пароль обязательно для заполнения.</div>
                    </div>
                </div>
                <div class="modal-footer flex items-end">
                        <div class="btn bg-theme-red mr-2">
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
                                                stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path id="Vector_4" d="M14.8701 15H18.1301" stroke="white" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path id="Vector_5" d="M16.5 16.63V13.37" stroke="white" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            Закрыть
                        </div>
                        <div class="btn bg-green mr-2">
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
                            Добавить
                        </div>
                </div>
            </form>
        </div>
    </div>
@endpush
