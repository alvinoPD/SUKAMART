<?php include 'config.php'; ?>

<h2>Register Pembeli</h2>

<form method="POST">
    Username<br>
    <input type="text" name="username" required><br><br>

    Password<br>
    <input type="password" name="password" required><br><br>

    <button name="register">Daftar</button>
</form>

<p>Sudah punya akun? <a href="login.php">Login</a></p>

<?php
if(isset($_POST['register'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $cek = mysqli_query($conn,
        "SELECT * FROM user WHERE username='$username'"
    );

    if(mysqli_num_rows($cek)>0){
        echo "Username sudah dipakai";
    }else{

        mysqli_query($conn,
            "INSERT INTO user VALUES(
                '',
                '$username',
                '$password',
                'pembeli'
            )"
        );

        echo "Register berhasil, silakan login";
    }
}
?>
