<?php include 'config.php'; ?>

<h2>Login</h2>

<form method="POST">
    Username<br>
    <input type="text" name="username" required><br><br>

    Password<br>
    <input type="password" name="password" required><br><br>

    <button name="login">Login</button>
</form>

<p>Belum punya akun? <a href="register.php">Register</a></p>

<?php
if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $cek = mysqli_query($conn,
        "SELECT * FROM user 
        WHERE username='$username' 
        AND password='$password'"
    );

    if(mysqli_num_rows($cek)>0){

        $data = mysqli_fetch_assoc($cek);

        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        if($data['role']=="admin"){
            echo "Login admin berhasil";
            // nanti arahkan ke dashboard admin
            // header("Location: admin.php");
        }else{
            echo "Login pembeli berhasil";
            // nanti arahkan ke halaman pembeli
            // header("Location: beranda.php");
        }

    }else{
        echo "Username atau password salah";
    }
}
?>
