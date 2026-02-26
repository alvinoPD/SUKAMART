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
    <link rel = "stylesheet" href = "../style/profil-admin.css" >
</head>
<body>
    <div class = "atas">
        
        <div class="pesanan">
            <h4>Total pesanan </h4>
            <i class="fa-solid fa-cart-arrow-down"></i>
            <h5 class="text"><?php echo $totalPesanan;?></h5>
        </div>
        <div class="pendapatan">
            <h4>Total pendapatan </h4>
            <i class="fa-solid fa-money-check-dollar"></i>
            <h5 class="text"><?php echo $totalPendapatan;?></h5>
        </div>
        <div class="stock">
            <h4>stock </h4>
            <i class="fa-solid fa-boxes-stacked"></i>
            <h5 class="text"><?php echo $stock;?></h5>
        </div>
    </div>
</body>
</html>