<?php
session_start();
unset($_SESSION['gs_userid']);
header("location: index.php");
?>