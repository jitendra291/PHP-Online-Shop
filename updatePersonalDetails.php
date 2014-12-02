<?php
session_start();
if(isset($_SESSION['gs_userid'])){
  $uid = $_SESSION['gs_userid'];
  require_once('funcs/functions.php');
  //$con = connectDB();
  
  if(isset($_POST['custName']))
    $cname = $_POST['custName'];
  else
    $cname = "";

  if(isset($_POST['mobileNo']))
    $mobno = $_POST['mobileNo'];
  else
    $mobno = "";

  if(($cname != "")&&($mobno != "")){
    $res = mysql_query("update customerdetails set Username='$cname',Phone='$mobno' where CID='$uid'");
    header("location: personalDetails.php");
  }else{
    $regs = "Invalid Username/Mobile No";
  }
  //closeDB($con);
}else{
  $regs = "Invalid Session!!!";
}

showMessage($regs);

?>