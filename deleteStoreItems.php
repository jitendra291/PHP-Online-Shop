<?php
session_start();
if(isset($_SESSION['gs_userid'])){
  $uid = $_SESSION['gs_userid'];
  require_once("funcs/functions.php");
  
  $sid = $_POST['shopId'];
  $delList = $_POST['deleteList'];
  $expList = explode("--",$delList);
  
  for($i=0;$i<(count($expList)-1);$i++){
    $subId = $expList[$i];
    $query = "delete from shopitems where ShopID=$sid and SubItemID=$subId";
    mysql_query($query);
  }

  $_SESSION['gs_shopitems_stat'] = "Items have been deleted successfully!";
  header("location: store.php?sid=".$sid);
  
}else{
  header("location: index.php");
}


?>