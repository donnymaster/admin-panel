import LoaderImage from "../components/loadingImage";

new LoaderImage(
    '.btn-add-image',
    {
        'product-id': document.querySelector('#information').dataset.product
    }
    );
