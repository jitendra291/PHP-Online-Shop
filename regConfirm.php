<?php

if(isset($_GET['verifyString'])){
 require_once('funcs/functions.php');
 //$con = connectDB();
 
 $vs = $_GET['verifyString'];
 $exp = explode("_jitendrachaudhary_",$vs);
 if(count($exp)==2){
   $sql = "update customerdetails set ActStatus=1 where Email='$exp[0]' and RandomString='$exp[1]'";
   $res = mysql_query($sql);
   if($res){
     $regs = "Your Account has been activated successfully.<br/>Thank You!!!";
   }else{
     $regs = "An Error has been encountered!!!";
   }
 }else{
   $regs = "Invalid Activation Link";
 }
 //closeDB($con);
}else{
 $regs = "Invalid Activation Link";
}

showMessage($regs);

?>