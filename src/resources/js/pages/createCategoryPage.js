
class Store {
    constructor(initData) {
        this.store = {};

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
    constructor () {
        this.store = new Store();
        this.addEventListener();
    }

    addEventListener() {
        document.querySelector('.add-property').addEventListener('click', this.createInpuntsNewVariant);
    }

    createInpuntsNewVariant() {
        console.log(1);
    }
}

new HandlerCategoryProperty();
