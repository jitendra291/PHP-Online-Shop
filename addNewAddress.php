<?php
session_start();
if(isset($_SESSION['gs_userid'])){
	$uid = $_SESSION['gs_userid'];
	
	require_once('funcs/functions.php');
	//$con = connectDB();
	
	$address = @mres_ss($_POST['address']);
	$city = @mres_ss($_POST['city']);
	$state = @mres_ss($_POST['state']);
	$pincode = @mres_ss($_POST['pincode']);
	$phone = @mres_ss($_POST['phone']);
	
	$res = mysql_query("insert into customeraddress (CID,Address,City,State,Pincode,Phone) values ($uid,'$address','$city','$state',$pincode,'$phone')");
	if($res){
		header("location: manageAddress.php");
	}else{
		$regs = "An Error occurred while adding your address details";
	}
	
	//closeDB($con);
	showMessage($regs);
}else{
	header("location: index.php");
}

?>