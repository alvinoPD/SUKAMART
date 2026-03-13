<!-- <?php
include "../database/config.php";

$query = mysqli_query($db,"SELECT * FROM pesanan_ganda, pesanan_tunggal,produk");

$data = mysqli_fetch_assoc($query)


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
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
    if($data['jumlah_total'] > 1){
    while($data = mysqli_fetch_assoc($query)){

    
    ?>
    <tr>
      <th scope="row">1</th>
      <td><?$data['']?></td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <?php}?>
    <?php}?>
  </tbody>
</table>
</body>
</html> -->