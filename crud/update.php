<?php
include '../database/config.php';

// if(!isset($_GET['id'])){
//     die('masuk dari tombol');
// }

$id = $_POST['id'];

    $nama = $_POST['nama'];
     $harga = $_POST['harga'];
     $deskripsi = $_POST['deskripsi'];
     $stock = $_POST['stok'];
     $kategoriId = $_POST['kategoriId'];
     $kategoriNama = $_POST['kategoriNama'];

     $namaFile = $_FILES['foto']['name'];
     $tmpFile = $_FILES['foto']['tmp_name'];

     if ($namaFile != '') {

    move_uploaded_file($tmpFile, "../src/".$namaFile);

    $query = "UPDATE produk SET 
        nama='$nama',
        image='$namaFile',
        harga='$harga',
        stok ='$stock',
        kategori_id = '$kategoriId',
        kategori_nama = '$kategoriNama'
        WHERE id='$id'";

} else {

    $query = "UPDATE produk SET 
        nama='$nama',
        harga='$harga',
        stok ='$stock',
        kategori_id = '$kategoriId',
        kategori_nama = '$kategoriNama'
        WHERE id='$id'";
}

$result = mysqli_query($db, $query);
if(!$result){
    die("Query gagal: " . mysqli_error($db));
} else {
    echo "Update berhasil";
}

header("Location: ../dashboard-admin/produk.php");
exit;

?>