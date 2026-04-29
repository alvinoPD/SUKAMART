<?php 
include '../database/config.php'; 

// Redirect dihilangkan sesuai permintaan user, 
// agar tetap bisa membuka halaman register meskipun sudah login.

$error = '';
$success = '';

if(isset($_POST['register'])){
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nomor_hp = $_POST['nomor_hp'];
    $alamat = $_POST['alamat'];
    $password = $_POST['password'];

    if(empty($nama) || empty($email) || empty($nomor_hp) || empty($alamat) || empty($password)){
        $error = "Semua kolom harus diisi!";
    } else {
        // Cek apakah nama atau email sudah ada
        $stmt_cek = $db->prepare("SELECT * FROM users WHERE nama = ? OR email = ?");
        $stmt_cek->bind_param("ss", $nama, $email);
        $stmt_cek->execute();
        $result_cek = $stmt_cek->get_result();

        if($result_cek->num_rows > 0){
            $error = "Nama atau Email sudah dipakai, silakan gunakan yang lain.";
        } else {
            // Hash password untuk keamanan
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt_insert = $db->prepare("INSERT INTO users (nama, email, nomor_hp, alamat, password, role) VALUES (?, ?, ?, ?, ?, 'pembeli')");
            $stmt_insert->bind_param("sssss", $nama, $email, $nomor_hp, $alamat, $hashed_password);
            
            if($stmt_insert->execute()){
                $success = "Register berhasil! Silakan <a href='/SUKAMART/login/login.php'>Login</a>.";
            } else {
                $error = "Terjadi kesalahan sistem saat mendaftar.";
            }
            $stmt_insert->close();
        }
        $stmt_cek->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SUKAMART</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="/SUKAMART/style/auth.css?v=<?php echo time(); ?>">
    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="brand-header">
        <h1><img src="../asset/logo-ungu.png?v=<?php echo time(); ?>" alt="Logo SUKAMART" class="brand-logo"> SUKAMART</h1>
        <h2>Buat akun baru</h2>
        <p>Sudah punya akun? <a href="/SUKAMART/login/login.php">Masuk di sini</a></p>
    </div>

    <div class="auth-container">
        <?php if($error != ''): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if($success != ''): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-check-circle"></i>
                <?php echo $success; ?>
            </div>
        <?php else: ?>
            <form method="POST" action="/SUKAMART/login/register.php">
                <div class="input-group">
                    <label for="nama">Nama <span>*</span></label>
                    <div class="input-wrapper">
                        <input type="text" id="nama" name="nama" placeholder="" required>
                        <i class="fa-regular fa-user"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label for="email">Email <span>*</span></label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" placeholder="" required>
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label for="nomor_hp">Nomor Handphone <span>*</span></label>
                    <div class="input-wrapper">
                        <input type="text" id="nomor_hp" name="nomor_hp" placeholder="" required>
                        <i class="fa-solid fa-phone"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label for="alamat">Alamat Lengkap <span>*</span></label>
                    <div class="input-wrapper">
                        <input type="text" id="alamat" name="alamat" placeholder="" required>
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label for="password">Password <span>*</span></label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="" required>
                        <i class="fa-solid fa-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
                    </div>
                </div>

                <button type="submit" name="register" class="btn-primary">Daftar Sekarang</button>
            </form>


        <?php endif; ?>
    </div>

    <div class="footer-text">
        © Hak cipta dilindungi oleh SUKAMART.
    </div>

    <!-- Script to toggle password visibility -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // Toggle the eye / eye-slash icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
