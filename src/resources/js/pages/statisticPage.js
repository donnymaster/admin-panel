import Choices from "choices.js";

var secondElement = new Choices('#demo-2', { removeButton: true, removeItems: true, });

const skipped = (ctx, value) => ctx.p0.skip || ctx.p1.skip ? value : undefined;
const down = (ctx, value) => ctx.p0.parsed.y > ctx.p1.parsed.y ? value : undefined;

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
