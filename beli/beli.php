<?php
include '../database/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/beli.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Document</title>
</head>
<body>

<form action="../beli/prosesBeli.php" method="POST">

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
$total = $subtotal;

?>

<nav id="nav">
     <a id="back" href="../dashboard-user/beranda-user.php"><i class="fa-solid fa-arrow-left-long"></i></a>
</nav>

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

            <div id="harga" data-harga="<?= $data['harga']; ?>" class="row">
                <span>Harga produk</span>
                <span>Rp<?= number_format($data['harga']); ?></span>
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


<div id="jumlah">

    <script>
        let harga = <?php echo $data['harga']; ?>;
    </script>

    <button type="button" onclick="tambah()">+</button>
    <h1 id="angka">1</h1>
    <button type="button" onclick="kurang()">-</button>


</div>

<script src="../js/jumlah.js"></script>


<!-- Footer -->
<div class="footer">
    <div class="total-footer">
        <span>Total</span>
        <strong id = "total"><p>Rp</p><?= number_format($total,0,',','.'); ?></strong>
    </div>
    <input type="hidden" name="jumlah" id="jumlahInput" value="1">
    <input type="hidden" name="id_produk" value="<?= $data['id']; ?>">
    <input type="hidden" name="harga" value="<?= $data['harga']; ?>">
    <input type="hidden" name="nama_produk" value="<?= $data['nama']; ?>">

    <button type="submit">Buat Pesanan</button>

</div>

</form>

</body>
</html>
