<?php
session_start();
session_unset();
session_destroy();
header("Location: /SUKAMART/login/login.php");
exit();
?>
