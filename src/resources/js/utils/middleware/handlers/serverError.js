export default ({response, data}) => {
    if (response.status >= 500 && response.status < 600) {
        window.toast.push({
            title: 'Ошибка!',
            content: 'Ошибка с стороны сервера!',
            style: 'error',
        });
        console.error(data);
        throw new Error('Server Error');
    }

    return true;
}
