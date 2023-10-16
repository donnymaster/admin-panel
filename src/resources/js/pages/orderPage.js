import ItcAccordion from "../components/accordion";
import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import spreadResponse from "../utils/spreadResponse";
import SearchEngineInputProductVariant from "../components/SearchEngineInputProductVariant";

new ItcAccordion('#accordion-1', {
    alwaysOpen: true
  });


document.querySelector('.change-status-order')
  .addEventListener('click', ({target}) => {
    if (!target.classList.contains('order-status')) return;

    const type = target.dataset.type;
    const orders_id = [ target.closest('.change-status-order').dataset.id ];

    fetch(
        '/admin/statistics/orders/change-status',
        {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window._token,
            },
            body: JSON.stringify({ orders_id, type })
        }
    )
    .then(spreadResponse)
        .then((response) => {
            if (checkIsErrorResponse(response)) {
                window.location.reload();
            }
        });
  });

const searchEngineInputUpdatePromocode = new SearchEngineInputProductVariant(
    '/',
    document.querySelector('.modal[data-modal="add-product"]'),
    'input[id="add-product"]',
    'variant_id',
    '.input-search-parent',
    6
);


class AdminOrderHandler {
    constructor() {
        this.handlers = [];
        this.container = document.querySelector('.products-list');
        // перерасчет суммы
        // добавления товара(вариации) с количеством и промокодом и указанием количества и вывод сколько это будет стоить
        // инкремент дикремент вариации товара
        // удаление вариации
        this.initializeHandlers();

    }

    initializeHandlers() {
        document.querySelector('#addVariantProductInOrder')
            .addEventListener('click', this.handlerAddVariant.bind(this));
    }

    handlerAddVariant({target}) {
        const promocode = document.querySelector('.modal[data-modal="add-product"] input[id="promocode"]').value;
        const count_variants = document.querySelector('.modal[data-modal="add-product"] input[id="variant-count"]').value;
        const variant_id = document.querySelector('.modal[data-modal="add-product"] input[name="variant_id"]').value;

        if (target.classList.contains('disabled')) return;

        target.classList.add('disabled');

        fetch(
            `/admin/statistics/orders/${document.querySelector('#mainForm').dataset.id}/add-variant`,
            {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window._token,
                },
                body: JSON.stringify({ promocode, count_variants, variant_id })
            }
        )
        .then(spreadResponse)
        .then((response) => {
                if (checkIsErrorResponse(response)) {
                    console.log(response.data);
                }
            })
            .finally(() => target.classList.remove('disabled'));
    }
}

new AdminOrderHandler();
