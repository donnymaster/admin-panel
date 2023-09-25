
document.querySelector('.load-applications').addEventListener('click', () => {
    // get data
    const startDate = document.querySelector('input[name="date-start-application"]').value;
    const endDate = document.querySelector('input[name="date-end-application"]').value;

    fetch(
        `/admin/statistics/applications/date-limit?min=${startDate}&max=${endDate}`
    )
        .then(response => response.json())
        .then((response) => {
            console.log(response);
            updateChart(response, 'fffff')
        });
    // update data
});

function updateChart(data, title) {
    console.log(data.map(d => d.count));
    window.chartApplication.data.labels = data.map(d => d.date);
    window.chartApplication.data.datasets[0].data = data.map(d => d.count);

    window.chartApplication.update();
}


const ctxApplications = document.getElementById('applicationsStatistics');


const labels = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
];


const getData = (title) => {
    return {
        labels: labels,
        datasets: [{
            label: title,
            data: [...Array(7)].map(_ => Math.ceil(Math.random() * 100)),
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
    }
}


window.chartApplication = new Chart(ctxApplications, {
    type: 'line',
    data: getData('Количество заявок'),
    options: {
        maintainAspectRatio: false,
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
