<?php
session_start();
if(isset($_SESSION['gs_userid'])){
  $uid = $_SESSION['gs_userid'];
  
  if(isset($_GET['oloid'])){
    $cancelID = (int)($_GET['oloid']); 
    require_once('funcs/functions.php');
    //$con = connectDB();
    
    $res = mysql_query("delete from orderlist where OrderID='$cancelID'");
    $res = mysql_query("update orders set Status='6' where OrderID='$cancelID'");
    header("location: myorders.php");
    
    //closeDB($con);
  }else{
    header("location: index.php");
  }
}else{
  header("location: index.php");
}

?>