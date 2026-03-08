<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/profil-admin.css">
<link rel="stylesheet" href="../style/sidebar.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>
     <aside id="sidebar">
        <h2>SUKAMART</h2>
        <hr>
        <div class = "head-home">
            <div class="beranda">
                <div class="home">
                    <i class="fa-solid fa-house" id="icon-home"></i>
                    <p>Home</p>
                </div>
             <a href="../dashboard-admin/beranda-admin.php">Beranda</a>
            </div>
        </div>
        <div class ="head-manage">
            <div class ="manage">
                <i class="fa-brands fa-buffer" id="icon-manage"></i>
                <p>Menejemen</p>
            </div>
            <div class="profil">
                <a href="../dashboard-admin/profil.php">Profil</a>
            </div>

            <div class="produk-side">
                <a href="../dashboard-admin/produk.php">Produk</a>
            </div>

        </div>
        <div class ="akun-head">
            <div class= "akun">
                <i class="fa-solid fa-user" id ="icon-akun"></i>
                <p>Akun</p>
            </div>
            <div class="logout">
                <a href="#">Logout</a>
            </div>
        </div>
    </aside>
</body>
</html>