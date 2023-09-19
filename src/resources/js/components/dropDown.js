
export default class DropDownList {
    constructor() {
        this.dropDownContainer = document.querySelector('.drop-down-list-container');

        if (!this.dropDownContainer) {
            return;
        }

        this.run();
    }

    run() {
        const dropDownItems = this.dropDownContainer.querySelectorAll('.drop-down-child');

        dropDownItems.forEach((item) => {
            item.addEventListener('click', this.handlerClickDropDownItem.bind(this, item));
        });
    }

    handlerClickDropDownItem(item) {
        console.log(item);
    }
}
