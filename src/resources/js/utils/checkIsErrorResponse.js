export default function checkIsErrorResponse(response, isRedirect = false) {
    if (isRedirect) {
        window.location.reload();
    }

    if (response.status == 419 || response.status == 401 || response.status == 302) {
        window.location.reload();
    }
    return false;
}
