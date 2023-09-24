import Sortable from 'sortablejs';

class TreeList {
    constructor() {
        this.dragon = null;

        this.containerElement = document.querySelector('.drop-down-list-container');

        this.loadData();
        // this.render();
    }

    loadData() {
        // fetch
        fetch('/admin/catalog/categories/list')
            .then((response) => response.json())
            .then((response) => {
                console.log(response);
                this.categories = response;
                this.render();
            });
    }

    render() {
        this.categories.forEach(category => {
            this.createCategory(category);
        });

        this.sortable = Sortable.create(this.containerElement, {
            sort: true,
            dataIdAttr: 'data-position'
        });
        console.log(this.sortable);
    }

    createCategory(category) {
        const categoryElement = document.createElement("div");
        categoryElement.setAttribute('data-position', category.position);
        categoryElement.setAttribute('data-id', category.id);
        categoryElement.setAttribute('data-slug', category.slug);
        categoryElement.classList.add('category');

        const categoryTitleElement = document.createElement("div");
        categoryTitleElement.textContent = category.name;
        categoryTitleElement.classList.add('category-title');

        categoryElement.append(categoryTitleElement);

        // if (category.parent_id) {
        //     document.querySelector(`div[data-id="${category.parent_id}"]`).append(categoryElement);
        // } else {
            this.containerElement.append(categoryElement);
        // }
    }

    handleClickCategory(event) {

        if (event.target.classList.contains('category')) {
            console.log(event.target);
        }
    }
}

new TreeList();
