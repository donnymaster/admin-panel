export default function ifRedirectToLogin ({response}) {
    if (response.status === 419) {
        window.location.reload();
        throw new Error('Client error!');
    }

    if (response.url.includes('/admin/login')) {
        window.location.reload();
        throw new Error('Session expired!');
    }

    return true;
}
