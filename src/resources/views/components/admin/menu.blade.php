<div class="admin-menu">
    @foreach ($menuLinks as $menuLink)
        <a
            @class([
                'admin-menu-item',
                'active' => $menuLink->isCurrentPage()
            ])
            href="{{ route($menuLink->route) }}">
            {{ $menuLink->name }}
        </a>
    @endforeach
</div>
