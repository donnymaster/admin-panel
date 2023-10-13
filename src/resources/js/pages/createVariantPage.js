import LoaderImage from "../components/loadingImage";
import ItcAccordion from "../components/accordion";

new ItcAccordion('#accordion-1', {
    alwaysOpen: true
  });

new LoaderImage(
    '.btn-add-image',
    {
        'product-id': document.querySelector('#information').dataset.product
    }
    );

// window.onbeforeunload = function() {
//     return 'Перед тем как уйти с страницы, удалите все не использованные картинки!';
// }
