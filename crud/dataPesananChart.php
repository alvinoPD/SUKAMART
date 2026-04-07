<?php
include '../database/config.php';

header('Content-Type: application/json');

$query = mysqli_query($db,"SELECT
(SELECT COUNT(*) FROM pesanan_tunggal) +
(SELECT COUNT(*) FROM pesanan_ganda) AS total_pesanan");

$data = mysqli_fetch_assoc($query);

echo json_encode($data);
