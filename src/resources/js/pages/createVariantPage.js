import LoaderImage from "../components/loadingImage";

new LoaderImage(
    '.btn-add-image',
    {
        'product-id': document.querySelector('#information').dataset.product
    }
    );

    window.onbeforeunload = function() {
        return 'Перед тем как уйти с страницы, удалите все не использованные картинки!';
      }
