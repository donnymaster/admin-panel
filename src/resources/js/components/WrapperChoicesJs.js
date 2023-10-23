import Choices from "choices.js/public/assets/scripts/choices";
import spreadResponse from "../utils/spreadResponse";
import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import debounce from "./debounce";

export default class WrapperChoicesJs {
    constructor(
        url,
        element,
        searchParam = null,
    ) {
        this.url = url;
        this.searchParam = searchParam;

        this.choices = new Choices(
            element,
            {
                loadingText: 'Загрузка...',
                noResultsText: 'Результатов не найдено',
                itemSelectText: 'Нажмите, чтобы выбрать',
            }
        );

        this.choices.loadFirstData = this.loadFirstData;

        element.addEventListener('search', debounce(this.search.bind(this), 500));
    }

    search(event) {
        const url = this.searchParam ? `${this.url}${this.searchParam}${event.detail.value}` : this.url;

        fetch(
            url,
            {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': window._token,
                }
            }
        )
        .then(spreadResponse)
        .then(response => {
            if (!checkIsErrorResponse(response)) return;

            const data = [];

            response.data.forEach(item => data.push({value: item.id, label: item.name}));

            this.choices.setValue(data);
        })
    }

    destroy() {
        this.choices.destroy();
    }
}
