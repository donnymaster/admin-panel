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
//    console.log(f);
});


import 'laravel-datatables-vite';

function initTheme() {
    const theme = localStorage.getItem('theme');

    if (theme) {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}

initTheme();

const switchThemeModeBtn = document.querySelector('.admin-site-theme');

if (switchThemeModeBtn) {
    switchThemeModeBtn.addEventListener('click', () => {
        const currentState = localStorage.getItem('theme');

        if (currentState === 'dark') {
            localStorage.setItem('theme', 'light');
            document.documentElement.classList.remove('dark');
        } else {
            localStorage.setItem('theme', 'dark');
            document.documentElement.classList.add('dark');
        }
    });
}


window.toast = new Toasts({
    offsetX: 15, // 20px
    offsetY: 15, // 20px
    gap: 20, // The gap size in pixels between toasts
    width: 370, // 300px
    timing: 'ease', // See list of available CSS transition timings
    // duration: '.5s', // Transition duration
    // dimOld: true, // Dim old notifications while the newest notification stays highlighted
    position: 'bottom-left' // top-left | top-center | top-right | bottom-left | bottom-center | bottom-right
});
