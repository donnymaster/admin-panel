export default function checkIsErrorResponse(response) {
    if (response.redirected) {
        window.open(response.url, '_top');
        return false;
    }

    if ((response.status >= 300 && response.status < 400)) {
        window.open(response.url);
        return false;
    }

    // if redirect to login
    if (response.url.includes('/admin/login')) {
        window.location.reload();
        throw new Error('Session expired!');
    }

    if (response.status == 401) {
        // ограничен доступ
        window.toast.push({
            title: 'Ошибка!',
            content: 'У вас нет доступа!',
            style: 'error',
            dismissAfter: '2s'
        });

        throw new Error('Access limited!');
    }

    if (response.status >= 400 && response.status < 500) {
        // ошибка на стороне клиента
        window.toast.push({
            title: 'Ошибка!',
            content: 'Ошибка с вашей стороны!',
            style: 'error',
            dismissAfter: '2s'
        });
        throw new Error('Client Error');
    }

    if (response.status >= 500 && response.status < 600) {
        // ошибка на стороне сервера
        window.toast.push({
            title: 'Ошибка!',
            content: 'Ошибка с стороны сервера!',
            style: 'error',
            dismissAfter: '2s'
        });
        throw new Error('Server Error');
    }

    return true;
}
