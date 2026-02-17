<?php
include '../database/config.php';
include '../part/nav.php';

if($_SERVER["REQUEST_METHOD"]=='POST' ){
     $nama = $_POST['nama'];
     $harga = $_POST['harga'];
     $deskripsi = $_POST['deskripsi'];
     $stock = $_POST['stock'];
     $kategoriId = $_POST['kategoriId'];
     $kategoriNama = $_POST['kategoriNama'];

     $namaFile = $_FILES['foto']['name'];
     $tmpFile = $_FILES['foto']['tmp_name'];

     move_uploaded_file($tmpFile,"../src/".$namaFile);

     $query = "INSERT INTO produk (nama, harga, deskripsi, image, stok, kategori_id, kategori_nama) VALUES ('$nama', '$harga', '$deskripsi', '$namaFile','$stock','$kategoriId','$kategoriNama')";
     $sql = mysqli_query($db,$query);

     if($sql){
        header("Location:../dashboard-admin/produk.php");
     }else{
        echo "Gagal insert: " . mysqli_error($db);
     }
}
?>