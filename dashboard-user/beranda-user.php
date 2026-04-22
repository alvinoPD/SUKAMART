<?php
session_start();

// if (!isset($_SESSION['username']) || $_SESSION['role'] != 'pembeli') {
//     header("Location: ../login/login.php");
//     exit();
// }

include '../database/config.php';

// ✅ FIX: Pastikan $uid diambil dari session dengan benar
$uid = (int)$_SESSION['id'];
$q_user = mysqli_query($db, "SELECT * FROM users WHERE id = $uid");
$user = mysqli_fetch_assoc($q_user);

$nama_user = $user['nama'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - SUKAMART</title>
    <link rel="stylesheet" href="../style/beranda-user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar">
    <div class="nav-logo">Suka<span>mart</span></div>
    <div class="nav-search">
        <form method="GET" action="">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" placeholder="Cari produk, merek..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
        </form>
    </div>
    <div class="nav-icons">
        <a href="keranjang-user.php" class="icon-btn" title="Keranjang">
            <i class="fa-solid fa-cart-shopping"></i>
            <?php
            // ✅ FIX: Gunakan $uid yang sudah benar di atas
            $q = mysqli_query($db, "
            SELECT 
            (SELECT IFNULL(SUM(kuantitas),0) FROM pesanan_ganda WHERE nama_pembeli = '$nama_user') +
            (SELECT IFNULL(SUM(kuantitas),0) FROM pesanan_tunggal WHERE nama_pembeli = '$nama_user')
            AS total
            ");
            $row = mysqli_fetch_assoc($q);
            $total_cart = $row['total'] ?? 0;
            if ($total_cart > 0): ?>
                <span class="badge"><?php echo $total_cart; ?></span>
            <?php endif; ?>
        </a>
        <a href="profil-user.php" class="icon-btn" title="Profil">
            <i class="fa-solid fa-user"></i>
        </a>
    </div>
</nav>

<!-- ===== BODY ===== -->
<div class="page-body">

    <!-- Sidebar Kategori -->
    <aside class="sidebar-kategori">
        <h4>KATEGORI</h4>
        <?php
        $cat_aktif = $_GET['kategori'] ?? 'all';
        $search    = $_GET['search'] ?? '';

        $q_kat = mysqli_query($db, "SELECT * FROM kategori ORDER BY nama ASC");
        $icons = ['📱','💻','👕','👗','🏠','🎮','❤️','📺','🎧'];
        $i = 0;
        ?>
        <a href="beranda-user.php" class="cat-item <?php echo $cat_aktif == 'all' ? 'active' : ''; ?>">
            <span class="cat-icon">🛒</span> Semua
        </a>
        <?php while ($kat = mysqli_fetch_assoc($q_kat)):
            $active = ($cat_aktif == $kat['id']) ? 'active' : '';
        ?>
        <a href="beranda-user.php?kategori=<?php echo $kat['id']; ?>" class="cat-item <?php echo $active; ?>">
            <span class="cat-icon"><?php echo $icons[$i % count($icons)]; ?></span>
            <?php echo htmlspecialchars($kat['nama']); ?>
        </a>
        <?php $i++; endwhile; ?>
    </aside>

    <main>
        <?php include '../crud/read-user.php';
        
        ?>
    </main>

</div>

</body>
</html>