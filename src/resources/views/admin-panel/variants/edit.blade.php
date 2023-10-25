@extends('admin-panel.layouts.main')

@section('title', $variant->title)

@section('content')
    <form method="POST"
        action="{{ route('admin.products.variants.update', ['product' => $variant->product_id, 'variant' => $variant->id]) }}">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session()->has('successfully'))
            <div class="alert alert-success">
                {{ session()->get('successfully') }}
            </div>
        @endif
        @method('PATCH')
        <div class="columns-1 flex justify-between mb-9 divide-x pb-2 text-white text-3xl border-b-2 border-b-white">
            <span>Общие сведения</span>
            <button type="submit" class="btn load-applications small-btn border-none">Обновить</button>
        </div>
        <div data-product="{{ $variant->product_id }}" id="information" class="variant-product flex flex-col">
            <div class="columns-2 mb-4">
                <div class="input-group">
                    <label for="title" class="label">
                        Название
                        <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                    </label>
                    <input id="title" name="title" type="text" class="input"
                        value="{{ old('title') ? old('title') : $variant->title }}">
                </div>
                <div class="input-group">
                    <label for="name_tile" class="label">
                        Заголовок страницы
                        <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                    </label>
                    <input id="name_tile" name="name_tile" type="text" class="input"
                        value="{{ old('name_tile') ? old('name_tile') : $variant->name_tile }}">
                </div>
            </div>
            <div class="columns-2 mb-4">
                <div class="input-group">
                    <label for="price" class="label">
                        Цена
                        <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                    </label>
                    <input id="price" name="price" type="text" class="input"
                        value="{{ old('price') ? old('price') : $variant->price }}">
                </div>
                <div class="input-group">
                    <label for="count" class="label">
                        Количество
                        <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                    </label>
                    <input id="count" name="count" type="number" min="1" class="input"
                        value="{{ old('count') ? old('count') : $variant->count }}">
                </div>
            </div>

            <div
                class="columns-1 text-white mt-4 flex justify-between mb-9 divide-x pb-2 text-3xl border-b-2 border-b-white">
                <span>Свойства</span>
            </div>

            {{-- <div class="accordion" id="accordion-1">
                @if (old('properties'))
                    @foreach ($categories as $category)
                        <div class="accordion__item">
                            <div class="accordion__header">
                                {{ $category->name }} ({{ $category->properties->count() }})
                            </div>
                            <div class="accordion__body">
                                @forelse ($category->properties as $property)
                                    <div class="columns-1 mt-5">
                                        <div class="input-group">
                                            <label title="{{ $property->description }}"
                                                for="properties[{{ $category->id }}][{{ $loop->index }}][property-value]"
                                                class="label flex mb-2">
                                                <span class="mr-2">{{ $property->name }}</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M17 18.4302H13L8.54999 21.3902C7.88999 21.8302 7 21.3602 7 20.5602V18.4302C4 18.4302 2 16.4302 2 13.4302V7.43018C2 4.43018 4 2.43018 7 2.43018H17C20 2.43018 22 4.43018 22 7.43018V13.4302C22 16.4302 20 18.4302 17 18.4302Z"
                                                        stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M12.0001 11.3599V11.1499C12.0001 10.4699 12.4201 10.1099 12.8401 9.81989C13.2501 9.53989 13.66 9.1799 13.66 8.5199C13.66 7.5999 12.9201 6.85986 12.0001 6.85986C11.0801 6.85986 10.3401 7.5999 10.3401 8.5199"
                                                        stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M11.9955 13.75H12.0045" stroke="white" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </label>
                                            <input hidden
                                                name="properties[{{ $category->id }}][{{ $loop->index }}][property-id]"
                                                type="text" class="input" value="{{ $property->id }}">
                                            <input hidden
                                                name="properties[{{ $category->id }}][{{ $loop->index }}][category]"
                                                type="text" class="input" value="{{ $category->id }}">
                                            <input hidden
                                                name="properties[{{ $category->id }}][{{ $loop->index }}][property-name]"
                                                type="text" class="input" value="{{ $property->name }}">
                                            <input
                                                id="properties[{{ $category->id }}][{{ $loop->index }}][property-value]"
                                                name="properties[{{ $category->id }}][{{ $loop->index }}][property-value]"
                                                type="text" class="input"
                                                value="{{ old('properties')[$category->id][$loop->index]['property-value'] }}">
                                            @if (isset(old('properties')[$category->id][$loop->index]['property-value-id']))
                                                <input hidden
                                                    name="properties[{{ $category->id }}][{{ $loop->index }}][property-value-id]"
                                                    type="text" class="input"
                                                    value="{{ old('properties')[$category->id][$loop->index]['property-value-id'] }}"">
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="empty-property text-center mt-3 mb-3 text-xl">
                                        <span class="text-white">Свойства отсутсвуют!</span>
                                        <a class="link white"
                                            href="{{ route('admin.catalog.category.edit', ['category' => $category->id]) }}"
                                            href="">Добавить</a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                @else
                    @foreach ($categories as $category)
                        <div class="accordion__item">
                            <div class="accordion__header">
                                {{ $category->name }} ({{ $category->properties->count() }})
                            </div>
                            <div class="accordion__body">
                                @forelse ($category->properties as $property)
                                    <div class="columns-1 mt-5">
                                        <div class="input-group">
                                            <label title="{{ $property->description }}"
                                                for="properties[{{ $category->id }}][{{ $loop->index }}][property-value]"
                                                class="label flex mb-2">
                                                <span class="mr-2">{{ $property->name }}</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M17 18.4302H13L8.54999 21.3902C7.88999 21.8302 7 21.3602 7 20.5602V18.4302C4 18.4302 2 16.4302 2 13.4302V7.43018C2 4.43018 4 2.43018 7 2.43018H17C20 2.43018 22 4.43018 22 7.43018V13.4302C22 16.4302 20 18.4302 17 18.4302Z"
                                                        stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M12.0001 11.3599V11.1499C12.0001 10.4699 12.4201 10.1099 12.8401 9.81989C13.2501 9.53989 13.66 9.1799 13.66 8.5199C13.66 7.5999 12.9201 6.85986 12.0001 6.85986C11.0801 6.85986 10.3401 7.5999 10.3401 8.5199"
                                                        stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M11.9955 13.75H12.0045" stroke="white" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </label>
                                            <input hidden
                                                name="properties[{{ $category->id }}][{{ $loop->index }}][property-id]"
                                                type="text" class="input" value="{{ $property->id }}">
                                            <input hidden
                                                name="properties[{{ $category->id }}][{{ $loop->index }}][category]"
                                                type="text" class="input" value="{{ $category->id }}">
                                            <input hidden
                                                name="properties[{{ $category->id }}][{{ $loop->index }}][property-name]"
                                                type="text" class="input" value="{{ $property->name }}">
                                            <input
                                                id="properties[{{ $category->id }}][{{ $loop->index }}][property-value]"
                                                name="properties[{{ $category->id }}][{{ $loop->index }}][property-value]"
                                                type="text" class="input"
                                                @if (isset($variantValues[$category->id])) @if (isset($variantValues[$category->id][$property->id]))
                                                value="{{ $variantValues[$category->id][$property->id][0]->value }}" @endif
                                                @endif
                                            >
                                            @if (isset($variantValues[$category->id]))
                                                @if (isset($variantValues[$category->id][$property->id]))
                                                    <input hidden
                                                        name="properties[{{ $category->id }}][{{ $loop->index }}][property-value-id]"
                                                        type="text" class="input"
                                                        value="{{ $variantValues[$category->id][$property->id][0]->id }}">
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    @empty
                                        <div class="empty-property text-center mt-3 mb-3 text-xl">
                                            <span class="text-white">Свойства отсутсвуют!</span>
                                            <a class="link white"
                                                href="{{ route('admin.catalog.category.edit', ['category' => $category->id]) }}"
                                                href="">Добавить</a>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div
                    class="columns-1 text-white mt-4 flex justify-between mb-9 divide-x pb-2 text-3xl border-b-2 border-b-white">
                    <span>Картинки варианта</span>
                    <div class="btn btn-add-image small-btn border-none ml-auto">
                        <span class="loader dark"></span>
                        Добавить
                    </div>
                </div>

                <div style="display:none" class="modal-btn" data-modal="add-image">Добавить</div>

                <div class="load-images-container">
                    <div class="empty-data">
                    </div>
                    <div class="old-data hidden">

                        @if (old('images'))
                            @foreach (old('images') as $imagesOld)
                                <div class="wrap">
                                    @foreach ($imagesOld as $image)
                                        <div class="image">
                                            <input type="text" hidden name="id" value="{{ $image['id'] }}">
                                            <input type="text" hidden name="path" value="{{ $image['path'] }}">
                                            <input type="text" hidden name="size" value="{{ $image['size'] }}">
                                            <input type="text" hidden name="url-path" value="{{ $image['url-path'] }}">
                                            <input type="text" hidden name="width" value="{{ $image['width'] }}">
                                            <input type="text" hidden name="heigth" value="{{ $image['heigth'] }}">
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        @else
                            @foreach ($images as $imageVariant)
                                <div class="wrap">
                                    <div class="image">
                                        <input type="text" hidden name="id" value="{{ $imageVariant['id'] }}">
                                        <input type="text" hidden name="path" value="{{ $imageVariant['path'] }}">
                                        <input type="text" hidden name="size" value="{{ $imageVariant['size'] }}">
                                        <input type="text" hidden name="url-path"
                                            value="{{ $imageVariant['url-path'] }}">
                                        <input type="text" hidden name="width" value="{{ $imageVariant['width'] }}">
                                        <input type="text" hidden name="heigth" value="{{ $imageVariant['heigth'] }}">
                                    </div>
                                    @if (isset($imageVariant['children']))
                                        @foreach ($imageVariant['children'] as $child)
                                            <div class="image">
                                                <input type="text" hidden name="id" value="{{ $child['id'] }}">
                                                <input type="text" hidden name="path" value="{{ $child['path'] }}">
                                                <input type="text" hidden name="size" value="{{ $child['size'] }}">
                                                <input type="text" hidden name="url-path"
                                                    value="{{ $child['url-path'] }}">
                                                <input type="text" hidden name="width" value="{{ $child['width'] }}">
                                                <input type="text" hidden name="heigth" value="{{ $child['heigth'] }}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div> --}}

            <div id="accordion-1" class="accordion">
                @foreach ($propertyWithCategory as $value)
                    <div class="accordion__item">
                        <div class="accordion__header">
                            {{ $value['category']->name }} ({{ $value['properties']->count() }})
                        </div>
                        <div class="accordion__body">
                            @forelse ($value['properties'] as $property)
                                @if (is_array($property))
                                    <div class="columns-1 mt-5">
                                        <div class="input-group">
                                            <label title="{{ $property[0]->description }}"
                                                for="properties[{{ $value['category']->id }}][{{ $loop->index }}][property-value]"
                                                class="label flex mb-2">
                                                <span class="mr-2">{{ $property[0]->name }}</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M17 18.4302H13L8.54999 21.3902C7.88999 21.8302 7 21.3602 7 20.5602V18.4302C4 18.4302 2 16.4302 2 13.4302V7.43018C2 4.43018 4 2.43018 7 2.43018H17C20 2.43018 22 4.43018 22 7.43018V13.4302C22 16.4302 20 18.4302 17 18.4302Z"
                                                        stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M12.0001 11.3599V11.1499C12.0001 10.4699 12.4201 10.1099 12.8401 9.81989C13.2501 9.53989 13.66 9.1799 13.66 8.5199C13.66 7.5999 12.9201 6.85986 12.0001 6.85986C11.0801 6.85986 10.3401 7.5999 10.3401 8.5199"
                                                        stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M11.9955 13.75H12.0045" stroke="white" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </label>
                                            <input hidden
                                                name="properties[{{ $value['category']->id }}][{{ $loop->index }}][property-id]"
                                                type="text" class="input" value="{{ $property[0]->id }}">
                                            <input hidden
                                                name="properties[{{ $value['category']->id }}][{{ $loop->index }}][category]"
                                                type="text" class="input" value="{{ $value['category']->id }}">
                                            <input hidden
                                                name="properties[{{ $value['category']->id }}][{{ $loop->index }}][property-name]"
                                                type="text" class="input" value="{{ $property[0]->name }}">
                                            <input id="properties[{{ $value['category']->id }}][{{ $loop->index }}][property-value]"
                                                name="properties[{{ $value['category']->id }}][{{ $loop->index }}][property-value]"
                                                type="text" class="input"
                                                value="{{ $property[1]->value }}"
                                            >
                                            <input hidden id="properties[{{ $value['category']->id }}][{{ $loop->index }}][property-value-id]"
                                                name="properties[{{ $value['category']->id }}][{{ $loop->index }}][property-value-id]"
                                                type="text" class="input"
                                                value="{{ $property[1]->id }}"
                                            >
                                        </div>
                                    </div>
                                @else
                                    <div class="columns-1 mt-5">
                                        <div class="input-group">
                                            <label title="{{ $property->description }}"
                                                for="properties[{{ $value['category']->id }}][{{ $loop->index }}][property-value]"
                                                class="label flex mb-2">
                                                <span class="mr-2">{{ $property->name }}</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M17 18.4302H13L8.54999 21.3902C7.88999 21.8302 7 21.3602 7 20.5602V18.4302C4 18.4302 2 16.4302 2 13.4302V7.43018C2 4.43018 4 2.43018 7 2.43018H17C20 2.43018 22 4.43018 22 7.43018V13.4302C22 16.4302 20 18.4302 17 18.4302Z"
                                                        stroke="white" stroke-width="1.5" stroke-miterlimit="10"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M12.0001 11.3599V11.1499C12.0001 10.4699 12.4201 10.1099 12.8401 9.81989C13.2501 9.53989 13.66 9.1799 13.66 8.5199C13.66 7.5999 12.9201 6.85986 12.0001 6.85986C11.0801 6.85986 10.3401 7.5999 10.3401 8.5199"
                                                        stroke="white" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M11.9955 13.75H12.0045" stroke="white" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </label>
                                            <input hidden
                                                name="properties[{{ $value['category']->id }}][{{ $loop->index }}][property-id]"
                                                type="text" class="input" value="{{ $property->id }}">
                                            <input hidden
                                                name="properties[{{ $value['category']->id }}][{{ $loop->index }}][category]"
                                                type="text" class="input" value="{{ $value['category']->id }}">
                                            <input hidden
                                                name="properties[{{ $value['category']->id }}][{{ $loop->index }}][property-name]"
                                                type="text" class="input" value="{{ $property->name }}">
                                            <input id="properties[{{ $value['category']->id }}][{{ $loop->index }}][property-value]"
                                                name="properties[{{ $value['category']->id }}][{{ $loop->index }}][property-value]"
                                                type="text" class="input"
                                            >
                                            <input hidden id="properties[{{ $value['category']->id }}][{{ $loop->index }}][property-value-id]"
                                                name="properties[{{ $value['category']->id }}][{{ $loop->index }}][property-value-id]"
                                                type="text" class="input"
                                            >
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div class="empty-property text-center mt-3 mb-3 text-xl">
                                    <span class="text-white">Свойства отсутсвуют!</span>
                                    <a class="link white"
                                        href="{{ route('admin.catalog.category.edit', ['category' => $value['category']->id]) }}"
                                        href="">Добавить</a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>


            <div
                class="columns-1 text-white mt-4 flex justify-between mb-9 divide-x pb-2 text-3xl border-b-2 border-b-white">
                <span>Картинки варианта</span>
                <div class="btn btn-add-image small-btn border-none ml-auto">
                    <span class="loader dark"></span>
                    Добавить
                </div>
            </div>

            <div class="load-images-container">
                <div class="empty-data">
                </div>
                <div class="old-data hidden">
                    @if (old('images'))
                        @foreach (old('images') as $imagesOld)
                            <div class="wrap">
                                @foreach ($imagesOld as $image)
                                    <div class="image">
                                        <input type="text" hidden name="id" value="{{ $image['id'] }}">
                                        <input type="text" hidden name="path" value="{{ $image['path'] }}">
                                        <input type="text" hidden name="size" value="{{ $image['size'] }}">
                                        <input type="text" hidden name="url-path" value="{{ $image['url-path'] }}">
                                        <input type="text" hidden name="width" value="{{ $image['width'] }}">
                                        <input type="text" hidden name="heigth" value="{{ $image['heigth'] }}">
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @else
                        @foreach ($images as $imageVariant)
                            <div class="wrap">
                                <div class="image">
                                    <input type="text" hidden name="id" value="{{ $imageVariant['id'] }}">
                                    <input type="text" hidden name="path" value="{{ $imageVariant['path'] }}">
                                    <input type="text" hidden name="size" value="{{ $imageVariant['size'] }}">
                                    <input type="text" hidden name="url-path"
                                        value="{{ $imageVariant['url-path'] }}">
                                    <input type="text" hidden name="width" value="{{ $imageVariant['width'] }}">
                                    <input type="text" hidden name="heigth" value="{{ $imageVariant['heigth'] }}">
                                </div>
                                @if (isset($imageVariant['children']))
                                    @foreach ($imageVariant['children'] as $child)
                                        <div class="image">
                                            <input type="text" hidden name="id" value="{{ $child['id'] }}">
                                            <input type="text" hidden name="path" value="{{ $child['path'] }}">
                                            <input type="text" hidden name="size" value="{{ $child['size'] }}">
                                            <input type="text" hidden name="url-path"
                                                value="{{ $child['url-path'] }}">
                                            <input type="text" hidden name="width" value="{{ $child['width'] }}">
                                            <input type="text" hidden name="heigth" value="{{ $child['heigth'] }}">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endsection
    </form>
@section('sidebar')
    <x-admin.sidebar.categories item_show="products" />
@endsection

@section('scripts')
    @vite(['resources/js/pages/updateVariantProduct.js'])
@endsection

@push('modals')
    <div class="modal-container hidden">
        <div class="modal-overlay hidden"></div>
        <div class="modal hidden" data-modal="add-image">
            <div class="modal-header mb-5 text-2xl">
                <div class="title">
                    <div class="flex items-center">
                        <span>Новая картинка</span>
                        <div class="checkbox ml-3 text-sm mt-1">
                            <input class="custom-checkbox" type="checkbox" checked id="proportions">
                            <label for="proportions">Пропорции</label>
                        </div>
                    </div>
                </div>
                <div class="close-modal">
                    ✖
                </div>
            </div>
            <div class="modal-content scrollbar">
                <div class="input-group  mb-2">
                    <label for="image-mark" class="label black">
                        Пометка
                    </label>
                    <input id="image-mark" type="text" class="input border border-theme-blue border-solid">
                </div>
                <div class="columns-2">
                    <div class="input-group  mb-2">
                        <label for="image-width" class="label black pb-1">
                            Ширина
                        </label>
                        <input id="image-width" type="text" class="input border border-theme-blue border-solid">
                    </div>
                    <div class="input-group  mb-2">
                        <label for="image-height" class="label black pb-1">
                            Высота
                        </label>
                        <input id="image-height" type="text" class="input border border-theme-blue border-solid">
                    </div>
                </div>
            </div>
            <div class="modal-footer flex justify-end">
                <div class="btn bg-green mr-2" id="addNewImage">
                    <span class="loader dark"></span>
                    Добавить
                </div>
            </div>
        </div>
    </div>
@endpush
