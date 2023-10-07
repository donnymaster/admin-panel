

export default class SimplePipeline {

    constructor(
        handlers = [],
        environment = null
    ) {
        this.handlers = handlers;
        this.environment = environment;
        this.isLog = false;
    }

    enableLog(status = true) {
        this.isLog = status;
        return this;
    }



    setEnvironment(environment) {
        this.environment = environment;
        return this;
    }

    addHandler(handler) {
        if (!typeof handler === "function") {
            return this;
        }

        this.handlers.push(handler);
        return this;
    }

    execute() {
        for (let index = 0; index < this.handlers.length; index++) {
            if (this.isLog) {
                this._log(this.environment, this.handlers[index]);
            }

            if (!this.handlers[index](this.environment)) {
                return false;
            }
        }

        return true;
    }

    _log(environment, handler) {
        console.group('SimplePipeline log:');
        console.log('environment: ', environment);
        console.log('handler name: ', handler.name);
        console.groupEnd();
    }
}
