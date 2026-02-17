<?php
include '../database/config.php';
include '../part/nav.php';

$query = mysqli_query($db,"SELECT * FROM produk");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
<?php while($data = mysqli_fetch_assoc($query)) { ?>
    
    <div class="produk">
        <img src="../src/<?= $data['image']; ?>" width="120">

        <h3><?= $data['nama']; ?></h3>
        <p>Rp <?= number_format($data['harga']); ?></p>
        <p><?= $data['deskripsi']; ?></p>
        <p>Stock: <?= $data['stok']; ?></p>
    </div>

<?php } ?>
</div>
</body>
</html>