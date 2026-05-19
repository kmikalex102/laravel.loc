<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Statistics Dashboard</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h1>Visit Statistics</h1>

<h2>Hourly visits</h2>
<canvas id="hourChart"></canvas>

<h2>Cities distribution</h2>
<canvas id="cityChart"></canvas>

<script>
    async function loadHourly() {
        const res = await fetch('/api/stats/hourly');
        const data = await res.json();
        console.log(data);

        new Chart(document.getElementById('hourChart'), {
            type: 'bar',
            data: {
                labels: data.map(i => i.hour), // ось Y
                datasets: [{
                    label: 'Unique visits',
                    data: data.map(i => i.unique_visits) // ось X
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    async function loadCities() {
        const res = await fetch('/api/stats/cities');
        const data = await res.json();

        new Chart(document.getElementById('cityChart'), {
            type: 'pie',
            data: {
                labels: data.map(i => i.city),
                datasets: [{
                    data: data.map(i => i.total)
                }]
            }
        });
    }

    loadHourly();
    loadCities();
</script>

</body>
</html>
