<?php
session_start();

include '../database/config.php';

$uid = (int)$_SESSION['id'];

// Ambil data user
$q_user = mysqli_query($db, "SELECT * FROM users WHERE id = $uid");
$user = mysqli_fetch_assoc($q_user);
$nama_user = $user['nama'];

// ===== AKSI =====
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['aksi'])) {

    $aksi = $_POST['aksi'];

    // ================= TAMBAH / BELI =================
    if ($aksi == 'tambah' || $aksi == 'beli_langsung') {

        $nama_produk = $_POST['nama_produk'];
        $harga       = $_POST['harga'];

        $cek = mysqli_query($db, "
            SELECT * FROM pesanan_ganda 
            WHERE nama_pembeli='$nama_user' AND nama_produk='$nama_produk'
        ");

        if (mysqli_num_rows($cek) > 0) {
            $row = mysqli_fetch_assoc($cek);
            $q_baru = $row['kuantitas'] + 1;

            mysqli_query($db, "
                UPDATE pesanan_ganda 
                SET kuantitas=$q_baru 
                WHERE nama_pembeli='$nama_user' AND nama_produk='$nama_produk'
            ");
        } else {
            mysqli_query($db, "
                INSERT INTO pesanan_ganda (nama_pembeli, nama_produk, kuantitas, harga)
                VALUES ('$nama_user','$nama_produk',1,'$harga')
            ");
        }

        // beli langsung → masuk pesanan_tunggal
        if ($aksi == 'beli_langsung') {
            mysqli_query($db, "
                INSERT INTO pesanan_tunggal (nama_pembeli, kuantitas, harga, nama_produk)
                VALUES ('$nama_user',1,'$harga','$nama_produk')
            ");

            header("Location: keranjang-user.php");
            exit();
        }

        header("Location: beranda-user.php");
        exit();
    }

    // ================= TAMBAH QTY =================
    if ($aksi == 'tambah_qty') {
        $id = (int)$_POST['id_keranjang'];

        $row = mysqli_fetch_assoc(mysqli_query($db, "
            SELECT * FROM pesanan_ganda WHERE id=$id
        "));

        if ($row) {
            $q_baru = $row['kuantitas'] + 1;

            mysqli_query($db, "
                UPDATE pesanan_ganda SET kuantitas=$q_baru WHERE id=$id
            ");
        }
    }

    // ================= KURANG QTY =================
    if ($aksi == 'kurang_qty') {
        $id = (int)$_POST['id_keranjang'];

        $row = mysqli_fetch_assoc(mysqli_query($db, "
            SELECT * FROM pesanan_ganda WHERE id=$id
        "));

        if ($row) {
            if ($row['kuantitas'] <= 1) {
                mysqli_query($db, "DELETE FROM pesanan_ganda WHERE id=$id");
            } else {
                $q_baru = $row['kuantitas'] - 1;

                mysqli_query($db, "
                    UPDATE pesanan_ganda SET kuantitas=$q_baru WHERE id=$id
                ");
            }
        }
    }

    // ================= HAPUS =================
    if ($aksi == 'hapus') {
        $id = (int)$_POST['id_keranjang'];
        mysqli_query($db, "DELETE FROM pesanan_ganda WHERE id=$id");
    }

    header("Location: keranjang-user.php");
    exit();
}

// ===== AMBIL DATA =====
$q_keranjang = mysqli_query($db, "
    SELECT * FROM pesanan_ganda 
    WHERE nama_pembeli='$nama_user'
");

$items = [];
while ($r = mysqli_fetch_assoc($q_keranjang)) $items[] = $r;

// hitung total manual
$total = 0;
foreach ($items as $item) {
    $total += $item['harga'] * $item['kuantitas'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang</title>
    <link rel="stylesheet" href="../style/beranda-user.css">
</head>
<body>

<h2>Keranjang Belanja</h2>

<?php if (empty($items)): ?>
    <p>Keranjang kosong</p>
<?php else: ?>

    <?php foreach ($items as $item): ?>
        <div style="border:1px solid #ccc; padding:10px; margin:10px;">
            <h4><?php echo $item['nama_produk']; ?></h4>
            <p>Harga: Rp <?php echo number_format($item['harga'],0,',','.'); ?></p>
            <p>Qty: <?php echo $item['kuantitas']; ?></p>

            <form method="POST">
                <input type="hidden" name="id_keranjang" value="<?php echo $item['id']; ?>">
                <input type="hidden" name="aksi" value="kurang_qty">
                <button>-</button>
            </form>

            <form method="POST">
                <input type="hidden" name="id_keranjang" value="<?php echo $item['id']; ?>">
                <input type="hidden" name="aksi" value="tambah_qty">
                <button>+</button>
            </form>

            <form method="POST">
                <input type="hidden" name="id_keranjang" value="<?php echo $item['id']; ?>">
                <input type="hidden" name="aksi" value="hapus">
                <button>Hapus</button>
            </form>

            <p>Subtotal: Rp <?php echo number_format($item['harga'] * $item['kuantitas'],0,',','.'); ?></p>
        </div>
    <?php endforeach; ?>

    <h3>Total: Rp <?php echo number_format($total,0,',','.'); ?></h3>

<?php endif; ?>

</body>
</html>