export default class PageList {
    constructor() {
        this.QUERY_SEARCH = 'query=';
        this.PAGE_LIST_URL = '/admin/pages-list';
        this.pageListContainer = document.querySelector('.page-list-container');
        this.loader = document.querySelector('#page-list .loader');

        this.searchInputContainerElement = document.querySelector('.page-list-search');
        this.searchInputElement = document.querySelector('.page-list-search input');

        this.paginationContainerElement = document.querySelector('.page-list-pagination');
        this.paginationLeftElement = document.querySelector('.page-list-pagination .left');
        this.paginationRightElement = document.querySelector('.page-list-pagination .right');

        if (this.pageListContainer) {
            this.loadPages();
            this._eventSearchInput();
            this._eventClickArrowPagination();
        }
    }

    loadPages() {
        this._fetchPages(this.PAGE_LIST_URL);
    }

    _fetchPages(url) {
        fetch(url)
            .then((response) => response.json())
            .then(response => this.render(response));
    }

    render(response) {
        this.loader.classList.add('hidden');
        this.searchInputContainerElement.classList.remove('hidden');
        this.paginationContainerElement.classList.remove('hidden');

        this._clearChildElementsByElement(this.pageListContainer);

        if (!response.data.length) {
            this._showEmptyData();
        }

        response.data.forEach(page => {
            const pageElement = this._createPageElement(page);
            this.pageListContainer.append(pageElement);
        });

        // обновление стрелок пагинации
        this._updateArrowPagination(response);
    }

    clickArrowPagination(element) {
        const path = element.getAttribute('data-url');

        if (!path) {
            return;
        }

        this._fetchPages(path);
    }

    _createPageElement(page) {
        const pageElement = document.createElement('a');

        pageElement.setAttribute('href', `/admin/pages/${page.id}`);
        pageElement.classList.add('page-list-item', 'link');
        pageElement.textContent = page.name;

        return pageElement;
    }

    _showEmptyData() {
        this._clearChildElementsByElement(this.pageListContainer);

        const message = 'Страниц не найдено!';

        const messageElement = document.createElement('div');

        messageElement.classList.add('page-list-empty');
        messageElement.textContent = message;

        this.pageListContainer.append(messageElement);
    }

    _eventSearchInput() {
        this.searchInputElement.addEventListener('input', (event) => {
            if (!event.target.value) {
                window.history.replaceState(null, '', window.location.pathname);
            } else {
                window.history.replaceState(null, null, `?${this.QUERY_SEARCH}` + event.target.value);
            }

            // запускать поиск с параметром query
            this._fetchPages(`${this.PAGE_LIST_URL}?${this.QUERY_SEARCH}${event.target.value}`);
        });
    }

    _updateArrowPagination(response) {
        const prePageUrl = response.prev_page_url;
        const nextPageUrl = response.next_page_url;

        if (prePageUrl) {
            this.paginationLeftElement.setAttribute('data-url', prePageUrl);
            this.paginationLeftElement.classList.remove('disable');
        } else {
            this.paginationLeftElement.classList.add('disable');
            this.paginationLeftElement.setAttribute('data-url', '');
        }

        if (nextPageUrl) {
            this.paginationRightElement.setAttribute('data-url', nextPageUrl);
            this.paginationRightElement.classList.remove('disable');
        } else {
            this.paginationRightElement.classList.add('disable');
            this.paginationRightElement.setAttribute('data-url', '');
        }
    }

    _clearChildElementsByElement(el) {
        while (el.firstChild) {
            el.removeChild(el.lastChild);
        }
    }

    _eventClickArrowPagination() {
        this.paginationLeftElement.addEventListener('click', (event) => {
            this.clickArrowPagination(event.target.closest('.left'));
        });

        this.paginationRightElement.addEventListener('click', (event) => {
            this.clickArrowPagination(event.target.closest('.right'));
        });
    }
}
