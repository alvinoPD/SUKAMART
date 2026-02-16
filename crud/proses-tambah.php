<?php
include '../database/config.php';
include '../part/nav.php';

if($_SERVER["REQUEST_METHOD"]=='POST' ){
     $nama = $_POST['nama'];
     $harga = $_POST['harga'];
     $deskripsi = $_POST['deskripsi'];

     $namaFile = $_FILES['foto']['name'];
     $tmpFile = $_FILES['foto']['tmp_name'];

     move_uploaded_file($tmpFile,"../src/".$namaFile);

     $query = "INSERT INTO produk (nama, harga, deskripsi, foto) VALUES ('$nama', '$harga', '$deskripsi, '$namaFile')";
     $sql = mysqli_query($db,$query);

     if($sql){
        header("Location:produk.php");
     }else{
        echo "gagal insert";
     }
}
?>