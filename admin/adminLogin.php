<?php

require_once("../funcs/functions.php");

$email = $_POST['email'];
$password = $_POST['password'];
if($email && $password){
  $email = stripslashes($email);
  $email = mysql_real_escape_string($email);
  $password = stripslashes($password);
  $password = mysql_real_escape_string($password);
  
  $q = "select AID from admin where Email='$email' and Password='$password'";
  $res = mysql_query($q) or die("Error in query");
  if(mysql_num_rows($res)>0){
    $row = mysql_fetch_array($res);
    session_start();
    $_SESSION['gs_admin'] = $row['AID'];
    header("location: index.php");
  }else{
    echo "Error: Invalid Username/Password";
  }
}else{
  echo "Please enter valid Username/Password";
}

?>