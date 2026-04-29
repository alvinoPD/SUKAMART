<?php 
session_start();
include '../database/config.php'; 

// Redirect dihilangkan sesuai permintaan user, 
// agar tetap bisa membuka halaman login meskipun sudah login.

$error = '';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi input
    if(empty($username) || empty($password)){
        $error = "Username dan password harus diisi!";
    } else {
        // Prepared statement untuk mencegah SQL injection
        $stmt = $db->prepare("SELECT * FROM users WHERE nama = ? OR email = ?");
        if($stmt){
            $stmt->bind_param("ss", $username, $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                $data = $result->fetch_assoc();
                
                // Mendukung password_verify (hashed) atau fallback teks biasa (untuk data lama)
                if(password_verify($password, $data['password']) || $password === $data['password']){
                    $_SESSION['id'] = $data['id'];
                    $_SESSION['username'] = $data['nama'];
                    $_SESSION['role'] = $data['role'];

                    if($data['role'] == "admin" || $data['role'] == "penjual"){
                        header("Location: /SUKAMART/dashboard-admin/beranda-admin.php");
                        exit();
                    } else {
                        header("Location: /SUKAMART/dashboard-user/beranda-user.php");
                        exit();
                    }
                } else {
                    $error = "Password salah!";
                }
            } else {
                $error = "Username tidak ditemukan!";
            }
            $stmt->close();
        } else {
            $error = "Terjadi kesalahan sistem.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SUKAMART</title>
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
        <h2>Selamat Datang Kembali</h2>
        <p>Belum punya akun? <a href="/SUKAMART/login/register.php">Daftar di sini</a></p>
    </div>

    <div class="auth-container">
        <?php if($error != ''): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/SUKAMART/login/login.php">
            <div class="input-group">
                <label for="username">Username / Email <span>*</span></label>
                <div class="input-wrapper">
                    <input type="text" id="username" name="username" placeholder="" required>
                </div>
            </div>

            <div class="input-group">
                <label for="password">Password <span>*</span></label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" placeholder="" required>
                    <i class="fa-solid fa-eye-slash" id="togglePassword"></i>
                </div>
            </div>

            <div class="extra-links">
                <label>
                    <input type="checkbox" name="remember"> Ingat saya
                </label>
            </div>

            <button type="submit" name="login" class="btn-primary">Masuk</button>
        </form>
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
