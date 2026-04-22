<?php
session_start();

// if (!isset($_SESSION['username']) || $_SESSION['role'] != 'pembeli') {
//     header("Location: ../login/login.php");
//     exit();
// }

include '../database/config.php';

$uid = (int)$_SESSION['id'];

// ===== TAMBAH KE KERANJANG =====
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['aksi'])) {
    $id_produk = (int)$_POST['id_produk'];
    $aksi      = $_POST['aksi'];

    if ($aksi == 'tambah' || $aksi == 'beli_langsung') {
        // Cek apakah produk sudah ada di keranjang
        $cek = mysqli_query($db, "SELECT * FROM pesanan_ganda WHERE id_pembeli=$uid AND id_produk=$id_produk");
        if (mysqli_num_rows($cek) > 0) {
            // Update kuantitas
            $row_cek = mysqli_fetch_assoc($cek);
            $q_baru  = $row_cek['kuantitas'] + 1;
            // Ambil harga produk
            $p = mysqli_fetch_assoc(mysqli_query($db, "SELECT harga FROM produk WHERE id=$id_produk"));
            $sub = $p['harga'] * $q_baru;
            mysqli_query($db, "UPDATE pesanan_ganda SET kuantitas=$q_baru, subtotal=$sub WHERE id_pembeli=$uid AND id_produk=$id_produk");
        } else {
            // Insert baru
            $p = mysqli_fetch_assoc(mysqli_query($db, "SELECT harga FROM produk WHERE id=$id_produk"));
            $sub = $p['harga'];
            mysqli_query($db, "INSERT INTO pesanan_ganda (id_pembeli, id_produk, kuantitas, subtotal) VALUES ($uid, $id_produk, 1, $sub)");
        }

        if ($aksi == 'beli_langsung') {
            header("Location: keranjang-user.php");
            exit();
        }
        header("Location: beranda-user.php");
        exit();
    }

    if ($aksi == 'tambah_qty') {
        $id_keranjang = (int)$_POST['id_keranjang'];
        $row = mysqli_fetch_assoc(mysqli_query($db, "SELECT pg.*, p.harga FROM pesanan_ganda pg JOIN produk p ON p.id=pg.id_produk WHERE pg.id=$id_keranjang AND pg.id_pembeli=$uid"));
        if ($row) {
            $q_baru = $row['kuantitas'] + 1;
            $sub    = $row['harga'] * $q_baru;
            mysqli_query($db, "UPDATE pesanan_ganda SET kuantitas=$q_baru, subtotal=$sub WHERE id=$id_keranjang");
        }
    }

    if ($aksi == 'kurang_qty') {
        $id_keranjang = (int)$_POST['id_keranjang'];
        $row = mysqli_fetch_assoc(mysqli_query($db, "SELECT pg.*, p.harga FROM pesanan_ganda pg JOIN produk p ON p.id=pg.id_produk WHERE pg.id=$id_keranjang AND pg.id_pembeli=$uid"));
        if ($row) {
            if ($row['kuantitas'] <= 1) {
                mysqli_query($db, "DELETE FROM pesanan_ganda WHERE id=$id_keranjang AND id_pembeli=$uid");
            } else {
                $q_baru = $row['kuantitas'] - 1;
                $sub    = $row['harga'] * $q_baru;
                mysqli_query($db, "UPDATE pesanan_ganda SET kuantitas=$q_baru, subtotal=$sub WHERE id=$id_keranjang");
            }
        }
    }

    if ($aksi == 'hapus') {
        $id_keranjang = (int)$_POST['id_keranjang'];
        mysqli_query($db, "DELETE FROM pesanan_ganda WHERE id=$id_keranjang AND id_pembeli=$uid");
    }

    header("Location: keranjang-user.php");
    exit();
}

