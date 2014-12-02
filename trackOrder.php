<?php
$oid = trim($_POST['orderID']);
if(($oid != null)&&($oid != "")){
  require_once('funcs/functions.php');
  //$con = connectDB();
  
  $res = mysql_query("select Status from orders where OrderID='$oid'");
  $row = mysql_fetch_array($res);
  $status = $row['Status'];
  
  //closeDB($con);
  echo getStatusString($status);
}else{
  echo "<div style='color: red;'>Please enter an Order ID</div>";
}


?>