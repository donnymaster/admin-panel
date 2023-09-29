import ModalHandler from "./components/modalHandler";
import PageList from "./components/pageList";
import SelectImage from "./components/selectImage";
import DropDownList from "./components/dropDown";

/* --- Init --- */
new ModalHandler();

new PageList();

new DropDownList();

document.querySelectorAll('.image-create-page').forEach((imageSelector) => {
   const f = new SelectImage(imageSelector);
   console.log(f);
});


import 'laravel-datatables-vite';

// dark mode

const switchThemeModeBtn = document.querySelector('.admin-site-theme');

if (switchThemeModeBtn) {
    switchThemeModeBtn.addEventListener('click', () => {
        document.documentElement.classList.toggle('dark');
    });
}
