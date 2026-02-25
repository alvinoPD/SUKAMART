<?php
session_start();

$conn = mysqli_connect("localhost","root","","toko_online2");

if(!$conn){
    die("Koneksi database gagal");
}
?>
