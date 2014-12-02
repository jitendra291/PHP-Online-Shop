<?php
require_once('funcs/functions.php');
//$con = connectDB();

session_start();

$subitems = mres_ss($_POST['subitems']);
$expc = explode("-",$subitems);
$echoString = "";
for($i=0;$i<count($expc);$i++){
  $subid = $expc[$i];
  $res = mysql_query("select ItemID,SubItemName,Type,Price,Quantity from subitems where SubItemID='$subid'");
  $row = mysql_fetch_array($res);
  $itemId = $row['ItemID'];
  $res1 = mysql_query("select count(*) as ItemCount from subitems where ItemID = $itemId");
  $row1 = mysql_fetch_array($res1);
  $itemCount = $row1['ItemCount'];
  $subItemName = $row['SubItemName'];
  $type = $row['Type'];
  $price = $row['Price'];
  $quantity = $row['Quantity'];
  $res = mysql_query("select ItemName from items where ItemID='$itemId'");
  $row = mysql_fetch_array($res);
  $itemName = $row['ItemName'];
  if($type == "P"){
    $cartString = "i->".$subid."->1->".$subItemName."->".$type."->".$quantity."->".$price."->".$itemName;
  }else{
    $cartString = "i->".$subid."->0->".$subItemName."->".$type."->".$quantity."->".$price."->".$itemName;
  }
  if(isset($_SESSION['gs_cart'])){
    $_SESSION['gs_cart'] = $_SESSION['gs_cart'].";".$cartString;
  }else{
    $_SESSION['gs_cart'] = $cartString;
  }
  $popFactor = 1 + (0.01 * $itemCount);
  $res = mysql_query("update subitems set Popularity = Popularity*$popFactor where SubItemID='$subid'");
  calculatePopularities($subid);
}

//closeDB($con);
echo $_SESSION['gs_cart'];

?>