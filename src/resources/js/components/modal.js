export default class Modal {
    /**
     *
     * @param {HTMLElement} modalElementContainer
     * @param {HTMLElement} buttonElementContainer
     */
    constructor(modalElementContainer, buttonElementContainer) {
        this.modal = modalElementContainer;
        this.button = buttonElementContainer;

        if (!this.button) {
            this.installHandlersWithoutButton();
        } else {
            this.installHandlers();
        }
    }

    installHandlers() {
        this.button.addEventListener('click', () => this.openModal)
    }

    installHandlersWithoutButton() {
        // без конпки
    }
}
