

export default class LoaderImages {
    constructor(parent = '') {

        if (parent) {
            this.container = parent.querySelector('.loader-image-container');
        } else {
            this.container = document.querySelector('.loader-image-container');
        }

        this.valueInput = this.container.getAttribute('data-input-template');

        this.run();
    }

    run() {
        const inputDefault = document.createElement('input');
        inputDefault.setAttribute('hidden', true);
        inputDefault.setAttribute('type', 'file');
        this.container.append(inputDefault);
        this.inputDefault = inputDefault;

        this.container.querySelector('.image-new')
            .addEventListener('click', () => this.inputDefault.click());

        inputDefault.addEventListener('change', this.handlerAddNewImage.bind(this));
    }

    handlerAddNewImage(event) {
        if (!event.target.files.length) {
            return;
        }

        const imageItem = document.createElement('div');
        imageItem.classList.add('image-item');

        const deleteImage = document.createElement('div');
        deleteImage.classList.add('remove-item');
        deleteImage.textContent = '╳';
        deleteImage.addEventListener('click', this.remoteImageItem.bind(this));

        const inputImage = document.createElement('input');
        inputImage.setAttribute('type', 'file');
        inputImage.setAttribute('hidden', true);
        inputImage.setAttribute('name', this.valueInput);

        imageItem.append(inputImage);
        imageItem.append(deleteImage);

        this.container.insertAdjacentElement('afterbegin', imageItem);

        const file = event.target.files[0];
        const reader = new FileReader();

        inputImage.files  = event.target.files;

        reader.addEventListener('load', (e) => {
            console.log(e.target);
            imageItem.style.backgroundImage = 'url(' + e.target.result + ')';
        });

        reader.readAsDataURL(file);
    }

    remoteImageItem(event) {
        const parent = event.target.closest('.image-item');

        event.target.removeEventListener('click', this.remoteImageItem);

        parent.remove();
    }
}
