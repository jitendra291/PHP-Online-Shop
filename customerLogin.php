<?php
require_once('funcs/functions.php');
//$con = connectDB();

$userid = mres_ss($_POST['emailid']);
$pass = mres_ss($_POST['password']);

if(isset($_GET['page'])){
  $page = mres_ss($_GET['page']);
}else{
  $page = null;
}

if(isset($userid) && isset($pass)){
  if(validEmail($userid)){
    $res = mysql_query("select * from customerdetails where Email='$userid'");
    if(mysql_num_rows($res) == 1){
      $row = mysql_fetch_array($res);
      $string = crypt($pass, $row['Password']);
      $subs = substr($string,0,strlen($row['Password']));
      if($subs == $row['Password']){
	 if($row['ActStatus'] == 1){
	   session_start();
          $_SESSION['gs_userid'] = $row['CID'];
          header("location: index.php");
	 }else{
	   $regs = "Your Registration is Incomplete!!!<br/>Please complete your registration by clicking on the activation link sent to your Email ID.<br/><b>Also check your SPAM Mail.</b>";
	 }
      }else{
        $regs = "Invalid Username/Password";
      }
    }else{
      $regs = "Invalid Username/Password";
    }
  }else{
    $regs = "Invalid Email ID";
  } 
}else{
  $regs = "Invalid Username/Password";
}

showMessage($regs);

?>