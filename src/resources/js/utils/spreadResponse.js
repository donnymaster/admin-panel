export default async function spreadResponse(response) {
    let data = null;

    try {
        data = await response.json();
    } catch (error) {
        data = {};
    }

    return {
        data,
        response,
    }
}
