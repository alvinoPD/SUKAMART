<?php
include '../database/config.php';

$id_produk = (int) $_POST['id_produk'];
$nama_produk = $_POST['nama_produk'];
$jumlah = (int) $_POST['jumlah'];
$harga = (int) $_POST['harga'];

$total = $harga * $jumlah;

if($jumlah > 1){

    mysqli_query($db,"INSERT INTO pesanan_ganda (nama_produk, kuantitas, harga)
    VALUES ('$nama_produk','$jumlah','$total')");

}else{

    mysqli_query($db,"INSERT INTO pesanan_tunggal (nama_produk, kuantitas, harga)
    VALUES ('$nama_produk','$jumlah','$total')");

}

header("Location: ../dashboard-user/beranda-user.php");
?>