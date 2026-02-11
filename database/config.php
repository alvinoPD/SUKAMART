<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "sukamart";

$db = mysqli_connect($server,$username,$password,$database);

if($db == TRUE){
    // echo "berhasil";

}else {
    // echo"gagal";
    die;
}
?>