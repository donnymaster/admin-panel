import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import spreadResponse from "../utils/spreadResponse";

export default class LoaderImage {
    constructor(
        addImageBtnSelector,
        data,
    ) {
        this.data = data;
        this.addImage = document.querySelector(addImageBtnSelector);
        this.imageRowsContainer = document.querySelector('.load-images-container');
        this.imageRows = [];

        this.createBufferInput();
        this.addEventHandlers();
    }

    addEventHandlers() {
        this.addImage.addEventListener('click', this.addFileImage.bind(this));
        this.bufferInput.addEventListener('change', this.selectFile.bind(this));
    }

    addFileImage() {
        this.bufferInput.click();
    }

    sendImage(image) {
        const formData = new FormData();
        formData.append('image', image);
        formData.append('type', 'variant');

        for (const key in this.data) {
            formData.append(key, this.data[key]);
        }

        fetch(
            '/admin/image/save',
            {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': window._token,
                },
                body: formData
            }
        )
            .then(spreadResponse)
            .then((response) => {
                if (checkIsErrorResponse(response)) {
                    this.imageRows.push(
                        new RowImage(response.data, this.imageRowsContainer)
                    );
                }
            });
    }

    selectFile(event) {
        const files = event.target.files;

        if (!files.length) {
            return;
        }

        this.sendImage(files[0]);
    }

    createBufferInput() {
        const input = document.querySelector('input');
        input.hidden = true;
        input.type = 'file';
        input.accept = 'image/*';

        document.documentElement.append(input);

        this.bufferInput = input;
    }
}


class RowImage {
    constructor(data, parent) {
        this.data = data;
        this.parent = parent;

        this.handlersRemoveItems = [];
        this.handlersEvents = [];

        this.createContainer();
        this.addDefaultImage();
        this.modal = document.querySelector('.modal[data-modal="add-image"]');
    }

    createContainer() {
        this.container = document.createElement('div');
        this.container.classList.add('load-image-row');

        this.overlayContainer = document.createElement('div');
        this.overlayContainer.classList.add('overlay');

        const header = document.createElement('div');
        header.classList.add('header');

        const remove = document.createElement('div');
        remove.classList.add('mr-3', 'remove-row');
        this.removeImageContainerBtn = remove;

        const handlerRemoveBtn = this.removeRow.bind(this);
        this.removeImageContainerBtn.addEventListener('click', handlerRemoveBtn);

        this.handlersEvents.push({
            type: 'click',
            el: this.removeImageContainerBtn,
            handler: handlerRemoveBtn,
        });

        const addImage = document.createElement('div');
        addImage.classList.add('add-custom-image');
        this.addNewResizeImage = addImage;

        header.append(remove);
        header.append(addImage);


        const body = document.createElement('div');
        body.classList.add('body');

        this.container.append(header);
        this.container.append(body);
        this.container.append(this.overlayContainer);

        this.parent.append(this.container);

        const handlerNewResizeImage = this.addReziseImageHandler.bind(this);
        this.addNewResizeImage.addEventListener('click', handlerNewResizeImage);

        this.handlersEvents.push({
            type: 'click',
            el: this.addNewResizeImage,
            handler: handlerNewResizeImage,
        });
    }

