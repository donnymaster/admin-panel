import SimplePipeline from "./middleware/simplePipeline";
import redirect from "./middleware/handlers/ifRedirect";
import redirectToLogin from "./middleware/handlers/ifRedirectToLogin";
import clientError from "./middleware/handlers/clientError";
import serverError from "./middleware/handlers/serverError";

export default function checkIsErrorResponse(response) {
    const pipeline = (new SimplePipeline(
        [
            redirect,
            redirectToLogin,
            clientError,
            serverError,
        ],
        response
    ));
    // .enableLog();

    return pipeline.execute();
}


// export default function checkIsErrorResponse({data, response}) {
//     // готово
//     if (response.redirected) {
//         window.open(response.url, '_top');
//         return false;
//     }

//     // готово
//     if ((response.status >= 300 && response.status < 400)) {
//         window.open(response.url);
//         return false;
//     }

//     // готово
//     if (response.url?.includes('/admin/login')) {
//         window.location.reload();
//         throw new Error('Session expired!');
//     }

//     if (response.status == 401) {
//         // ограничен доступ
//         window.toast.push({
//             title: 'Ошибка!',
//             content: 'У вас нет доступа!',
//             style: 'error',
//         });

//         throw new Error('Access limited!');
//     }

//     if (response.status == 419) {
//         // ограничен доступ
//         window.toast.push({
//             title: 'Ошибка!',
//             content: 'У вас нет доступа!',
//             style: 'error',
//         });

//         window.location.reload();
//     }

//     if (response.status >= 400 && response.status < 500) {
//         let message = 'Ошибка с вашей стороны!';

//         if ('message' in data) {
//             message += '</br>' + data.message;
//         }
//         // ошибка на стороне клиента
//         window.toast.push({
//             title: 'Ошибка!',
//             content: message,
//             style: 'error',
//         });
//         throw new Error('Client Error');
//     }

//     if (response.status >= 500 && response.status < 600) {
//         // ошибка на стороне сервера
//         window.toast.push({
//             title: 'Ошибка!',
//             content: 'Ошибка с стороны сервера!',
//             style: 'error',
//         });
//         throw new Error('Server Error');
//     }

//     return true;
// }
