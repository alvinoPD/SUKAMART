<?php
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'pembeli') {
    header("Location: ./login/login.php");
    exit();
 }
?>