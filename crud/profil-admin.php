<?php
include '../database/config.php';

$query = mysqli_query($db, "SELECT SUM(stok) AS total_stock FROM produk");
$data = mysqli_fetch_assoc($query);
$stock = $data['total_stock'];

$queryPesanan = mysqli_query($db,"SELECT
        (SELECT COUNT(*) FROM pesanan_tunggal) +
        (SELECT COUNT(*) FROM pesanan_ganda) AS jumlahPesanan"
);

$dataPesanan = mysqli_fetch_assoc($queryPesanan);
$totalPesanan = $dataPesanan['jumlahPesanan'];

$queryPembayaran = mysqli_query($db, 
    "SELECT COUNT(id_pembarayan	) AS pendapatan FROM pembayaran"
    
);
if (!$queryPembayaran) {
   die("Query Error: " . mysqli_error($db));
}
$dataPembayaran = mysqli_fetch_assoc($queryPembayaran);
$totalPendapatan = $dataPembayaran['pendapatan'];



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="pesanan">
        <h4>Total pesanan </h4>
        <p><?php echo $totalPesanan;?></p>
    </div>
    <div class="pesanan">
        <h4>Total pendapatan </h4>
        <p><?php echo $totalPendapatan;?></p>
    </div>
    <div class="stock">
        <h4>stock </h4>
        <p><?php echo $stock;?></p>
    </div>

</body>
</html>