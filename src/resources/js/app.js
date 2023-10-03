import ModalHandler from "./components/modalHandler";
import PageList from "./components/pageList";
import SelectImage from "./components/selectImage";
import DropDownList from "./components/dropDown";
import Toasts from "./components/toast";
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

window.toast = new Toasts({
    offsetX: 20, // 20px
    offsetY: 20, // 20px
    gap: 20, // The gap size in pixels between toasts
    width: 300, // 300px
    timing: 'ease', // See list of available CSS transition timings
    duration: '.5s', // Transition duration
    dimOld: true, // Dim old notifications while the newest notification stays highlighted
    position: 'bottom-left' // top-left | top-center | top-right | bottom-left | bottom-center | bottom-right
});
