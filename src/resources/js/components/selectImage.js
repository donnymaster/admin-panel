export default class SelectImage {
    constructor(imageContainer) {
        this.container = imageContainer;
        this.input = this.container.closest('.input-group').querySelector('input');
        this.placeholderImage = this.container.closest('.input-group').querySelector('svg');
        this.imageUrl = '';

        this.run();
    }

    run() {
        this._addEventClickSelectImage();
        this._addEventChangeImage();
    }

    _addEventClickSelectImage() {
        this.container.addEventListener('click', () => {
            this.input.click();

        });
    }

    _addEventChangeImage() {
        this.input.addEventListener('change', (event) => {
            this._setBackgroundImage(event.target.files[0]);
        });
    }

    _setBackgroundImage(image) {
        this.placeholderImage.classList.add('hidden');
        const reader = new FileReader();

        reader.addEventListener('load', (e) => {
            this.container.style.backgroundImage = 'url(' + e.target.result + ')';
        });

        reader.readAsDataURL(image);
    }
}
