<?php
include '../database/config.php';

if(!isset($_GET['id'])){
    die('masuk lewat tombol');
}

$id = $_GET['id'];

$query = mysqli_query($db, "SELECT * FROM produk WHERE id='$id'");


if (!$query) {
   die("Query Error: " . mysqli_error($db));
}

$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="proses-edit.php" method="POST" enctype="multipart/form-data" class="form-edit">

    <!-- ID hidden (penting buat update) -->
    <input type="hidden" name="id" value="<?= $data['id']; ?>">

    <!-- FOTO PRODUK -->
    <div class="form-group">
        <label>Foto Produk</label><br>
        <img src="../src/<?= $data['image']; ?>" width="120"><br><br>
        <input type="file" name="image">
    </div>

    <br>

    <!-- NAMA -->
    <div class="form-group">
        <label>Nama Produk</label><br>
        <input type="text" name="nama" value="<?= $data['nama']; ?>" required>
    </div>

    <br>

    <!-- DESKRIPSI -->
    <div class="form-group">
        <label>Deskripsi</label><br>
        <textarea name="deskripsi" rows="4"><?= $data['deskripsi']; ?></textarea>
    </div>

    <br>

    <!-- HARGA -->
    <div class="form-group">
        <label>Harga</label><br>
        <input type="number" name="harga" value="<?= $data['harga']; ?>" required>
    </div>

    <br>

    <!-- STOK -->
    <div class="form-group">
        <label>Stok</label><br>
        <input type="number" name="stok" value="<?= $data['stok']; ?>" required>
    </div>

    <br>

    <!-- KATEGORI ID -->
    <div class="form-group">
        <label>Kategori ID</label><br>
        <input type="text" name="kategoriId" value="<?= $data['kategori_id']; ?>">
    </div>

    <br>

    <!-- KATEGORI NAMA -->
    <div class="form-group">
        <label>Kategori Nama</label><br>
        <input type="text" name="kategoriNama" value="<?= $data['kategori_nama']; ?>">
    </div>

    <br>

    <button type="submit">Update Produk</button>
</form>

</body>
</html>