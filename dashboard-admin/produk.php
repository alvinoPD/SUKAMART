<?php
include '../database/config.php';


?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/sidebar.css">
    <link rel="stylesheet" href="../style/produk.css">
</head>
<body>
    <div id="flex-container">
        <?php
        include '../part/sidebar.php';
        ?>
        <main class = "main">
            <nav>
                <div class="text1">
                    <h3 class="text">Produk anda</h3>
                    

                </div>
            </nav>
            <div class ="isi">
                <?php
                include '../crud/read-admin.php';
                ?>
            </div>
            <div class="tambah">
                <button class= "botton-tambah"><a href="../crud/tambah.php"><h1>+</h1></a></button>
            </div>
        </main>
    </div>
</body>
</html>