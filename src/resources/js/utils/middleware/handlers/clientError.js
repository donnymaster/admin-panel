export default function clientError({response, data}) {
    if (response.status >= 400 && response.status < 500) {
        let defaultMessage = 'Произошла ошибка';

        defaultMessage += '<div class="btn-message ml-2">👁</div>';

        function openTemporaryWindow(el) {
            el.element.querySelector('.toast-notification-close').click();
            createTemporaryWindow(data);
        }

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

        throw new Error('Client Error');
    }

    return true;
}


function createTemporaryWindow(data) {

    let dataHtmlString = `
    <div class="temporary-window">

        <div class="flex justify-between">
            <div class="mb-3">Ошибка с данными</div>
            <div class="temporary-window-remove">❌</div>
        </div>
            <table>
    `;


    if ('errors' in data) {
        for (const key in data.errors) {
            dataHtmlString += `
                <tr>
                    <td>${data.errors[key].reduce((prev, curr) => prev + curr + '<br>')}</td>
                </tr>
            `;
        }
    } else {
        dataHtmlString += `
        <tr>
            <td>Message:</td>
            <td>${data.message ? data.message : '-'}</td>
        </tr>
        `;
    }

    dataHtmlString += `
            </table>
        </div>
    `;

    document.querySelector('body').insertAdjacentHTML('afterbegin', dataHtmlString);

    const window = document.querySelector('.temporary-window');
    const btn = window.querySelector('.temporary-window-remove');


    function remoteWindow() {
        window.remove();
        btn.removeEventListener('click', remoteWindow);
    }

    window.removeTemporaryWindow = remoteWindow;

    btn.addEventListener('click', remoteWindow);
}
