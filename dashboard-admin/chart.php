<?php
include '../database/config.php';

$query =  mysqli_query($db,"SELECT
        (SELECT COUNT(*) FROM pesanan_tunggal) +
        (SELECT COUNT(*) FROM pesanan_ganda) AS jumlahPesanan");

// $nama = [];
$stok = [];

while($data = mysqli_fetch_assoc($query)){
//     $nama[] = $data['id'];
    $stok[] = $data['jumlahPesanan'];
}


?>

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
<canvas id="myChart"></canvas>

<script>
const ctx = document.getElementById('myChart');

new Chart(ctx, {
    type: 'line', // jenis grafik
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr'],
        datasets: [{
            label: 'Penjualan',
            data: [10, 20, 15, 30]
        }]
    }
});
</script>

</script>
</div>
</body>
</html>

