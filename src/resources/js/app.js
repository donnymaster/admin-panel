import Modal from "./components/modal";
import PageList from "./components/pageList";
import SelectImage from "./components/selectImage";

/* --- Init Modal --- */
new Modal();

new PageList();

document.querySelectorAll('.image-create-page').forEach((imageSelector) => {
   const f = new SelectImage(imageSelector);
   console.log(f);
});
