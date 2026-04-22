<?php
session_start();

// go
include '../database/config.php';
git
$uid = (int)$_SESSION['id'];
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
            $q = mysqli_query($db, "SELECT SUM(kuantitas) as total FROM pesanan_ganda WHERE id_pembeli = $uid");
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

    <!-- Grid Produk -->
    <main class="main-content">
        <?php
        $where = "WHERE 1=1";
        if ($cat_aktif != 'all') {
            $cat_aktif_int = (int)$cat_aktif;
            $where .= " AND kategori_id = $cat_aktif_int";
        }
        if (!empty($search)) {
            $search_safe = mysqli_real_escape_string($db, $search);
            $where .= " AND (nama LIKE '%$search_safe%' OR deskripsi LIKE '%$search_safe%')";
        }

        $q_produk = mysqli_query($db, "SELECT * FROM produk $where ORDER BY id DESC");
        $jumlah = mysqli_num_rows($q_produk);
        ?>

        <?php if ($jumlah == 0): ?>
            <div class="empty-state">
                <i class="fa-solid fa-box-open"></i>
                <p>Produk tidak ditemukan.</p>
            </div>
        <?php else: ?>
        <div class="product-grid">
            <?php while ($p = mysqli_fetch_assoc($q_produk)): ?>
            <div class="product-card">
                <div class="product-img-wrap">
                    <img src="../uploads/<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['nama']); ?>">
                </div>
                <div class="product-info">
                    <div class="product-name"><?php echo htmlspecialchars($p['nama']); ?></div>
                    <div class="product-price">Rp <?php echo number_format($p['harga'], 0, ',', '.'); ?></div>
                    <div class="product-stock">Stok: <?php echo $p['stok']; ?></div>
                    <div class="product-actions">
                        <form method="POST" action="keranjang-user.php">
                            <input type="hidden" name="id_produk" value="<?php echo $p['id']; ?>">
                            <input type="hidden" name="aksi" value="tambah">
                            <button type="submit" class="btn-cart"><i class="fa-solid fa-cart-plus"></i> Keranjang</button>
                        </form>
                        <form method="POST" action="keranjang-user.php">
                            <input type="hidden" name="id_produk" value="<?php echo $p['id']; ?>">
                            <input type="hidden" name="aksi" value="beli_langsung">
                            <button type="submit" class="btn-buy">Beli</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </main>

</div>

</body>
</html>