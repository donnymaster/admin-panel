import Sortable from 'sortablejs';

class TreeList {
    constructor() {
        this.container = document.querySelector('.drop-down-list-container');
        this.data = {};

        this.run();
    }

    run() {
        fetch(
            '/admin/catalog/categories/list'
        )
            .then(response => response.json())
            .then((response) => {
                this._render(response);
            });
    }

    _render(data) {
        // data.sort((f, l) => {
        //     if (f.parent_id > l.parent_id) return 1;
        //     if (f.parent_id < l.parent_id) return -1;
        //     return 0;
        // })
        //     .forEach((category) => {
        //         this._createCategory(category);
        //     });

            const nestedSortables = [].slice.call(document.querySelectorAll('.nested-sortable'));

            for (var i = 0; i < nestedSortables.length; i++) {
                new Sortable(nestedSortables[i], {
                    group: 'nested',
                    animation: 150,
                    fallbackOnBody: true,
                    swapThreshold: 0.65,
                });
            }
    }

    _createCategory(category) {
        this.data[category.id] = category;

        const listGroup = document.createElement('div');
        listGroup.classList.add('list-group', 'nested-sortable', 'category');
        listGroup.setAttribute('data-id', category.id);

        const nested = document.createElement('div');
        nested.classList.add('list-group-item', `nested-${category.id}`);

        listGroup.append(nested);

        const header = document.createElement('div');
        header.classList.add('header');

        const titleCategory = document.createElement('div');
        titleCategory.classList.add('title-category');
        titleCategory.textContent = category.name;

        const productsCategory = document.createElement('div');
        productsCategory.classList.add('count-products');
        productsCategory.addEventListener('click', this._handleClickLoadProducts.bind(this, category.id));

        const paginationProductsContainer = document.createElement('div');
        paginationProductsContainer.classList.add('products-pagination');

        const paginationProductsLeft = document.createElement('div');
        paginationProductsLeft.textContent = '<';
        paginationProductsLeft.classList.add('left', 'disabled');
        paginationProductsLeft.addEventListener('click', this._handleClickLeftPagination.bind(this, category.id));

        const paginationProductsRight = document.createElement('div');
        paginationProductsRight.textContent = '>';
        paginationProductsRight.classList.add('right', 'disabled');

        paginationProductsContainer.append(paginationProductsLeft);
        paginationProductsContainer.append(paginationProductsRight);

        header.append(titleCategory);
        header.append(productsCategory);
        header.append(paginationProductsContainer);

        nested.append(header);

        if (category.parent_id) {
            document.querySelector(`.nested-${category.parent_id}`).append(listGroup);
        } else {
        this.container.append(listGroup);
        }
    }

    _handleClickLeftPagination(categoryId, event) {
        console.log({event, categoryId});
    }

    _handleClickLoadProducts(categoryId, event) {
        const btnElement = event.target;

        if (btnElement.classList.contains('load')) {
            return;
        }

        this._changeStateLoadProducts(btnElement);

        // загрузить продукты по категории
        fetch(
            `/admin/catalog/categories/${categoryId}/products`
        )
        .then(response => response.json())
        .then((response) => {
            this._changeStateLoadProducts(btnElement);
            // this._renderProducts(response, btnElement);
        });
        // вывести количество продуктов всего
        // обновить кнопки для пагинации
        // вывести продукты в категории
    }

    _changeStateLoadProducts(el) {
        el.textContent = '';
        el.classList.remove('is-load');
        el.classList.toggle('load');
    }

    _renderProducts(products, btnElement) {
        console.log(btnElement);
        btnElement.classList.add('is-load');
        btnElement.textContent = products.total;
        // this._updateCountProducts();
        // this._updatePaginationElements();
        console.log(products);

        const parent = btnElement.closest('.list-group.nested-sortable.category');

        // clear old products
        parent.querySelectorAll('.product').forEach(product => product.remove());

        products.data.forEach((product) => {
            const productElement = document.createElement('div');

            productElement.classList.add('list-group-item', 'product');
            productElement.textContent = product.name;

            parent.append(productElement);
        });
    }
}

new TreeList();
