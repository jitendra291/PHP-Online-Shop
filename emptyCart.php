<?php
session_start();
$_SESSION['gs_cart'] = null;
header("location: index.php");
?>