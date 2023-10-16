import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import spreadResponse from "../utils/spreadResponse";

export default class SearchEngineInputProductVariant {
    constructor(
        url,
        parent,
        inputSearchSelector,
        inputNewName,
        parentlementSelector,
        limit = 10
    ) {
        this.url = url;
        this.inputSearch = parent.querySelector(inputSearchSelector);
        this.inputNewName = inputNewName;
        this.parent = parent.querySelector(parentlementSelector);
        this.limit = limit;
        this.init();
    }

    init() {
        this.inputSearch.addEventListener('input', this.debounce(this.search.bind(this), 500));
        this.parent.insertAdjacentHTML('beforeend', `
            <input hidden name="${this.inputNewName}"/>
        `);

        this.parent.insertAdjacentHTML("afterbegin", `
            <div class="input-search-results"></div>
        `);

        this.resultContainer = this.parent.querySelector('.input-search-results');

        document.querySelector('body')
            .addEventListener('click', ({ target }) => {
                if (!!target.closest('.input-search-parent')) {
                    return;
                }

                this.resultContainer.style = 'display:none';
            });

        this.resultContainer.addEventListener('click', this.handlerClickToResultContainer.bind(this));
    }

    search({ target }) {

        fetch(
            `/admin/catalog/product-variants?limit=${this.limit}&search=${target.value}`,
        )
            .then(spreadResponse)
            .then((response) => {
                if (checkIsErrorResponse(response)) {
                    this.renderProducts(response.data);
                    this.resultContainer.style = 'display:flex';
                }
            });

        if (target.value === '') {
            this.parent.querySelector(`input[name="${this.inputNewName}"]`).value = '';
        }
    }

    handlerClickToResultContainer({ target }) {
        if (!target.classList.contains('search-element')) {
            return;
        }

        this.parent.querySelector(`input[name="${this.inputNewName}"]`).value = target.dataset.id;
        this.inputSearch.value = target.textContent;
        this.resultContainer.style = 'display:none';
    }

    renderProducts(products = []) {
        while (this.resultContainer.firstChild) {
            this.resultContainer.removeChild(this.resultContainer.lastChild);
        }

        if (products.length === 0) {
            this.resultContainer.insertAdjacentHTML('afterbegin', `
                <div class="empty-data">Ничего не найдено!</div>
            `);
        }

        products.forEach((product) => {
            const productElement = document.createElement('div');
            productElement.classList.add('search-element');
            productElement.setAttribute('data-id', product.id);
            productElement.textContent = product.title;

            this.resultContainer.append(productElement);
        });
    }

    debounce(func, timeout = 300) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => { func.apply(this, args); }, timeout);
        };
    }

    setValueSearchInput(value = '') {
        this.inputSearch.value = value;
    }

    setValueInputHidden(value = '') {
        this.parent.querySelector(`input[name="${this.inputNewName}"]`).value = value;
    }

}
