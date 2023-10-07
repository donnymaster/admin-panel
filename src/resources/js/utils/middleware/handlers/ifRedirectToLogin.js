export default ({response}) => {
    if (!Object.hasOwn(response, 'url')) {
        return true;
    }

    if (response.url.includes('/admin/login')) {
        window.location.reload();
        throw new Error('Session expired!');
    }
}
