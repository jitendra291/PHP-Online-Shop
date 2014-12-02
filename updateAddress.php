<?php
session_start();
if(isset($_SESSION['gs_userid'])){
  $uid = $_SESSION['gs_userid'];
  
  require_once('funcs/functions.php');
  //$con = connectDB();

  $addressid = $_GET['aid'];
  $address = $_POST['newAddress'];
  $city = $_POST['newCity'];
  $state = $_POST['newState'];
  $pincode = $_POST['newPincode'];
  $phone = $_POST['newPhone'];

  $res = mysql_query("update customeraddress set Address='$address', City='$city', State='$state', Pincode='$pincode', Phone='$phone' where CID='$uid' and AddressID='$addressid'");
  
  //closeDB($con);
  header("location: manageAddress.php");
}else{
  header("location: index.php");
}
?>