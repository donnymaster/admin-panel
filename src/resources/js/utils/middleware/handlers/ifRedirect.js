export default function ifRedirect({response}) {
    if (!response.redirected) {
        return true;
    }

    window.open(response.url, '_top');
    return false;
}