    removeRow() {
        // get images
        const images = [...this.container.querySelectorAll('img')];

        const imageUrls = images.map((img) => img.getAttribute('src').replace('/storage/', ''));

        this.overlayContainer.classList.add('load');

        fetch(
            '/admin/image/remove',
            {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window._token,
                },
                body: JSON.stringify({'image-url': imageUrls})
            }
        )
        .then(spreadResponse)
        .then((response) => {
            if (checkIsErrorResponse(response)) {
                window.toast.push({
                    title: 'Успех!',
                    content: 'Картинки была удалены!',
                    style: 'success',
                    dismissAfter: '1s'
                });

                // remove handlers
                this.handlersEvents.forEach((val) => {
                    val.el.removeEventListener(val.type, val.handler);
                });

                this.handlersRemoveItems.forEach((val) => {
                    const btn = document.querySelector(`.delete-image[data-id="${val.id}"]`);
                    btn.removeEventListener('click', val.handler);
                });

                // remove row
                this.container.remove();
            }
        });
    }

    addReziseImageHandler() {
        document.querySelector('.modal-btn[data-modal="add-image"]').click();
        const handler = this.sendImageResize.bind(this);

        this.modal.querySelector('#addNewImage').addEventListener('click', handler);

        this.onCloseModal(this.modal, (observer) => {
            this.modal.querySelector('#addNewImage').removeEventListener('click', handler);
            observer.disconnect();
        });
    }

    sendImageResize() {
        const width = this.modal.querySelector('input[id="image-width"]').value;
        const height = this.modal.querySelector('input[id="image-height"]').value;

        const size = this.calculateAspectRatioFit(parseInt(width), parseInt(height));

        const formData = new FormData();
        formData.append('image-height', parseInt(size.height));
        formData.append('image-width', parseInt(size.width));
        formData.append('image-path', this.data.data['path-image']);

        fetch(
            '/admin/image/save/resize',
            {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': window._token,
                },
                body: formData
            }
        )
            .then(spreadResponse)
            .then((response) => {
                if (checkIsErrorResponse(response)) {
                    this.addNewVariantResizeImage(response.data, size);
                }
            });

    }

    onCloseModal(node, callback) {
        let lastClassString = node.classList.toString();

        const mutationObserver = new MutationObserver((mutationList) => {
            for (const item of mutationList) {
                if (item.attributeName === "class") {
                    const classString = node.classList.toString();
                    if (classString.includes('hidden')) {
                        callback(mutationObserver);
                        lastClassString = classString;
                        break;
                    }
                }
            }
        });

        mutationObserver.observe(node, { attributes: true });
        return mutationObserver;
    }

    addNewVariantResizeImage(image, size) {
        console.log(image);

        const htmlString = `
        <div class="default-image">
            <div class="delete-image">❌</div>
            <div class="overlay-image">
                <div class="proportions-image">${parseInt(size.width)}x${parseInt(size.height)}</div>
                <div class="size-image">Size: ${image.size}</div>
            </div>
            <div class="image-wrapper">
                <img src="${image['url-image']}" alt="resize-image">
            </div>
        </div>
        `;

        this.container.querySelector('.body').insertAdjacentHTML('beforeend', htmlString);
        const btnRemoveImage = this.container.querySelector('.body').querySelector('.default-image:last-child .delete-image');
        const id = Math.random().toString(36).substring(2, 2 + 35);

        btnRemoveImage.dataset.id = id;

        const handler = this.handlerRemoveResizeImage.bind(this, image['url-image']);

        this.handlersRemoveItems.push({
            id,
            handler,
        });

        btnRemoveImage.addEventListener('click', handler);

    }

    handlerRemoveResizeImage(imagePath, {target}) {
        const id = target.dataset.id;
        const handler = this.handlersRemoveItems.find((el) => el.id == id).handler;

        this.overlayContainer.classList.add('load');

        fetch(
            '/admin/image/remove',
            {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window._token,
                },
                body: JSON.stringify({'image-url': imagePath.replace('/storage/', '')})
            }
        )
        .then(spreadResponse)
        .then((response) => {
            if (checkIsErrorResponse(response)) {
                window.toast.push({
                    title: 'Успех!',
                    content: 'Картинка была удалена!',
                    style: 'success',
                    dismissAfter: '1s'
                });
                target.removeEventListener('click', handler);
                target.closest('.default-image').remove();
                this.handlersRemoveItems = this.handlersRemoveItems.filter((el) => el.id != id);
                console.log(this.handlersRemoveItems);
            }
        }).finally(() => this.overlayContainer.classList.remove('load'));
    }

    calculateAspectRatioFit(maxWidth, maxHeight) {
        var ratio = Math.min(maxWidth / this.data.data.width, maxHeight / this.data.data.heigth);
        return { width: this.data.data.width * ratio, height: this.data.data.heigth * ratio };
     }

    addDefaultImage() {
        const htmlString = `
        <div class="default-image">
            <div class="overlay-image">
                <div class="proportions-image">${this.data.data.width}x${this.data.data.heigth}</div>
                <div class="size-image">Size: ${this.data.data.size}</div>
            </div>
            <div class="image-wrapper">
                <img src="${this.data.data['url-image']}" alt="default-image">
            </div>
        </div>
        `;

        this.container.querySelector('.body').insertAdjacentHTML('beforeend', htmlString);
    }
}