// Ambil isi keranjang
$q_keranjang = mysqli_query($db, "
    SELECT pg.*, p.nama, p.harga, p.image, p.deskripsi
    FROM pesanan_ganda pg
    JOIN produk p ON p.id = pg.id_produk
    WHERE pg.id_pembeli = $uid
");
$items = [];
while ($r = mysqli_fetch_assoc($q_keranjang)) $items[] = $r;

$total = array_sum(array_column($items, 'subtotal'));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - SUKAMART</title>
    <link rel="stylesheet" href="../style/beranda-user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="nav-logo"><a href="beranda-user.php">Suka<span>mart</span></a></div>
    <div class="nav-search" style="visibility:hidden;"></div>
    <div class="nav-icons">
        <a href="keranjang-user.php" class="icon-btn active-icon" title="Keranjang">
            <i class="fa-solid fa-cart-shopping"></i>
            <?php if (count($items) > 0): ?>
                <span class="badge"><?php echo array_sum(array_column($items,'kuantitas')); ?></span>
            <?php endif; ?>
        </a>
        <a href="profil-user.php" class="icon-btn" title="Profil">
            <i class="fa-solid fa-user"></i>
        </a>
    </div>
</nav>

<div class="cart-page">
    <div class="cart-header-title">
        <a href="beranda-user.php" class="back-link"><i class="fa-solid fa-arrow-left"></i></a>
        <h2>Keranjang Belanja</h2>
    </div>

    <?php if (empty($items)): ?>
    <div class="empty-state">
        <i class="fa-solid fa-cart-shopping"></i>
        <p>Keranjang kamu masih kosong.</p>
        <a href="beranda-user.php" class="btn-back-shop">Mulai Belanja</a>
    </div>
    <?php else: ?>

    <div class="cart-layout">
        <div class="cart-list">
            <?php foreach ($items as $item): ?>
            <div class="cart-item-card">
                <img src="../uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['nama']); ?>">
                <div class="cart-item-detail">
                    <div class="cart-item-name"><?php echo htmlspecialchars($item['nama']); ?></div>
                    <div class="cart-item-desc"><?php echo htmlspecialchars(mb_substr($item['deskripsi'],0,80)); ?>...</div>
                    <div class="cart-item-price">Rp <?php echo number_format($item['harga'],0,',','.'); ?></div>
                    <div class="cart-item-actions">
                        <div class="qty-ctrl">
                            <form method="POST">
                                <input type="hidden" name="id_keranjang" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="id_produk" value="<?php echo $item['id_produk']; ?>">
                                <input type="hidden" name="aksi" value="kurang_qty">
                                <button type="submit" class="qty-btn">&#8722;</button>
                            </form>
                            <span class="qty-val"><?php echo $item['kuantitas']; ?></span>
                            <form method="POST">
                                <input type="hidden" name="id_keranjang" value="<?php echo $item['id']; ?>">
                                <input type="hidden" name="id_produk" value="<?php echo $item['id_produk']; ?>">
                                <input type="hidden" name="aksi" value="tambah_qty">
                                <button type="submit" class="qty-btn">+</button>
                            </form>
                        </div>
                        <div class="cart-item-subtotal">Subtotal: <strong>Rp <?php echo number_format($item['subtotal'],0,',','.'); ?></strong></div>
                        <form method="POST">
                            <input type="hidden" name="id_keranjang" value="<?php echo $item['id']; ?>">
                            <input type="hidden" name="id_produk" value="<?php echo $item['id_produk']; ?>">
                            <input type="hidden" name="aksi" value="hapus">
                            <button type="submit" class="btn-hapus"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-summary-box">
            <h3>Ringkasan Pesanan</h3>
            <div class="summary-row">
                <span>Total (<?php echo array_sum(array_column($items,'kuantitas')); ?> item)</span>
                <strong>Rp <?php echo number_format($total,0,',','.'); ?></strong>
            </div>
            <div class="summary-row">
                <span>Ongkir</span>
                <span class="free-ship">Gratis</span>
            </div>
            <div class="summary-total">
                <span>Total Bayar</span>
                <strong>Rp <?php echo number_format($total,0,',','.'); ?></strong>
            </div>
            <a href="#" class="btn-checkout">Bayar Sekarang</a>
        </div>
    </div>
    <?php endif; ?>
</div>

</body>
</html>

