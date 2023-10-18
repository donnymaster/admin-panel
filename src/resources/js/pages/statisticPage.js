import Choices from "choices.js";
import spreadResponse from "../utils/spreadResponse";
import checkIsErrorResponse from "../utils/checkIsErrorResponse";

init();

function init() {
    initChoicesPages();

    loadDatePeriod();

    document.querySelector('.update-applications').addEventListener('click', ({target}) => {
        if (target.classList.contains('load')) return;

        target.classList.add('load');

        updateChart();
    });

}

function initChoicesPages() {
    fetch(
        '/admin/pages/valid-pages'
    )
    .then(spreadResponse)
    .then((response) => {
        if (checkIsErrorResponse(response)) {
            _redrerChoice(response.data);
        }
    });
}

function loadDatePeriod() {
    fetch(
        '/admin/pages/date-limit'
    )
    .then(spreadResponse)
    .then((response) => {
        if (checkIsErrorResponse(response)) {
            document.querySelector('#startDate').value = response.data.min;
            document.querySelector('#endDate').value = response.data.max;
        }
    });
}

function _redrerChoice(data) {
    if (!data.length) {
        document.querySelector('.empty-data-pages').classList.remove('hidden');
        document.querySelector('#loadingChoicePages').classList.add('hidden');
        document.querySelector('.update-applications').classList.add('load');
        document.querySelector('.empty-data-chart').classList.remove('hidden');
        document.querySelector('#loadingChartPages').classList.add('hidden');
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

    window.choice = new Choices('#selected-pages', {
        allowHTML: true,
        delimiter: ',',
        editItems: true,
        maxItemCount: 10,
        removeItemButton: true,
    });

    data.slice(0, 5).forEach((page) => {
        window.choice.setChoiceByValue(page.page_name_visit);
    });

    loadInfo();
}

function updateChart() {
    const pages = window.choice.getValue().map(item => item.value);
    const startDate = document.querySelector('#startDate').value;
    const endDate = document.querySelector('#endDate').value;

    if (!pages.length) {
        document.querySelector('.update-applications').classList.remove('load')
        return;
    }

    const pagesList = pages.map(page => `&pages[]=${page}`).join('');

    fetch(
        `/admin/pages/info-visit?end-date=${endDate}&start-date=${startDate}${pagesList}`
    )
    .then(spreadResponse)
    .then((res) => {
        if (!checkIsErrorResponse(res)) return;

        const { data } = res;

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

        window.chart.data.labels = dates;
        window.chart.data.datasets = [];

        window.chart.data.datasets = renderData;

        window.chart.update();
    }).finally(() => document.querySelector('.update-applications').classList.remove('load'));
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
    const pages = window.choice.getValue().map(item => item.value);

    if (!pages.length) {
        return;
    }

    const pagesList = pages.map(page => `&pages[]=${page}`).join('');

    fetch(
        `/admin/pages/info-visit?last-thirty-days=true${pagesList}`
    )
    .then(spreadResponse)
    .then((response) => {
        if(checkIsErrorResponse(response)) {
            renderDate(response.data);
        }
    });
}


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

    window.chart = new Chart(document.getElementById("line-chart"), {
        type: 'line',
        data: {
            labels: dates,
            datasets: renderData,
        },
        options: {
            responsive: true,
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

    document.getElementById("line-chart").classList.remove('hidden');
    document.querySelector('#loadingChartPages').classList.add('hidden');
}

function _compareByData(x, y) {
    return new Date(x) - new Date(y);
}

const btnContainer = document.querySelector('.remove-history-pages');

btnContainer.addEventListener('click', ({target}) => {
        const type = target.dataset.type;
        let url = '/admin/pages/statistics';

        if (target.classList.contains('load')) return;

        btnContainer.querySelectorAll('div').forEach(div => div.classList.add('load'));

        if (!type) {
            return;
        } else if (type == '30days') {
            url += '?last-days=30'
        }

        fetch(
            url,
            {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': window._token,
                },
            }
        )
        .then(spreadResponse)
        .then((response) => {
            if(checkIsErrorResponse(response)) {
                window.toast.push({
                    title: 'Успех!',
                    content: 'Записи были удалены!',
                    style: 'success',
                    dismissAfter: '1s'
                });
                window.LaravelDataTables.dataTableBuilder.ajax.reload();
            }
        }).finally(() => btnContainer.querySelectorAll('div').forEach(div => div.classList.remove('load')));
    });
