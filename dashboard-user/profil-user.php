<?php
session_start();

// Aktifkan kembali setelah login siap
// if (!isset($_SESSION['username']) || $_SESSION['role'] != 'pembeli') {
//     header("Location: ../login/login.php");
//     exit();
// }

include '../database/config.php';

// ✅ Guard: pastikan session id ada, kalau tidak set default 0 supaya tidak error fatal
$uid = isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0;

// Ambil data user
$user = null;
if ($uid > 0) {
    $q = mysqli_query($db, "SELECT * FROM users WHERE id = $uid LIMIT 1");
    $user = mysqli_fetch_assoc($q);
}

// ✅ Fallback data dummy kalau user belum login / belum ada di DB (saat testing)
if (!$user) {
    $user = [
        'nama'     => $_SESSION['username'] ?? 'Guest',
        'email'    => $_SESSION['email']    ?? 'guest@sukamart.id',
        'nomor_hp' => '-',
        'alamat'   => '-',
        'role'     => $_SESSION['role']     ?? 'pembeli',
    ];
}

$pesan = '';
$pesan_type = 'success';

// Update profil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['aksi']) && $_POST['aksi'] == 'update') {
    if ($uid > 0) {
        $nama     = mysqli_real_escape_string($db, trim($_POST['nama']));
        $nomor_hp = mysqli_real_escape_string($db, trim($_POST['nomor_hp']));
        $alamat   = mysqli_real_escape_string($db, trim($_POST['alamat']));

        // Validasi tidak kosong
        if (empty($nama)) {
            $pesan = 'Nama tidak boleh kosong.';
            $pesan_type = 'error';
        } else {
            $ok = mysqli_query($db, "UPDATE users SET nama='$nama', nomor_hp='$nomor_hp', alamat='$alamat' WHERE id=$uid");
            if ($ok) {
                $_SESSION['username'] = $nama;
                $pesan = 'Profil berhasil diperbarui!';

                // Refresh data
                $q = mysqli_query($db, "SELECT * FROM users WHERE id = $uid LIMIT 1");
                $user = mysqli_fetch_assoc($q);
            } else {
                $pesan = 'Gagal menyimpan. Coba lagi.';
                $pesan_type = 'error';
            }
        }
    } else {
        $pesan = 'Sesi tidak valid. Silakan login ulang.';
        $pesan_type = 'error';
    }
}

// Ambil jumlah item keranjang untuk badge
$total_cart = 0;
if ($uid > 0) {
    $qc = mysqli_query($db, "SELECT SUM(kuantitas) as total FROM pesanan_ganda WHERE id_pembeli = $uid");
    $rc = mysqli_fetch_assoc($qc);
    $total_cart = $rc['total'] ?? 0;
}

// Inisial nama untuk avatar
$inisial = strtoupper(mb_substr($user['nama'], 0, 1));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - SUKAMART</title>
    <link rel="stylesheet" href="../style/beranda-user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar">
    <div class="nav-logo">
        <a href="beranda-user.php">Suka<span>mart</span></a>
    </div>
    <div class="nav-search" style="visibility:hidden;"></div>
    <div class="nav-icons">
        <a href="keranjang-user.php" class="icon-btn" title="Keranjang">
            <i class="fa-solid fa-cart-shopping"></i>
            <?php if ($total_cart > 0): ?>
                <span class="badge"><?php echo $total_cart; ?></span>
            <?php endif; ?>
        </a>
        <a href="profil-user.php" class="icon-btn active-icon" title="Profil">
            <i class="fa-solid fa-user"></i>
        </a>
    </div>
</nav>

<!-- ===== PROFIL ===== -->
<div class="profil-page">
    <div class="profil-card">

        <!-- Banner -->
        <div class="profil-banner">
            <div class="profil-avatar"><?php echo $inisial; ?></div>
        </div>

        <!-- Body -->
        <div class="profil-body">

            <div class="profil-name"><?php echo htmlspecialchars($user['nama']); ?></div>

            <div class="profil-email">
                <i class="fa-solid fa-envelope"></i>
                <?php echo htmlspecialchars($user['email']); ?>
            </div>

            <div class="profil-role-badge">
                <?php echo ucfirst(htmlspecialchars($user['role'])); ?>
            </div>

            <!-- Notif pesan -->
            <?php if ($pesan): ?>
                <div class="profil-pesan profil-pesan--<?php echo $pesan_type; ?>">
                    <i class="fa-solid <?php echo $pesan_type == 'success' ? 'fa-circle-check' : 'fa-circle-xmark'; ?>"></i>
                    <?php echo htmlspecialchars($pesan); ?>
                </div>
            <?php endif; ?>

            <!-- Info read-only -->
            <div class="profil-info-section">
                <div class="profil-info-row">
                    <span class="info-label">
                        <i class="fa-solid fa-phone"></i> No. HP
                    </span>
                    <span class="info-val">
                        <?php echo htmlspecialchars($user['nomor_hp'] ?: '-'); ?>
                    </span>
                </div>
                <div class="profil-info-row">
                    <span class="info-label">
                        <i class="fa-solid fa-location-dot"></i> Alamat
                    </span>
                    <span class="info-val">
                        <?php echo htmlspecialchars($user['alamat'] ?: '-'); ?>
                    </span>
                </div>
            </div>

            <!-- Form edit (accordion) -->
            <details class="edit-details">
                <summary>Edit Profil</summary>
                <form method="POST" class="profil-form">
                    <input type="hidden" name="aksi" value="update">

                    <div class="form-group">
                        <label for="f-nama">Nama</label>
                        <input id="f-nama" type="text" name="nama"
                               value="<?php echo htmlspecialchars($user['nama']); ?>"
                               placeholder="Nama lengkap" required>
                    </div>

                    <div class="form-group">
                        <label for="f-hp">No. HP</label>
                        <input id="f-hp" type="text" name="nomor_hp"
                               value="<?php echo htmlspecialchars($user['nomor_hp']); ?>"
                               placeholder="08xx-xxxx-xxxx">
                    </div>

                    <div class="form-group">
                        <label for="f-alamat">Alamat</label>
                        <textarea id="f-alamat" name="alamat" rows="3"
                                  placeholder="Jl. Contoh No. 1, Kota"><?php echo htmlspecialchars($user['alamat']); ?></textarea>
                    </div>

                    <button type="submit" class="btn-save">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </form>
            </details>

            <!-- Logout -->
            <a href="../login/logout.php" class="btn-logout">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>

        </div><!-- /profil-body -->
    </div><!-- /profil-card -->
</div><!-- /profil-page -->

</body>
</html>