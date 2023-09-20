


export default class ModalHandler {
    constructor() {
        this.BTN_NAME_CLASS = '.modal-btn';
        this.MODAL_ATTRIBUTE_NAME = 'data-modal';
        this.MODAL_NAME_CLASS = '.modal';
        this.MODAL_OVERLAY_CLASS = '.modal-overlay';
        this.MODAL_CONTAINER_CLASS = '.modal-container';

        this._CLASS_HIDDEN = 'hidden';
        this.modalPair = [];

        this.btns = document.querySelectorAll(this.BTN_NAME_CLASS);
        this.modals = document.querySelectorAll(this.MODAL_NAME_CLASS);
        this.modalOverlay = document.querySelector(this.MODAL_OVERLAY_CLASS);
        this.modalContainer = document.querySelector(this.MODAL_CONTAINER_CLASS);

        if (!this.btns.length) {
            return;
        }

        this.search();
        this.addEventButtons();
        this.addEventCloseModals();
    }

    // сборка кнопок и форм на странице

    addEventButtons() {
        this.modalPair.forEach((pair) => {
            const btn = pair[0];
            const modal = pair[1];

            btn.addEventListener('click', () => {
                this.showModal(modal);
            });
        });
    }

    // обработка события закрытия модального окна и нажатия на оверлей и закрытия модального окна
    addEventCloseModals() {
        // получим все кнопки, закрывающие модальные окна
        const modalCloseButtons = document.querySelectorAll('.modal .modal-header .close-modal');

        console.log(modalCloseButtons);
        // вешамем обработчики
        modalCloseButtons.forEach((closeButton) => {
            closeButton.addEventListener('click', () => {
                const modal = closeButton.closest('.modal');
                this.closeModal(modal);
            });
        });

        // вешаем обработчик на оврелей
        this.modalOverlay.addEventListener('click', () => {
            const modal = document.querySelector(`.modal:not(.${this._CLASS_HIDDEN})`);
            this.closeModal(modal);
        });
    }

    closeModal(modal) {
        document.querySelector('body').style = 'overflow: auto';
        modal.classList.toggle(this._CLASS_HIDDEN);
        this.modalOverlay.classList.toggle(this._CLASS_HIDDEN);
        this.modalContainer.classList.toggle(this._CLASS_HIDDEN);
        this.modalContainer.classList.remove('flex');
    }

    // show modal
    showModal(modal) {
        // скрыть скролл
        document.querySelector('body').style = 'overflow: hidden';
        // отобрать пространство модалки
        this.modalOverlay.classList.toggle(this._CLASS_HIDDEN);
        this.modalContainer.classList.toggle(this._CLASS_HIDDEN);
        this.modalContainer.classList.add('flex');
        // показать нужную модалку
        modal.classList.toggle(this._CLASS_HIDDEN);
    }

    // пепреключение режима скролла на body

    search() {
        this.btns.forEach((btn) => {
            const dataValue = btn.getAttribute(this.MODAL_ATTRIBUTE_NAME);
            const modal = document.querySelector(`.modal[${this.MODAL_ATTRIBUTE_NAME}=${dataValue}]`);

            this.modalPair.push([
                btn,
                modal,
            ]);
        });
    }
}
