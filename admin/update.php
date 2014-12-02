<?php
session_start();
if(isset($_SESSION['gs_admin'])){
  $aid = $_SESSION['gs_admin'];
}else{
  $aid = "";
  header("location: index.php");
}

$iid = $_POST['itemID'];
$ival = $_POST['itemVal'];
$attr = $_POST['attr'];
$table = $_POST['table'];

require_once("../funcs/functions.php");

if($table == "items"){
  $temp = "ItemID";
}else{
  $temp = "SubItemID";
}
$q = "update $table set $attr='$ival' where $temp='$iid'";
$res = mysql_query($q) or die("<div style='color: red;'>Error: ".$q."</div>");
echo "<div>Updated table ".$table.", attribute '".$attr."' changed to '".$ival."'</div>";

?>