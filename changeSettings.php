<?php
session_start();
if(isset($_SESSION['gs_userid'])){
	$uid = $_SESSION['gs_userid'];
	require_once("funcs/functions.php");
	//$con = connectDB();

	$res = mysql_query("select * from customerdetails where CID='$uid'");
	$row = mysql_fetch_array($res);
	$currpass = mres_ss($_POST['currpass']);
	$string = crypt($currpass, $row['Password']);
	$subs = substr($string,0,strlen($row['Password']));
	if($subs == $row['Password']){
		$newpass = mres_ss($_POST['newpass']);
		$salt = substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22);
		$hash = crypt($newpass, '$2a$12$' . $salt);
		$res = mysql_query("update customerdetails set Password = '$hash' where CID = '$uid'");
		if($res){
			$regs = '<label style="color: green;">Password changed successfully!<label>';
		}else{
			$regs = '<label style="color: red;">An unexpected error occurred while changing the password</label>';
		}
	}else{
		$regs = '<label style="color: red;">Invalid current Password!</label>';
	}
	//closeDB($con);
	$_SESSION['pass_stat'] = $regs;
	header("location: customerSettings.php");
}else{
	header("location: index.php");
}
?>