export default ({response, data}) => {
    if (response.status >= 400 && response.status < 500) {

        window.toast.push({
            title: 'Ошибка!',
            content: getMessage(data),
            style: 'error',
        });

        throw new Error('Client Error');
    }

    return true;
}


function getMessage(data) {
    // создать временное окно
    // пихнуть туда сообщения
}
