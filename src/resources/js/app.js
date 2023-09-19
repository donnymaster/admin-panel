import Modal from "./components/modal";
import PageList from "./components/pageList";
import SelectImage from "./components/selectImage";
import DropDownList from "./components/dropDown";

/* --- Init --- */
new Modal();

new PageList();

new DropDownList();

document.querySelectorAll('.image-create-page').forEach((imageSelector) => {
   const f = new SelectImage(imageSelector);
   console.log(f);
});


import 'laravel-datatables-vite';
