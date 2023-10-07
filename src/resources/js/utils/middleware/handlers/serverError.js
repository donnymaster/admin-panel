export default function serverError({response, data}) {
    let defaultMessage = response.statusText;

    defaultMessage += '<div class="btn-message ml-2">👁</div>';

    function openTemporaryWindow(el) {
        el.element.querySelector('.toast-notification-close').click();
        createTemporaryWindow(data);
    }

    if (response.status >= 500 && response.status < 600) {
        window.toast.push({
            title: 'Ошибка!',
            content: defaultMessage,
            style: 'error',
            onOpen: (toast) => {
                document.querySelector('.btn-message').addEventListener('click', openTemporaryWindow.bind(this, toast));

            },
            onClose: () => {
                document.querySelector('.btn-message').removeEventListener('click', openTemporaryWindow);
            }
        });

        throw new Error('Server Error');
    }

    return true;
}

function createTemporaryWindow(data) {

    const stringHtml = `
        <div class="temporary-window">
            <div class="temporary-window-remove">❌</div>
            <table>
                <tr>
                    <td>Exception:</td>
                    <td>${data.exception ? data.exception : '-'}</td>
                </tr>
                <tr>
                    <td>File:</td>
                    <td>${data.file ? data.file : '-'}</td>
                </tr>
                <tr>
                    <td>Message:</td>
                    <td>${data.message ? data.message : '-'}</td>
                </tr>
            </table>
        </div>
    `;

    document.querySelector('body').insertAdjacentHTML('afterbegin', stringHtml);

    const window = document.querySelector('.temporary-window');
    const btn = window.querySelector('.temporary-window-remove');


    function remoteWindow() {
        window.remove();
        btn.removeEventListener('click', remoteWindow);
    }

    window.removeTemporaryWindow = remoteWindow;

    btn.addEventListener('click', remoteWindow);
}
