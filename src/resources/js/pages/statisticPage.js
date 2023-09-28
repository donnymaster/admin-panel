import Choices from "choices.js";

// var secondElement = new Choices('#selected-pages', {
//     allowHTML: true,
//     delimiter: ',',
//     editItems: true,
//     maxItemCount: 5,
//     removeItemButton: true,
// });

// console.log(secondElement);

function initChoicesPages() {
    // send request
    fetch(
        '/admin/pages/valid-pages'
    )
        .then(response => response.json())
        .then((response) => {
            redrerChoice(response);
        });

}

initChoicesPages();

function redrerChoice(data) {
    // if empty data
    if (!data.length) {
        return;
    }

    const parentElement = document.querySelector('#selected-pages');

    document.querySelector('#loadingChoicePages').classList.add('hidden');
    parentElement.classList.remove('hidden');

    data.forEach((page) => {
        const option = document.createElement('option');
        option.classList.add();
        option.textContent = page.page_name_visit;
        option.value = page.page_name_visit;

        parentElement.append(option);
    });

    // if data

    window.choice = new Choices('#selected-pages', {
        allowHTML: true,
        delimiter: ',',
        editItems: true,
        maxItemCount: 5,
        removeItemButton: true,
    });
}

document.querySelector('.update-applications').addEventListener('click', () => {
    console.log(window.choice.getValue().map(item => item.value));
    updateChart();
});



function updateChart() {
    // get data
    const pages = window.choice.getValue().map(item => item.value);
    const startDate = document.querySelector('#startDate').value;
    const endDate = document.querySelector('#endDate').value;

    if (!pages.length) {
        return;
    }

    const pagesList = pages.map(page => `&pages[]=${page}`);
    console.log(pagesList);

    // fetch data
    fetch(
        `/admin/pages/info-visit?end-date=${endDate}&start-date=${startDate}`
    )
    .then(response => response.json())
    .then((response) => {
        // TODO: check is 401
        //check data
        console.log(response);
    });
}

const skipped = (ctx, value) => ctx.p0.skip || ctx.p1.skip ? value : undefined;

const stringToColour = (str) => {
    let hash = 0;
    str.split('').forEach(char => {
        hash = char.charCodeAt(0) + ((hash << 5) - hash);
    })
    let colour = '#';
    for (let i = 0; i < 3; i++) {
        const value = (hash >> (i * 8)) & 0xff;
        colour += value.toString(16).padStart(2, '0');
    }
    return colour;
}

var groupBy = function (xs, key) {
    return xs.reduce(function (rv, x) {
        (rv[x[key]] = rv[x[key]] || []).push(x);
        return rv;
    }, {});
};

function loadInfo() {
    fetch(
        '/admin/pages/info-visit'
    )
        .then(response => response.json())
        .then((response) => {
            renderDate(response);
        });
}

loadInfo();


function renderDate(data) {
    const dates = [...new Set(data.map(obj => obj.date))].sort(_compareByData);
    const rawData = groupBy(data, 'page_name_visit');
    const renderData = [];

    for (const [key, value] of Object.entries(rawData)) {
        let r = value.sort((x, y) => new Date(x.date) - new Date(y.date));

        const values = dates.map((date) => {
            const val = r.find(f => f.date == date);

            return val ? val.count : NaN;
        });

        const color = stringToColour(key);

        renderData.push({
            label: key,
            data: values,
            fill: false,
            borderColor: color,
            segment: {
                borderColor: ctx => skipped(ctx, color),
                borderDash: ctx => skipped(ctx, [6, 6]),
            },
            spanGaps: true,
        });
    }

    new Chart(document.getElementById("line-chart"), {
        type: 'line',
        data: {
            labels: dates,
            datasets: renderData,
        },
        options: {
            fill: false,
            interaction: {
                intersect: false
            },
            layout: {
                padding: {
                    left: 30,
                    right: 30,
                    top: 15,
                    bottom: 15,
                }
            }
        }
    });
}

function _compareByData(x, y) {
    return new Date(x) - new Date(y);
}

function getRandomRgb() {
    var num = Math.round(0xffffff * Math.random());
    var r = num >> 16;
    var g = num >> 8 & 255;
    var b = num & 255;
    return 'rgb(' + r + ', ' + g + ', ' + b + ')';
}
