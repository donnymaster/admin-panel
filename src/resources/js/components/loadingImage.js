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
        })
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

        this.createContainer();
        this.addDefaultImage();
    }

    createContainer() {
        this.container = document.createElement('div');
        this.container.classList.add('load-image-row');

        const header = document.createElement('div');
        header.classList.add('header');

        const remove = document.createElement('div');
        remove.classList.add('mr-3', 'remove-row');
        remove.textContent = '🗑';

        const addImage = document.createElement('div');
        addImage.classList.add('add-custom-image');
        addImage.textContent = '➕';

        header.append(remove);
        header.append(addImage);


        const body = document.createElement('div');
        body.classList.add('body');

        this.container.append(header);
        this.container.append(body);

        this.parent.append(this.container);
    }

    addDefaultImage() {
        const htmlString = `
        <div class="default-image">
            <div class="overlay-image">
                <div class="type-image">Type: по-умолчанию</div>
                <div class="size-image">Size: ${this.data.data.size}</div>
            </div>
            <img src="${this.data.data['url-image']}" alt="default-image">
        </div>
        `;

        this.container.querySelector('.body').insertAdjacentHTML('beforeend', htmlString);
    }
}
