import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import spreadResponse from "../utils/spreadResponse";
import debounce from "./debounce";


export default class AjaxSearchInput {
    constructor(
        url,
        parentSelector,
        searchSelector,
        urlSearchParam,
        hiddenInpuName = ''
    ) {
        this.handlers = [];
        this.url = url;
        this.urlSearchParam = urlSearchParam;
        this.parentElement = document.querySelector(parentSelector);
        this.searchElement = this.parentElement.querySelector(searchSelector);
        this.container = null;

        if (hiddenInpuName) {
            this.hiddenInpuName = hiddenInpuName;
            this._createHiddenInput();
        }

        this.EVENT_SELECT_ITEM = 'selected.item';
        this.LOAD_DATA = 'data.load';

        this.init();
    }

    init() {
        const handler = debounce(this._handlerSearch.bind(this), 500);

        this.searchElement.addEventListener('input', handler);

        this._createContainer();
    }

    addEventHandler(type, callback) {
        if (typeof callback !== 'function') return this;

        if (!this.handlers[type]) {
            this.handlers[type] = [ callback ];
        } else {
            this.handlers[type].push(callback);
        }

        return this;
    }

    _handlerSearch({target: { value }}) {
        fetch(
            `${this.url}&${this.urlSearchParam}=${value}`,
            {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': window._token,
                },
            }
        )
        .then(spreadResponse)
        .then((response) => {
            if (!checkIsErrorResponse(response)) return;

            this._generateEvent(this.LOAD_DATA, response.data);
            this._renderData(response.data);
        });
    }

    _createHiddenInput() {
        const el = document.createElement('input');
        el.type = 'text';
        el.hidden = true;
        el.name = this.hiddenInpuName;

        this.parentElement.append(el);
    }

    _generateEvent(type, data) {
        if (!this.handlers[type]) return;

        this.handlers[type].forEach(callback => callback(data));
    }

    _renderData(data) {
        console.log(data);
    }

    _createContainer() {
        const el = document.createElement('div');
        el.classList.add('hidden', 'container-found-elements');

        this.parentElement.append(el);
    }
}
