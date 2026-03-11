<?php 
include '../database/config.php'; 

// Redirect dihilangkan sesuai permintaan user, 
// agar tetap bisa membuka halaman register meskipun sudah login.

$error = '';
$success = '';

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username) || empty($password)){
        $error = "Semua kolom harus diisi!";
    } else {
        // Cek apakah username sudah ada
        $stmt_cek = $conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt_cek->bind_param("s", $username);
        $stmt_cek->execute();
        $result_cek = $stmt_cek->get_result();

        if($result_cek->num_rows > 0){
            $error = "Username sudah dipakai, silakan gunakan yang lain.";
        } else {
            // Hash password untuk keamanan
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt_insert = $conn->prepare("INSERT INTO user (username, password, role) VALUES (?, ?, 'pembeli')");
            $stmt_insert->bind_param("ss", $username, $hashed_password);
            
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
    <link rel="stylesheet" href="/SUKAMART/style/auth.css">
    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Animated Background Container -->
    <div id="vanta-bg" style="position: fixed; z-index: -1; top: 0; left: 0; width: 100%; height: 100%;"></div>

    <div class="auth-container reverse">
        <div class="auth-card">
            <div class="auth-header">
                <h1>SUKAMART</h1>
                <p>Buat akun baru</p>
            </div>
            
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
                        <label for="username">Username</label>
                        <div class="input-wrapper">
                            <i class="fa-regular fa-user"></i>
                            <input type="text" id="username" name="username" placeholder="Pilih username" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" id="password" name="password" placeholder="Buat password" required>
                        </div>
                    </div>

                    <button type="submit" name="register" class="btn-primary">Daftar Sekarang</button>
                </form>
            <?php endif; ?>

            <div class="auth-footer">
                <p>Sudah punya akun? <a href="/SUKAMART/login/login.php">Masuk di sini</a></p>
            </div>
        </div>
        
        <div class="auth-decoration">
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
            <div class="glass-info">
                <h2>Ayo Bergabung!</h2>
                <p>Dapatkan berbagai promo menarik khusus member baru.</p>
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
