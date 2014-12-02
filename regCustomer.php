<?php
require_once('funcs/functions.php');
require_once('funcs/mailsend.php');

$email = mres_ss($_POST['emailid']);
if(validEmail($email)){
 
 //$con = connectDB();
 
 $pass = mres_ss($_POST['password']);
 $repass = mres_ss($_POST['repassword']);
 $username = mres_ss($_POST['custName']);
 $mobno = mres_ss($_POST['mobileNo']);
 
 $salt = substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22);
 $hash = crypt($pass, '$2a$12$' . $salt);
 
 $length = 13;
 $rangeMin = pow(36, $length-1);
 $rangeMax = pow(36, $length)-1;
 $base10Rand = mt_rand($rangeMin, $rangeMax);
 $newRand = base_convert($base10Rand, 10, 36);
 $uname = explode("@",$str);
 $randomString = "http://localhost/shopping_portal/test/regConfirm.php?verifyString=".$email."_jitendrachaudhary_".$newRand;
 
 $sql = "insert into customerdetails (Username,Email,Password,Phone,ActStatus,RandomString) values ('$username','$email','$hash','$mobno',0,'$newRand')";
 $res = mysql_query($sql);
 if($res){
  $subject = "Activation Request from Online Shop";
  $message = "
Welcome $username,<br/>
Please click the following Activation Link to confirm your Subscription,<br/>
$randomString<br/>
<br/>
Thank You
";
  $send = SendMail($email, $subject, $message);
  if($send){
    $regs = "You have been Registered!!!<br/>An Activation Link has been sent to: $email<br/>Please confirm your Registration. <br/> Thank You";
  }else{
    $regs = "An error occurred while sending Email.";
  }
 }else{
  if(mysql_errno() == 1062){
    $regs = "This Email ID is already in use.<br/>Please specify a different Email ID.";
  }else{
    $regs = "An Error has been encountered!!!<br/>Sorry for Inconvinience...";
      }
 }
 //closeDB($con);
}else{
  $regs = "Invalid IITJ Email-ID!!!";
}

showMessage($regs);

?>
