@inject('service', 'App\Services\AdminPanel\ApplicationService')

@inject('menuService', 'App\Services\AdminPanel\MenuService')

@inject('orderService', 'App\Services\AdminPanel\OrderService')

<div class="sidebar static-sidebar">

    @if ($menuService->checkVisibleByPageName('admin.board'))
        <a href="{{ route('admin.board') }}" @class([
            'static-sidebar-item',
            'active' => $attributes->get('item_show') === 'board',
        ])>
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M7 13H12" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7 17H16" stroke="white" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path
                        d="M19 2C17.34 2 16 3.34 16 5C16 6.66 17.34 8 19 8C20.66 8 22 6.66 22 5C22 4.64 21.94 4.3 21.82 3.99"
                        stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M2 14.97V15C2 20 4 22 9 22H15C20 22 22 20 22 15V10" stroke="white" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M14 2H9C4 2 2 4 2 9V11" stroke="white" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
            Доска
        </a>
    @endif

    @if ($menuService->checkVisibleByPageName('admin.applications'))
        <a href="{{ route('admin.applications') }}" @class([
            'static-sidebar-item',
            'active' => $attributes->get('item_show') === 'applications',
        ])>
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path
                        d="M9.39 6.01C9.57 6.26 9.7 6.49 9.79 6.71C9.88 6.92 9.93 7.13 9.93 7.32C9.93 7.56 9.86 7.8 9.72 8.03C9.59 8.26 9.4 8.5 9.16 8.74L8.4 9.53C8.29 9.64 8.24 9.77 8.24 9.93C8.24 10.01 8.25 10.08 8.27 10.16C8.3 10.24 8.33 10.3 8.35 10.36C8.53 10.69 8.84 11.12 9.28 11.64C9.73 12.16 10.21 12.69 10.73 13.22C11.27 13.75 11.79 14.24 12.32 14.69C12.84 15.13 13.27 15.43 13.61 15.61C13.66 15.63 13.72 15.66 13.79 15.69C13.87 15.72 13.95 15.73 14.04 15.73C14.21 15.73 14.34 15.67 14.45 15.56L15.21 14.81C15.46 14.56 15.7 14.37 15.93 14.25C16.16 14.11 16.39 14.04 16.64 14.04C16.83 14.04 17.03 14.08 17.25 14.17C17.47 14.26 17.7 14.39 17.95 14.56L21.26 16.91C21.52 17.09 21.7 17.3 21.81 17.55C21.91 17.8 21.97 18.05 21.97 18.33C21.97 18.69 21.89 19.06 21.72 19.42C21.55 19.78 21.33 20.12 21.04 20.44C20.55 20.98 20.01 21.37 19.4 21.62C18.8 21.87 18.15 22 17.45 22C16.43 22 15.34 21.76 14.19 21.27C13.04 20.78 11.89 20.12 10.75 19.29C9.6 18.45 8.51 17.52 7.47 16.49C6.44 15.45 5.51 14.36 4.68 13.22C3.86 12.08 3.2 10.94 2.72 9.81C2.24 8.67 2 7.58 2 6.54C2 5.86 2.12 5.21 2.36 4.61C2.6 4 2.98 3.44 3.51 2.94C4.15 2.31 4.85 2 5.59 2C5.87 2 6.15 2.06 6.4 2.18C6.66 2.3 6.89 2.48 7.07 2.74"
                        stroke="#9900FF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
            <div class="badge">
                Заявки
                <div class="value" id="applicationNotProcessedCountSideBar">
                    {{ $service->getNumberUnprocessedApplication() }}
                </div>
            </div>
        </a>
    @endif

    @if ($menuService->checkVisibleByPageName('admin.orders'))
        <a href="{{ route('admin.orders') }}" @class([
            'static-sidebar-item',
            'active' => $attributes->get('item_show') === 'orders',
        ])>
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path
                        d="M4.75 13.97C4.61 15.6 5.9 17 7.54 17H18.19C19.63 17 20.89 15.82 21 14.39L21.54 6.89001C21.66 5.23001 20.4 3.88 18.73 3.88H5.82001"
                        stroke="#9900FF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M2 2H3.74001C4.82001 2 5.67 2.93 5.58 4L5.08 10.05" stroke="#9900FF" stroke-width="1.5"
                        stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M16.25 22C16.9404 22 17.5 21.4404 17.5 20.75C17.5 20.0596 16.9404 19.5 16.25 19.5C15.5596 19.5 15 20.0596 15 20.75C15 21.4404 15.5596 22 16.25 22Z"
                        stroke="#9900FF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path
                        d="M8.25 22C8.94036 22 9.5 21.4404 9.5 20.75C9.5 20.0596 8.94036 19.5 8.25 19.5C7.55964 19.5 7 20.0596 7 20.75C7 21.4404 7.55964 22 8.25 22Z"
                        stroke="#9900FF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M9 8H21" stroke="#9900FF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
            <div class="badge">
                Заказы
                <div class="value" id="applicationNotProcessedCountSideBar">
                    {{ $orderService->getCountNewOrders() }}
                </div>
            </div>
        </a>
    @endif

    @if ($menuService->checkVisibleByPageName('admin.reviews'))
        <a href="{{ route('admin.reviews') }}" @class([
            'static-sidebar-item',
            'active' => $attributes->get('item_show') === 'reviews',
        ])>
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path
                        d="M2.30677 0.0671787C2.16611 0.0999966 1.87542 0.217197 1.65037 0.325024C1.0643 0.615685 0.600135 1.08918 0.314133 1.68925C0.196919 1.93303 0.0797055 2.24244 0.0515741 2.3784C0.0187542 2.54717 0 3.9114 0 6.54141C0 10.2591 0.00468856 10.47 0.0890826 10.7794C0.365707 11.7639 1.11119 12.5562 2.07703 12.8844L2.32084 12.9688L2.34428 13.972C2.36772 14.9424 2.37241 14.9799 2.48025 15.1253C2.59746 15.2847 2.87409 15.4206 3.07569 15.4206C3.32419 15.4206 3.53048 15.2519 4.59479 14.183L5.6966 13.0766H6.5968H7.497L7.51107 16.1098C7.52513 19.143 7.52513 19.1476 7.63766 19.4758C7.81114 20.0009 8.04556 20.3806 8.43471 20.765C8.84731 21.1729 9.28334 21.426 9.82722 21.562C10.1742 21.6511 10.3617 21.6558 14.2251 21.6558H18.2619L19.3637 22.7621C19.9686 23.3669 20.5218 23.8967 20.5921 23.9342C20.775 24.0326 21.1407 24.0185 21.3236 23.906C21.6377 23.7138 21.6611 23.6201 21.6611 22.5418V21.5808L21.98 21.4776C22.3785 21.351 22.9599 20.9713 23.2177 20.6713C23.499 20.3478 23.7569 19.9071 23.8788 19.5461C23.982 19.2414 23.982 19.232 23.996 15.2378C24.0054 11.3607 24.0054 11.2201 23.9116 10.8591C23.7804 10.3341 23.5412 9.93089 23.0958 9.48552C22.7911 9.18079 22.6364 9.06828 22.3175 8.91357C21.6377 8.5901 21.5111 8.57603 18.848 8.57603H16.5037V5.69287C16.5037 2.43466 16.499 2.3784 16.1661 1.68456C15.913 1.15012 15.341 0.57349 14.8158 0.315647C14.1407 -0.0172062 14.4783 -0.0031414 8.20498 0.00154686C3.76491 0.00623322 2.50369 0.0156097 2.30677 0.0671787ZM13.9813 1.53455C14.3564 1.68456 14.6846 1.99866 14.8721 2.3784L15.0268 2.6925L15.0409 5.63192L15.055 8.57135L12.5325 8.58541C10.2539 8.59947 9.98663 8.61354 9.7522 8.68855C8.49098 9.1011 7.69392 10.0668 7.52513 11.3748L7.49231 11.6233H6.34362C5.59814 11.6233 5.1621 11.642 5.09646 11.6749C5.0402 11.703 4.72607 11.989 4.40256 12.3124L3.8118 12.8984L3.78835 12.5046C3.76491 12.0827 3.67114 11.8483 3.46484 11.7264C3.40858 11.6889 3.18353 11.6327 2.96317 11.5952C2.47556 11.5155 2.19893 11.3889 1.92231 11.1076C1.65975 10.8451 1.50503 10.5356 1.44876 10.1559C1.38781 9.73868 1.39719 3.23632 1.45814 2.85658C1.51909 2.46279 1.65975 2.19088 1.927 1.92366C2.18018 1.66581 2.47087 1.51579 2.81782 1.45485C2.96317 1.43141 5.34964 1.41735 8.39252 1.42203L13.714 1.42672L13.9813 1.53455ZM21.6236 10.2075C22.0034 10.395 22.3175 10.7232 22.4676 11.0982L22.5754 11.3654L22.5895 14.8721C22.5988 16.9442 22.5848 18.5101 22.5566 18.7023C22.4394 19.5508 21.8768 20.1134 21.0469 20.2025C20.4421 20.2681 20.2077 20.54 20.2077 21.1823V21.5386L19.5841 20.915C19.1481 20.4791 18.9136 20.2822 18.8011 20.2493C18.698 20.2212 17.1039 20.2025 14.4783 20.2025C10.3758 20.2025 10.3148 20.2025 10.057 20.104C9.57872 19.9259 9.17551 19.5133 9.03954 19.0633C8.99265 18.9132 8.97859 17.9991 8.97859 15.0925V11.3186L9.12393 11.0138C9.35836 10.5216 9.78971 10.1794 10.2867 10.0762C10.3898 10.0575 12.917 10.0434 15.8942 10.0434L21.3095 10.0528L21.6236 10.2075Z"
                        fill="#9900FF" />
                    <path
                        d="M17.9337 12.8234C17.8587 12.8609 17.1507 13.536 16.3631 14.3189L14.933 15.7488L14.347 15.1581C13.7703 14.5768 13.5077 14.3892 13.2686 14.3892C13.0717 14.3892 12.7622 14.5627 12.6591 14.7268C12.5466 14.9096 12.5325 15.2706 12.631 15.4581C12.6685 15.5284 13.128 16.0113 13.6531 16.527C14.4595 17.3287 14.633 17.4787 14.7783 17.5021C15.1722 17.5724 15.1769 17.5678 17.1226 15.6222C19.073 13.6626 19.0449 13.7001 18.9699 13.2922C18.8855 12.8562 18.3463 12.6125 17.9337 12.8234Z"
                        fill="#9900FF" />
                </svg>
            </div>
            Отзывы
        </a>
    @endif
    <a href="{{ route('admin.articles') }}" @class([
        'static-sidebar-item',
        'active' => $attributes->get('item_show') === 'articles',
    ])>
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M14.0015 4.5H21.0015" stroke="#9900FF" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M14.0015 9.5H21.0015" stroke="#9900FF" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M3.00146 14.5H21.0015" stroke="#9900FF" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M3.00146 19.5H21.0015" stroke="#9900FF" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path
                    d="M9.50146 8.43V5.57C9.50146 4.45 9.05146 4 7.92146 4H5.07147C3.95147 4 3.50146 4.45 3.50146 5.57V8.42C3.50146 9.55 3.95147 10 5.07147 10H7.92146C9.05146 10 9.50146 9.55 9.50146 8.43Z"
                    stroke="#9900FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        Статьи
    </a>
</div>
