<?php
include '../database/config.php';

if(!isset($_GET['id'])){
    die('masuk lewat tombol');
}

$id = $_GET['id'];

$query = mysqli_query($db, " DELETE FROM produk WHERE id='$id'");

if($query){
    header("Location:../dashboard-admin/produk.php");
    exit;
}else{
    echo"gagal hapus".mysqli_error($db);
}
?>
?>