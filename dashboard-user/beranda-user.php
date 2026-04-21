<?php
session_start();

// Cek jika tidak ada session username (belum login) atau role BUKAN pembeli
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'pembeli') {
    // Arahkan kembali ke halaman login
    header("Location: ../login/login.php");
    exit();
}

include '../database/config.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - SUKAMART</title>
</head>
<body>
    <nav id = "nav">
        
    </nav>

    <main>
    <?php
    include '../crud/read-user.php';
    ?>
    </main>
    <p><a href="../login/logout.php">Logout</a></p>
</body>
</html>