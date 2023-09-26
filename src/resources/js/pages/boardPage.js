
document.querySelector('.load-applications').addEventListener('click', () => {
    const startDate = document.querySelector('input[name="date-start-application"]').value;
    const endDate = document.querySelector('input[name="date-end-application"]').value;

    fetch(
        `/admin/statistics/applications/date-limit?min=${startDate}&max=${endDate}`
    )
        .then(response => response.json())
        .then((response) => {
            updateChart(response);
        });
});

function updateChart(data) {
    window.chartApplication.data.labels = data.map(d => d.date);
    window.chartApplication.data.datasets[0].data = data.map(d => d.count);

    window.chartApplication.update();
}

function initChartApplication() {
    const loader = document.getElementById('loadingApplication');
    const ctxApplication = document.getElementById('applicationsStatistics');
    const startDate = document.querySelector('input[name="date-start-application"]').value;
    const endDate = document.querySelector('input[name="date-end-application"]').value;

    fetch(
        `/admin/statistics/applications/date-limit?min=${startDate}&max=${endDate}`
    )
    .then(response => response.json())
    .then((response) => {
        console.log(response);
        const data = {
            labels: response.map(d => d.date),
            datasets: [{
                label: 'Количество заявок',
                data: response.map(d => d.count),
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        };

        window.chartApplication = new Chart(ctxApplication, {
            type: 'line',
            data: data,
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

        ctxApplication.classList.remove('hidden');
        loader.classList.add('hidden');

    });

}

function initChartReviews() {
    const ctxReviews = document.getElementById('reviewsStatistics');
    const loader = document.getElementById('loadingReviews');


    fetch(
        '/admin/statistics/applications/reviews-info'
    )
    .then(response => response.json())
    .then((response) => {
        console.log(response);
        const data = {
            labels: response.map(d => d.rating),
            datasets: [{
                label: 'Количество комментариев',
                data: response.map(d => d.count),
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        };

        window.ctxReview = new Chart(ctxReviews, {
            type: 'line',
            data: data,
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

        ctxReviews.classList.remove('hidden');
        loader.classList.add('hidden');

    });
}

initChartApplication();
initChartReviews();
