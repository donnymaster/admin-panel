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

// dark mode
const initTheme = (newState = 'dark') => {

    let state = localStorage.getItem('theme');

    if (!state) {
        state = newState ? newState : 'light';
    } else {
        state = state === 'dark' ? 'light' : 'dark';
    }

    if (state === 'dark') {
        localStorage.setItem('theme', 'dark');
        document.documentElement.classList.add('dark');
    } else {
        localStorage.setItem('theme', 'light');
        document.documentElement.classList.remove('dark');
    }
}

initTheme('dark');

const switchThemeModeBtn = document.querySelector('.admin-site-theme');

if (switchThemeModeBtn) {
    switchThemeModeBtn.addEventListener('click', () => {
        let state = localStorage.getItem('theme');

        state === 'dark' ? initTheme('light') : initTheme();
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
