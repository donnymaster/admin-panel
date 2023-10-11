import checkIsErrorResponse from "../utils/checkIsErrorResponse";
import spreadResponse from "../utils/spreadResponse";

export default class LoaderImage {
    constructor(
        addImageBtnSelector
    ) {
        this.addImage = document.querySelector(addImageBtnSelector);

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
        console.log(image);
        const formData = new FormData();
        formData.append('image', image);
        formData.append('type', 'product-variant');

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
