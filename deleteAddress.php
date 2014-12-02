<?php

session_start();
if(isset($_SESSION['gs_userid'])){
	$uid = $_SESSION['gs_userid'];
	
	require_once('funcs/functions.php');
	//$con = connectDB();
	
	$aid = mres_ss($_GET['aid']);
	$res = mysql_query("delete from customeraddress where CID='$uid' and AddressID='$aid'");
	if($res){
		header("location: manageAddress.php");
	}else{
		$regs = "An Error occurred while deleting your address";
	}
	//closeDB($con);
	showMessage($regs);
}else{
	header("location: index.php");
}
?>
