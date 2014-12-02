<?php
session_start();
if(isset($_SESSION['gs_admin'])){
  $aid = $_SESSION['gs_admin'];
}else{
  $aid = "";
  header("location: index.php");
}

$iid = $_POST['itemID'];
$table = $_POST['table'];

require_once("../funcs/functions.php");

if($table == "items"){
  $temp = "ItemID";
}else{
  $temp = "SubItemID";
}
$q = "delete from $table where $temp='$iid'";
$res = mysql_query($q) or die("<div style='color: red;'>Error: ".$q."</div>");
echo "<div>Deleted from '".$table."', element with ID: ".$iid."</div>";


?>