<?php
session_start();
if(isset($_SESSION['gs_userid'])){
  $uid = $_SESSION['gs_userid'];
  $sid = (int)$_POST['shopId'];
  require_once("funcs/functions.php");
  $q = "select * from shopdetails where CID=$uid and ShopID=$sid";
  $res = mysql_query($q);
  if(mysql_num_rows($res) > 0){
    $addList = $_POST['addList'];
    $expList = explode("--",$addList);
    
    for($i=0;$i<(count($expList)-1);$i++){
      $subId = $expList[$i];
      $price = $_POST['myprice'.$subId];
      $avail = $_POST['avail'.$subId];
      $query = "insert into shopitems (ShopID,SubItemID,Price,Availability) values ($sid, $subId, $price, $avail)";
      mysql_query($query);
    }
    $_SESSION['gs_shopitems_stat'] = "Items have been added successfully!";
    header("location: store.php?sid=".$sid);
  }else{
    showMessage("Forbidden! You are not previlaged to access this information");
  }
}else{
  header("location: index.php");
}


?>