import AjaxSearchInput from "../components/AjaxSearchInput";
import ConvertWordsToTranscription from "../components/ConvertWordsToTranscription";

new ConvertWordsToTranscription();

class Store {
    constructor(initData) {
        this.store;

        if (initData) {
            this.store = initData;
        }
    }


    getDataByKey(key) {
        if (key) {
            return this.store[key];
        }

        return this;
    }

    setDataByKey(key, data) {
        if (key) {
            this.store[key] = data;
        }

        return this;
    }

    getKeys() {
        return Object.keys(this.store);
    }

    getStore() {
        return this.store;
    }

    getValues() {
        Object.values(this.store);
    }
}

// document.querySelector('.add-variant').addEventListener('click', )

class HandlerCategoryProperty {
    constructor() {
        this.containerElement = document.querySelector('.category-properties-container');
        this.countProperties = document.querySelector('.count_properties');
        this.store = new Store({
            countCategoryProperty: 0,
            handlerPoolBtnDelete: [],
        });

        this.addEventListener();
        this.createPropertiesByOldData();
    }

    addEventListener() {
        document.querySelector('.add-property').addEventListener('click', this.createVariable.bind(this));
    }

    createPropertiesByOldData() {
        const oldDataContainer = this.containerElement.querySelector('.old-data');

        if (!oldDataContainer) {
            return;
        }

        oldDataContainer.querySelectorAll('.old-row').forEach((row) => {
            const name = row.querySelector('input:first-child');
            const description = row.querySelector('input:last-child');

            this.createVariable(null, name.value, description.value);
        });

        oldDataContainer.remove();
    }

    createVariable(event, name = '', description = '') {
        const countCategoryProperty = ++this.store.store.countCategoryProperty;

        const html = `
            <div class="category-property flex flex-col" data-number="${countCategoryProperty}">
                <div class="input-group mb-5">
                    <label for="category-property-name[${countCategoryProperty}]" class="label flex">
                        <span>Свойство</span>
                        <span class="text-black pl-2 font-bold cursor-pointer" title="обязательное поле">*</span>
                    </label>
                    <input value="${name}" id="category-property-name[${countCategoryProperty}]" name="category-property[${countCategoryProperty}][name]" type="text" class="input">
                </div>
                <div class="btn delete-property small-btn border-none bg-red self-end">Удалить</div>
            </div>
        `;

        this.containerElement.insertAdjacentHTML('beforeend', html);

        const lastCategoryProperty = this.containerElement.querySelector('.category-property:last-child');
        const btn = lastCategoryProperty.querySelector('.delete-property');
        const handler = this.handlerRemovePropertyElement.bind(this, lastCategoryProperty, btn);



        this.store.store.handlerPoolBtnDelete.push({
            id: countCategoryProperty,
            handler: handler,
            ajax: new AjaxSearchInput(
                '/admin/catalog/properties/ajax?fields=id,name',
                `.category-property[data-number="${countCategoryProperty}"]`,
                `input[id="category-property-name[${countCategoryProperty}]"]`,
                'search[name]',
                `category-property[${countCategoryProperty}][id]`
            )
        })

        btn.addEventListener('click', handler);

        this.countProperties.textContent = countCategoryProperty;
    }

    handlerRemovePropertyElement(parent, btn) {
        const id = parent.dataset.number;

        parent.remove();

       const handler = this.store.store.handlerPoolBtnDelete.find(el => el.id == id).handler;

        btn.removeEventListener('click', handler);

        this.containerElement.querySelectorAll('.category-property').forEach((val, key) => {
            val.setAttribute('data-number', ++key);
        });

        this.containerElement.querySelectorAll('input').forEach((input, key) => {
            const val = ++key;
            input.setAttribute('id', `category-property-name[${val}]`);
            input.setAttribute('name', `category-property[${val}][name]`);
        });

        --this.store.store.countCategoryProperty;

        this.countProperties.textContent = this.store.store.countCategoryProperty;
    }
}

new HandlerCategoryProperty();
