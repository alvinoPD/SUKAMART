<?php 
include '../database/config.php';
include '../part/nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Tambahkan produk anda</h1>

    <form action = "../crud/proses-tambah.php"  method = "POST" class="input" enctype="multipart/form-data" > 
        <div class = "foto">
            <label class = "foto">tambahkan foto produk</label><br>
            <input type = "file" class = "foto" name = "foto" id ="foto" placeholder = "Masukan foto">
        </div><br>
        <div class = "nama">
            <label class = "nama">Nama</label><br>
            <input type = "text" class = "nama" name = "nama" id ="nama" placeholder = "Masukan nama">
        </div><br>
        <div class = "harga">
            <label class = "harga">Harga</label><br>
            <input type = "text" class = "harga" name = "harga" id ="harga" placeholder = "Masukan harga">
        </div><br>
        <div class = "deskripsi">
            <label class = "deskripsi">Deskripsi</label><br>
            <input type = "text" class = "deskripsi" name = "deskripsi" id ="deskripsi" placeholder = "Masukan deskripsi produk">
        </div>
            <br>
        <button type = "submit" name = "submit">Upload</button>
    </form>

    

</body>
</html>