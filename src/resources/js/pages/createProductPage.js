const selectCategory = document.querySelector('.selected-category');
import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import spreadResponse from "../utils/spreadResponse";
import ConvertWordsToTranscription from "../components/ConvertWordsToTranscription";

new ConvertWordsToTranscription();

selectCategory.addEventListener('change', (event) => {
    loadProductCategoryProperties(event.target.value);
});

function initCategory() {
    const select = document.querySelector('.selected-category');

    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has('category-id')) {
        select.value = urlParams.get('category-id');
    } else {
        select.value = select.querySelector('option').value;
    }

    select.dispatchEvent(new Event('change'));
}

initCategory();


function loadProductCategoryProperties(id) {
    selectCategory.setAttribute('disabled', true);

    fetch(`/admin/catalog/categories/${id}/properties`)
        .then(spreadResponse)
        .then((response) => {
            if (checkIsErrorResponse(response)) {
                selectCategory.removeAttribute('disabled');
                updateCategory(response.data);
            }
        });
}

class BindInputCategoryProperty {
    constructor() {
        this.parentsInput = [];
    }

    addInput(input) {
        this.parentsInput.push(input);
    }

    execute() {
        this.parentsInput.forEach(input => {
            input.addEventListener('input', this.handlerInputData.bind(this))
        });
    }

    handlerInputData(event) {
        const childSelector = event.target.getAttribute('data-child');
        const child = document.querySelector(`.${childSelector}`);

        child.value = event.target.value;
    }

    destroy() {
        this.parentsInput.forEach(input => {
            input.removeEventListener('input', this.handlerInputData.bind(this));
        });
    }
}

const bindInput = new BindInputCategoryProperty();

function updateCategory(data) {
    const container = document.querySelector('.container-category-property');
    const properties = data.properties;

    let parentsNames = `<div class="category_item">${data.name}</div>`;

    window.selectedCategory = data;

    const getParentName = (category) => {
        if (category.parent_id) {
            const parent = categories.find(c => c.id == category.parent_id);
            parentsNames = '<div class="category_arrow"> > </div>' + parentsNames;
            parentsNames = `<div class="category_item">${parent.name}</div>` + parentsNames;

            if (parent.parent_id) {
                getParentName(parent);
            }
        }
    }

    getParentName(data);

    updateCategoryParentNested(parentsNames);

    while (container.firstChild) {
        container.removeChild(container.lastChild);
    }

    if (!properties.length) {
        container.insertAdjacentHTML(
            'afterbegin',
            `
                <div class="empry-data-category-properties text-white text-1xl text-center mt-4">
                    Уникальные свойства отсутствуют, вам нужно <a href="/admin/catalog/categories/${data.id}" class="link white">добавить</a> свойства чтобы они тут отобразились!
                </div>
            `
        );
        return;
    }

    let stringHtmlParents = '';

    console.log(data);

    data.properties.forEach((property, index) => {
        const i = ++index;

        stringHtmlParents += `
            <div class="category-property-item mb-8">
                <div class="input-group">
                    <input hidden name="property[${i}][id]" value="${property.id}">
                    <label for="category-property[${i}]" class="label flex mb-5 items-center" title="${property.description}">
                        <span class="mr-3">${property.name}</span>
                        <svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M17 18.4302H13L8.54999 21.3902C7.88999 21.8302 7 21.3602 7 20.5602V18.4302C4 18.4302 2 16.4302 2 13.4302V7.43018C2 4.43018 4 2.43018 7 2.43018H17C20 2.43018 22 4.43018 22 7.43018V13.4302C22 16.4302 20 18.4302 17 18.4302Z" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12.0001 11.3599V11.1499C12.0001 10.4699 12.4201 10.1099 12.8401 9.81989C13.2501 9.53989 13.66 9.1799 13.66 8.5199C13.66 7.5999 12.9201 6.85986 12.0001 6.85986C11.0801 6.85986 10.3401 7.5999 10.3401 8.5199" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M11.9955 13.75H12.0045" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                    </label>
                    <input id="category-property[${i}]" name="property[${i}][value]" type="text" class="input mt-3 parent-bind-input" data-child="child-bind-input-${property.id}">
                </div>
            </div>
            `;
    });

    container.insertAdjacentHTML('afterbegin', stringHtmlParents);

    bindInput.destroy();

    container.querySelectorAll('.parent-bind-input').forEach(input => bindInput.addInput(input));

    console.log(bindInput);
}

