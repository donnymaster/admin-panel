import ItcAccordion from "../components/accordion";
import LoaderImage from "../components/loadingImage";

new ItcAccordion('#accordion-1', {
    alwaysOpen: true
  });

new LoaderImage(
    '.btn-add-image',
    {
        'product-id': document.querySelector('#information').dataset.product
    }
);
