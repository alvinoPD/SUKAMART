<?php 
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
        $stmt = $db->prepare("SELECT * FROM users WHERE nama = ?");
        if($stmt){
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0){
                $data = $result->fetch_assoc();
                
                // Mendukung password_verify (hashed) atau fallback teks biasa (untuk data lama)
                if(password_verify($password, $data['password']) || $password === $data['password']){
                    $_SESSION['username'] = $data['username'];
                    $_SESSION['role'] = $data['role'];

                    if($data['role'] == "admin"){
                        header("Location: /SUKAMART/dashboard-admin/index.php");
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
    <link rel="stylesheet" href="/SUKAMART/style/auth.css">
    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Animated Background Container -->
    <div id="vanta-bg" style="position: fixed; z-index: -1; top: 0; left: 0; width: 100%; height: 100%;"></div>

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>SUKAMART</h1>
                <p>Masuk ke akun Anda</p>
            </div>
            
            <?php if($error != ''): ?>
                <div class="alert alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="/SUKAMART/login/login.php">
                <div class="input-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <i class="fa-regular fa-user"></i>
                        <input type="text" id="username" name="username" placeholder="Masukkan username" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                    </div>
                </div>

                <button type="submit" name="login" class="btn-primary">Login</button>
            </form>

            <div class="auth-footer">
                <p>Belum punya akun? <a href="/SUKAMART/login/register.php">Register Sekarang</a></p>
            </div>
        </div>
        
        <div class="auth-decoration">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="glass-info">
                <h2>Belanja Mudah & Cepat</h2>
                <p>Temukan produk kebutuhan harianmu hanya di SUKAMART.</p>
            </div>
        </div>
    </div>

    <!-- Vanta.js Scripts for Animated Background -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.waves.min.js"></script>
    <script>
        VANTA.WAVES({
            el: "#vanta-bg",
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: 200.00,
            minWidth: 200.00,
            scale: 1.00,
            scaleMobile: 1.00,
            color: 0x4f46e5, // Primary indigo color
            shininess: 30.00,
            waveHeight: 15.00,
            waveSpeed: 0.80,
            zoom: 0.9
        })
    </script>
</body>
</html>
