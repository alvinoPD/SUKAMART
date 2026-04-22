 <?php
include "../database/config.php";

$query = mysqli_query($db,"
    SELECT id,nama_produk,kuantitas,harga FROM pesanan_tunggal AS total
    UNION ALL
    SELECT id,nama_produk,kuantitas,harga FROM pesanan_ganda AS total
");


?>

     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<body>

  <nav id="nav">
     <a id="back" href="../dashboard-admin/profil.php"><i class="fa-solid fa-arrow-left-long"></i></a>
</nav>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">produk</th>
      <th scope="col">jumlah</th>
      <th scope="col">harga</th>
    </tr>
  </thead>
  <tbody>
    <?php
    while($data = mysqli_fetch_assoc($query)){
?>
<tr>
  <td><?= $data['id']; ?></td>
  <td><?= $data['nama_produk']; ?></td>
  <td><?= $data['kuantitas']; ?></td>
  <td><?= $data['harga']; ?></td>
</tr>
<?php } ?>
  
  </tbody>
</table>
</body>