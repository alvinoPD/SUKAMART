<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link rel="stylesheet" href="../style/chart.css" >
</head>
<body>
<div id = "chart">
<canvas id="chartPesanan"></canvas>

<script>

fetch("../dataAdmin/dataPesananChart.php")
.then(res => res.json())
.then(data => {

    const ctx = document.getElementById('chartPesanan');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Total Pesanan:'],
            datasets: [{
                label: 'Jumlah Pesanan',
                data: [data.total_pesanan],
                borderWidth: 2,
                tension: 0.3,
                fill: false
                
            }]
        },
        options: {
            responsive: true,
            plugins: {
    legend: {
        display: false
    }
}

            
        }
    });

});


</script>
</div>
</body>
</html>

