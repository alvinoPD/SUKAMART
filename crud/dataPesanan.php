 <?php
include "../database/config.php";

$query = mysqli_query($db,"
    SELECT id, id_pembeli, subtotal AS total, 'ganda' AS tipe
    FROM pesanan_ganda
    UNION ALL
    SELECT id, id_pembeli, jumlah_total AS total, 'tunggal' AS tipe
    FROM pesanan_tunggal
");


?>

     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<body>
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
  <td><?= $data['id_pembeli']; ?></td>
  <td><?= $data['total']; ?></td>
  <td><?= $data['tipe']; ?></td>
</tr>
<?php } ?>
  
  </tbody>
</table>
</body>