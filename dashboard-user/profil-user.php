<?php
include '../database/config.php';
include '../part/nav-user.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/profiluser.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <img src="profile.jpg" class="profile-img">
        <h1>nama profil pembeli</h1>

        <a href="#" class="btn full">Riwayat pesanan</a>

        <div class="grid">
            <a href="#" class="btn">Mulai Jual</a>
            <a href="#" class="btn">Terakhir dilihat</a>
            <a href="#" class="btn">Favorit saya</a>
            <a href="#" class="btn">Tentang saya</a>
        </div>
    </div>

    <footer>
        <p>Suka mart</p>
        <p>By Kelompok ....<p>
    </footer>

</body>
</html>