function updateCategoryParentNested(parentsHtml) {
    const container = document.querySelector('.category_list');

    while (container.firstChild) {
        container.removeChild(container.lastChild);
    }

    container.insertAdjacentHTML('afterbegin', parentsHtml);
}


class ProductUniquePropertyHandler {
    constructor() {
        this.countProperty = 0;
        this.container = document.querySelector('.container-product-unique-property');
        this.countTitle = document.querySelector('.product-unique-property-count');
    }

    create() {
        const number = ++this.countProperty;

        const stringHtml = `
        <div class="product-unique-property-item flex flex-col items-end">
            <div class="flex w-full">
                <div class="input-group mr-5 w-1/2">
                    <label for="product-unique-property[${number}][name]" class="label flex">
                        <span>Название</span>
                        <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                    </label>
                    <input id="product-unique-property[${number}][name]" name="product-unique-property[${number}][name]" type="text" class="input">
                </div>
                <div class="input-group w-1/2">
                    <label for="product-unique-property[${number}][value]" class="label">
                        Значение
                        <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                    </label>
                    <input id="product-unique-property[${number}][value]" name="product-unique-property[${number}][value]" type="text" class="input">
                </div>
            </div>
            <div class="btn delete-property small-btn border-none bg-red self-end mt-4">Удалить</div>
        </div>
        `;

        this.container.insertAdjacentHTML('beforeend', stringHtml);

        const btnDelete = this.container.querySelector('.product-unique-property-item:last-child').querySelector('.delete-property');

        btnDelete.addEventListener('click', this.delete.bind(this));

        this.updateCountProperty();
    }

    updateCountProperty() {
        this.countTitle.textContent = this.countProperty;
    }

    delete(event) {
        const btn = event.target;
        const parent = btn.closest('.product-unique-property-item');

        btn.removeEventListener('click', this.delete);

        parent.remove();

        --this.countProperty;

        this.updateCountProperty();

        this.container.querySelectorAll('[for^=product-unique-property-name-]')
            .forEach((label, index) => {
                const i = ++index;
                label.setAttribute('for', `product-unique-property-name-${i}`);
            });

        this.container.querySelectorAll('input[id^=product-unique-property-name-]')
        .forEach((input, index) => {
            const i = ++index;
            input.setAttribute('id', `product-unique-property-name-${i}`);
            input.setAttribute('name', `product-unique-property-name-${i}`);
        });

        this.container.querySelectorAll('[for^=product-unique-property-value-]')
        .forEach((label, index) => {
            const i = ++index;
            label.setAttribute('for', `product-unique-property-value-${i}`);
        });

        this.container.querySelectorAll('input[id^=product-unique-property-value-]')
        .forEach((input, index) => {
            const i = ++index;
            input.setAttribute('id', `product-unique-property-value-${i}`);
            input.setAttribute('name', `product-unique-property-value-${i}`);
        });
    }
}

const ProductUniqueProperty = new ProductUniquePropertyHandler();


document.querySelector('.add-product-unique-property')
    .addEventListener('click', () => {
        ProductUniqueProperty.create();
    });


document.querySelector('.visible-product')
    .addEventListener('click', (event) => {
        const btn = event.target;
        const input = btn.querySelector('input');

        if (btn.classList.contains('visible')) {
            input.value = 0;
        } else {
            input.value = 1;
        }

        btn.classList.toggle('visible');
        btn.classList.toggle('not-visible');

});
