export default ({response}) => {

    if (!Object.hasOwn(response, 'redirected')) {
        return true;
    }

    window.open(response.url, '_top');
    return false;
}
