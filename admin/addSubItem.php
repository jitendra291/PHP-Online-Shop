<?php
session_start();
if(isset($_SESSION['gs_admin'])){
  $aid = $_SESSION['gs_admin'];
}else{
  $aid = "";
  header("location: index.php");
}

require_once("../funcs/functions.php");

$con = connectDB();
$sin = $_POST['newSubItemName'];
$quan = $_POST['newQuantity'];
$price = $_POST['newPrice'];
$type = $_POST['newType'];
$iid = $_POST['itemid'];

$q = "insert into subitems (ItemID, SubItemName, Quantity, Price, Type) values ('$iid','$sin','$quan','$price','$type')";
$res = mysqli_query($con, $q) or die("Error in query");
header("location: manageItems.php");

closeDB($con);

?>