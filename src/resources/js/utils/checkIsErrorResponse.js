import wordwrap from 'wordwrapjs';

export default function checkIsErrorResponse({data, response}) {
    if (response.redirected) {
        window.open(response.url, '_top');
        return false;
    }

    if ((response.status >= 300 && response.status < 400)) {
        window.open(response.url);
        return false;
    }

    // if redirect to login
    if (response.url?.includes('/admin/login')) {
        window.location.reload();
        throw new Error('Session expired!');
    }

    if (response.status == 401) {
        // ограничен доступ
        window.toast.push({
            title: 'Ошибка!',
            content: 'У вас нет доступа!',
            style: 'error',
        });

        throw new Error('Access limited!');
    }

    if (response.status == 419) {
        // ограничен доступ
        window.toast.push({
            title: 'Ошибка!',
            content: 'У вас нет доступа!',
            style: 'error',
        });

        window.location.reload();
    }

    if (response.status >= 400 && response.status < 500) {
        let message = 'Ошибка с вашей стороны!';

        if ('message' in data) {
            message += '</br>' + data.message;
            message = formatTextWrap(message, 5);
        }
        // ошибка на стороне клиента
        window.toast.push({
            title: 'Ошибка!',
            content: message,
            style: 'error',
        });
        throw new Error('Client Error');
    }

    if (response.status >= 500 && response.status < 600) {
        // ошибка на стороне сервера
        window.toast.push({
            title: 'Ошибка!',
            content: 'Ошибка с стороны сервера!',
            style: 'error',
        });
        throw new Error('Server Error');
    }

    return true;
}


function formatTextWrap(text, maxLineLength) {
    const words = text.replace(/[\r\n]+/g, ' ').split(' ');
    let lineLength = 0;

    // use functional reduce, instead of for loop
    return words.reduce((result, word) => {
      if (lineLength + word.length >= maxLineLength) {
        lineLength = word.length;
        return result + `\n${word}`; // don't add spaces upfront
      } else {
        lineLength += word.length + (result ? 1 : 0);
        return result ? result + ` ${word}` : `${word}`; // add space only when needed
      }
    }, '');
  }
