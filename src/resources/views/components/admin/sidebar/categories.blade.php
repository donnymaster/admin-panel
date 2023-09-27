<div class="sidebar static-sidebar">
    <a
        href="{{ route('admin.catalog.categories.page.list') }}"
        @class([
            'static-sidebar-item',
            'active' => $attributes->get('item_show') === 'categories',
        ])
    >
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M5 10H7C9 10 10 9 10 7V5C10 3 9 2 7 2H5C3 2 2 3 2 5V7C2 9 3 10 5 10Z" stroke="black"
                    stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M17 10H19C21 10 22 9 22 7V5C22 3 21 2 19 2H17C15 2 14 3 14 5V7C14 9 15 10 17 10Z"
                    stroke="black" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M17 22H19C21 22 22 21 22 19V17C22 15 21 14 19 14H17C15 14 14 15 14 17V19C14 21 15 22 17 22Z"
                    stroke="black" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M5 22H7C9 22 10 21 10 19V17C10 15 9 14 7 14H5C3 14 2 15 2 17V19C2 21 3 22 5 22Z" stroke="black"
                    stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        Категории
    </a>
    <a
        href="{{ route('admin.products') }}"
        @class([
            'static-sidebar-item',
            'active' => $attributes->get('item_show') === 'products',
        ])
    >
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M8.5 14.25C8.5 16.17 10.08 17.75 12 17.75C13.92 17.75 15.5 16.17 15.5 14.25" stroke="black"
                    stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8.80994 2L5.18994 5.63" stroke="black" stroke-width="1.5" stroke-miterlimit="10"
                    stroke-linecap="round" stroke-linejoin="round" />
                <path d="M15.1899 2L18.8099 5.63" stroke="black" stroke-width="1.5" stroke-miterlimit="10"
                    stroke-linecap="round" stroke-linejoin="round" />
                <path
                    d="M2 7.8501C2 6.0001 2.99 5.8501 4.22 5.8501H19.78C21.01 5.8501 22 6.0001 22 7.8501C22 10.0001 21.01 9.8501 19.78 9.8501H4.22C2.99 9.8501 2 10.0001 2 7.8501Z"
                    stroke="black" stroke-width="1.5" />
                <path d="M3.5 10L4.91 18.64C5.23 20.58 6 22 8.86 22H14.89C18 22 18.46 20.64 18.82 18.76L20.5 10"
                    stroke="black" stroke-width="1.5" stroke-linecap="round" />
            </svg>
        </div>
        <div class="badge">
            Товары
        </div>
    </a>
    <a
        href="{{ route('admin.orders') }}"
        @class([
            'static-sidebar-item',
            'active' => $attributes->get('item_show') === 'code',
        ])
    >
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                <path
                    d="M9.01196 2H15.012C20.012 2 22.012 4 22.012 9V15C22.012 20 20.012 22 15.012 22H9.01196C4.01196 22 2.01196 20 2.01196 15V9C2.01196 4 4.01196 2 9.01196 2Z"
                    stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M8.58203 15.27L15.122 8.72998" stroke="black" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path
                    d="M8.99197 10.3699C9.67128 10.3699 10.222 9.81923 10.222 9.13992C10.222 8.46061 9.67128 7.90991 8.99197 7.90991C8.31266 7.90991 7.76196 8.46061 7.76196 9.13992C7.76196 9.81923 8.31266 10.3699 8.99197 10.3699Z"
                    stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path
                    d="M15.532 16.0899C16.2113 16.0899 16.762 15.5392 16.762 14.8599C16.762 14.1806 16.2113 13.6299 15.532 13.6299C14.8527 13.6299 14.302 14.1806 14.302 14.8599C14.302 15.5392 14.8527 16.0899 15.532 16.0899Z"
                    stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        Промокоды
    </a>
</div>
