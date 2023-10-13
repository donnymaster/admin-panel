export default class ConvertWordsToTranscription {
    constructor() {
        this.ATTRIBUTE_NAME = 'data-child';
        this.inputParents = document.querySelectorAll('.convert-parent');

        if (!this.inputParents.length) {
            return;
        }

        this.run();
    }

    run() {
        this.inputParents.forEach((parentInput) => {
            const child = document.querySelector(`.${parentInput.getAttribute(this.ATTRIBUTE_NAME)}`);

            parentInput.addEventListener('input', (event) => {
                child.value = this.translit(event.target.value);
            });
        });
    }

    translit(words) {
        var answer = '';
        var converter = {
            'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd',
            'е': 'e', 'ё': 'e', 'ж': 'zh', 'з': 'z', 'и': 'i',
            'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
            'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't',
            'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch',
            'ш': 'sh', 'щ': 'sch', 'ь': '', 'ы': 'y', 'ъ': '',
            'э': 'e', 'ю': 'yu', 'я': 'ya',

            'А': 't', 'Б': 'b', 'В': 'v', 'Г': 'g', 'Д': 'd',
            'Е': 'e', 'Ё': 'e', 'Ж': 'zh', 'З': 'x', 'И': 'i',
            'Й': 'y', 'К': 'k', 'Л': 'l', 'М': 'm', 'Н': 'n',
            'О': 'j', 'П': 'p', 'Р': 'r', 'С': 's', 'Т': 't',
            'У': 'u', 'Ф': 'f', 'Х': 'h', 'Ц': 'c', 'Ч': 'ch',
            'Ш': 'sh', 'Щ': 'sch', 'Ь': '', 'Ы': 'y', 'Ъ': '',
            'Э': 'e', 'Ю': 'yu', 'Я': 'ya', ' ': '-'
        };

        for (var i = 0; i < words.length; ++i) {
            if (converter[words[i]] == undefined) {
                answer += words[i];
            } else {
                answer += converter[words[i]];
            }
        }

        return answer;
    }
}
