<?php
include '../database/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "../style/beli.css">
    <title>Document</title>
</head>
<body>
    <form action = "../beli/prosesBeli.php">
        <?php

// ambil id dari URL
$id = $_GET['id'] ?? 0;

// query ambil produk
$query = mysqli_query($db, "SELECT * FROM produk WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

// validasi
if (!$data) {
    die("Produk tidak ditemukan");
}

// contoh hitung total
$subtotal = $data['harga'];
$layanan = 1500;
$total = $subtotal + $layanan;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <!-- Produk -->
    <div class="produk">
        <div class="img-box">
            <img src="../src/<?= $data['image']; ?>" alt="produk">
        </div>
        <div class="info">
            <h3><?= $data['nama']; ?></h3>
            <span class="badge">Pengembalian barang gratis</span>
            <span class="badge">100% Asli</span>
        </div>
    </div>

    <hr>

    <div class="content">

        <!-- Ringkasan -->
        <div class="ringkasan">
            <h3>Ringkasan Pesanan</h3>

            <div class="row">
                <span>Harga produk</span>
                <span>Rp<?= number_format($data['harga']); ?></span>
            </div>

            <div class="row">
                <span>Biaya Layanan</span>
                <span>Rp<?= number_format($layanan,0,',','.'); ?></span>
            </div>


            <div class="row total">
                <span>Total</span>
                <span>Rp<?= number_format($total,0,',','.'); ?></span>
            </div>
        </div>

        <!-- Pembayaran -->
        <div class="pembayaran">
            <h3>Metode Pembayaran</h3>

            <label class="option">
                <input type="radio" name="bayar" checked>
                <span>COD (Bayar di tempat)</span>
            </label>

            <label class="option">
                <input type="radio" name="bayar">
                <span>Transfer akun virtual</span>
            </label>

        </div>

    </div>

</div>

<!-- Footer -->
<div class="footer">
    <div class="total-footer">
        <span>Total</span>
        <strong>Rp<?= number_format($total,0,',','.'); ?></strong>
    </div>
    <button>Buat Pesanan</button>
</div>

</body>
</html>
</body>
</html>