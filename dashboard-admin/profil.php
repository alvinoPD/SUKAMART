<?php
include '../database/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profil Admin</title>

<link rel="stylesheet" href="../style/profil-admin.css">
<link rel="stylesheet" href="../style/sidebar.css">
<link rel = "stylesheet" href = "../style/profil-admin.css" >

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<div id="page">

<?php include '../part/sidebar.php'; ?>

<main id="main">
<h1>LOGO</h1>
<hr>
<?php
include '../crud/profil-admin.php';
?>

</main>

</div>

</body>
</html>
