

export default class SimplePipeline {

    constructor(
        handlers = [],
        environment = null
    ) {
        this.handlers = handlers;
        this.environment = environment;
    }

    setEnvironment(environment) {
        if (Object.keys(environment).length === 0) {
            return;
        }

        this.environment = environment;
    }

    addHandler(handler) {
        if (!typeof handler === "function") {
            return;
        }

        this.handlers.push(handler);
    }

    execute() {
        for (let index = 0; index < this.handlers.length; index++) {
            if (!this.handlers[index](this.environment)) {
                return false;
            }
        }

        return true;
    }
}
