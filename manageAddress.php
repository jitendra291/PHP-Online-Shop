<?php

session_start();
if(isset($_SESSION['gs_userid'])){
  $uid = $_SESSION['gs_userid'];
  require_once('funcs/functions.php');
  //$con = connectDB();
}else{
  header("location: index.php");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
<head>
<title>Manage Address - Online Shop</title>
<?php echo includeAllFiles(); ?>
<script> 

<?php getJqueryDropdowns(); ?>

function showConfirm(val,disp){
  if(disp == 1){
    document.getElementById("confirmBox" + val).style.display = "block";
  }else{
    document.getElementById("confirmBox" + val).style.display = "none";

  }
}

function showEditArea(val,disp){
  if(disp == 1){
    document.getElementById("addressArea" + val).style.display = "none";
    document.getElementById("confirmArea" + val).style.display = "none";
    document.getElementById("editArea" + val).style.display = "block";
  }else{
    document.getElementById("addressArea" + val).style.display = "block";
    document.getElementById("confirmArea" + val).style.display = "block";
    document.getElementById("editArea" + val).style.display = "none";
  }
}

</script>

</head>

<body onload="init()">
<div class="mainArea">
 <?php showHeader($uid,""); ?>
 <div class="rest">
   <div class="personalDetailsArea">
     <div id="dialogRegister">
	<div style="width: 100%; height: 40px; background: white; color: black; border-radius: 10px 10px 0px 0px; box-shadow: 0px 0px 10px 2px gray inset; text-align: center; font-size: 24px; font-weight: bold; padding-top: 5px;">
	  <?php echo getPageTitle("Manage Address",$_SERVER["PHP_SELF"]); ?>
	</div>
	<div class="width100" style="margin-top: 10px;">
	  <div style="display: inline-block; width: 49%; border-right: 1px solid white; padding: 0px 5px 0px 5px;">
	    <form id="maForm1" action="addNewAddress.php" method="post" onsubmit="return formValidate(this.id,'mae',0,0,0);">
	      <div style="width:100%; text-align: center; color: black; background: white; font-weight: bold; font-size: 20px; border-radius: 10px 10px 0px 0px; box-shadow: 0px 0px 3px 1px gray; padding: 10px 0px 10px 0px;">
	        Add New Address
	      </div>
	      <table class="width100" style="margin-top: 10px;">
	        <tr>
                 <td style="vertical-align: top; width: 20%;">Address</td>
 		   <td>
		     <textarea style="width: 90%; height: 60px;" name="address"></textarea><br/>
		     <div id="mae1" class="errorMessages">Please Enter a Valid Address</div>
		   </td>
 		 </tr>
		 <tr>
 		   <td style="vertical-align: top; width: 20%;">City</td>
	          <td>
		     <input type="text" name="city" maxlength=30 style="width: 200px;"/><br/>
		     <div id="mae2" class="errorMessages">Please Enter a Valid City</div>
		   </td>
 		 </tr>
		 <tr>
 		   <td style="vertical-align: top; width: 20%;">State</td>
 		   <td>
		     <input type="text" name="state" maxlength=20 style="width: 200px;"/><br/>
     		     <div id="mae3" class="errorMessages">Please Enter a Valid State</div>
		   </td>
 		 </tr>
		 <tr>
 		   <td style="vertical-align: top; width: 20%;">Pincode</td>
 		   <td>
		     <input type="text" name="pincode" onkeyup="checkNumber(this)" maxlength=6 style="width: 200px;"/><br/>
		     <div id="mae4" class="errorMessages">Please Enter a Valid Pincode</div>
		   </td>
 		 </tr>
		 <tr>
 		   <td style="vertical-align: top; width: 20%;">Mobile</td>
 		   <td>
		     <input type="text" name="phone" onkeyup="checkNumber(this)" maxlength=10 style="width: 200px;"/><br/>
		     <div id="mae5" class="errorMessages">Please Enter a Valid Mobile Number</div>
		   </td>
 		 </tr>
		 <tr>
 		   <td colspan=2 style="text-align: center; padding-top: 10px;"><input type="submit" value="Add" class="styledButton"/> <input type="reset" value="Reset" class="styledButton"/></td>
 		 </tr>
	      </table>
	    </form>
	  </div>
	  <div style="display: inline-block; width: 49%;">
	    <?php
	      $res = mysql_query("select * from customeraddress where CID='$uid'");
	      $noa = mysql_num_rows($res);
	    ?>
	    <table style="width:100%;">
	      <div style="width:100%; text-align: center; color: black; background: white; font-weight: bold; font-size: 20px; border-radius: 10px 10px 0px 0px; box-shadow: 0px 0px 3px 1px gray; padding: 10px 0px 10px 0px;">
		 Select Address (<?php echo $noa; ?>)
	      </div>
	      <tr>
	        <td style="padding: 5px 5px 5px 5px; overflow: auto;">
		   <div <?php $w = $noa*50; echo "style='width: ".$w."%; height: 200px; overflow: auto; padding: 5px 5px 5px 5px;'"; ?>>
		     <?php
		 	if($noa > 0){
			  while($row = mysql_fetch_array($res)){
			    $uaddressid = $row['AddressID'];
			    $uaddress = $row['Address'];
			    $upincode = $row['Pincode'];
			    $ucity = $row['City'];
			    $ustate = $row['State'];
			    $uphone = $row['Phone'];
		     ?>
		       <div style="display: inline-block; cursor: pointer; vertical-align: top; width: 200px; background: rgba(255,255,255,0.3); height: 196px; border-radius: 5px 5px 5px 5px; box-shadow: 0px 0px 5px 1px gray; margin: 0px 5px 0px 5px;" onclick="copyAddress(<?php echo $uaddressid; ?>);">
			  <div style="width: 100%; height: 20px; padding: 5px 0px 5px 0px; text-align: center; background: white; font-weight: bold; box-shadow: 0px 0px 5px 1px gray inset; border-radius: 5px 5px 0px 0px; color: black;">Address</div>
			  <div id="addressArea<?php echo $uaddressid; ?>" style="height: 141px; overflow: auto;">
			    <div style="width: 95%; margin: 0px 5px 0px 5px; font-size: 12px; padding-bottom: 5px;"><?php echo $uaddress; ?></div>
			    <div style="width: 95%; margin: 0px 5px 0px 5px; font-size: 12px; padding-bottom: 5px;"><?php echo $ucity; ?></div>
			    <div style="width: 95%; margin: 0px 5px 0px 5px; font-size: 12px; padding-bottom: 5px;"><?php echo $ustate; ?></div>
			    <div style="width: 95%; margin: 0px 5px 0px 5px; font-size: 12px; padding-bottom: 5px;">Pincode: <label><?php echo $upincode; ?></label> </div>
			    <div style="width: 95%; margin: 0px 5px 0px 5px; font-size: 12px; padding-bottom: 5px;">Mobile: +91-<label><?php echo $uphone; ?></label> </div>
			  </div>
			  <div id="confirmArea<?php echo $uaddressid; ?>" style="position: relative; top: 0px; width: 100%; height: 20px; font-size: 12px; padding-top: 5px; background: white; border-radius: 0px 0px 5px 5px; box-shadow: 0px 0px 5px 1px gray inset; text-align: center;">
			    <div style="display: inline-block; width: 49%; border-right: 1px solid gray;">
			      <a class="link" onclick="showEditArea(<?php echo $uaddressid; ?>,1)">Edit</a>
			    </div>
			    <div style="display: inline-block; width: 49%;">
			      <a class="link" onclick="showConfirm(<?php echo $uaddressid; ?>,1)">Delete</a>
			    </div>
			  </div>
			  <div id="confirmBox<?php echo $uaddressid; ?>" style="display: none; position: relative; top: -55px; z-index: 1000; color: white; background: rgba(0,0,0,0.5); width: 100%; height: 30px;">
			    <div style="display: inline-block; font-size: 12px; margin: 5px 10px 0px 5px;">
			      Are you Sure?
			    </div>
			    <div style="display: inline-block;">
			      <a href="deleteAddress.php?aid=<?php echo $uaddressid; ?>" class="smallStyledButton">Yes</a>
			    </div>
			    <div style="display: inline-block;" class="smallStyledButton" onclick="showConfirm(<?php echo $uaddressid; ?>,0)">
			      No
			    </div>
			  </div>
			  <div id="editArea<?php echo $uaddressid; ?>" style="width: 100%; height: 100px; background: rgba(255,255,255,0.0); position: relative; top: 0px; display: none; font-size: 12px;">
			    <form id="updateAddressForm1" action="updateAddress.php?aid=<?php echo $uaddressid; ?>" method="post" onsubmit="return formValidate(this.id,'uae',0,0,0);" style="padding: 0px 5px 5px 5px;">
			      <textarea name="newAddress" style="font-family: cambria; resize: none; width: 95%;"><?php echo $uaddress; ?></textarea><div id="uae1"></div>
			      <table class="width100" cellpadding=0 cellspacing=0>
				 <tr style="padding-left: 10px;">
 				   <td style="width: 43px;">City</td>
 				   <td><input type="text" value="<?php echo $ucity; ?>" name="newCity" maxlength=30 style="width: 140px; margin-bottom: 2px; font-size: 12px; height: 15px; font-family: cmabria;"/><div id="uae2"></div></td>
 				 </tr>
				 <tr>
 				   <td style="width: 43px;">State</td>
 				   <td><input type="text" value="<?php echo $ustate; ?>" name="newState" maxlength=20 style="width: 140px; margin-bottom: 2px; font-size: 12px; height: 15px; font-family: cmabria;"/></td><div id="uae3"></div>
 				 </tr>
				 <tr>
 				   <td style="width: 43px;">Pincode</td>
 				   <td><input onkeyup="checkNumber(this)" type="text" value="<?php echo $upincode; ?>" name="newPincode" maxlength=6 style="width: 140px; margin-bottom: 2px; font-size: 12px; height: 15px; font-family: cmabria;"/></td><div id="uae4"></div>
 				 </tr>
				 <tr>
		 		   <td style="width: 43px;">Mobile</td>
 				   <td style="padding-bottom: 4px;"><input onkeyup="checkNumber(this)" type="text" value="<?php echo $uphone; ?>" name="newPhone" maxlength=10 style="width: 140px; font-size: 12px; height: 15px; font-family: cmabria;"/></td><div id="uae5"></div>
 				 </tr>
				 <tr>
 				   <td colspan=2 style="border-top: 1px solid white; text-align: center;">
				     <div style="display: inline-block;"><input type="submit" class="confirmButton" value="Update"/></div>
				     <div style="display: inline-block;" class="confirmButton" onclick="showEditArea(<?php echo $uaddressid; ?>,0)">Cancel</div>
				   </td>
 				 </tr>
			      </table>
			    </form>
			  </div>
		       </div>
		     <?php
			  }
                   ?>
		 </td>
	      </tr>
		     <?php
		       }else{
 		     ?>
	      <tr style="text-align: center; color: white;">
	        <td>No Addresses Available.</td>
	      </tr>
	      <?php } ?>
	    </table>
	  </div>
	</div>
       <div style="width: 100%; height: 100px; background: white; box-shadow: 0px 0px 10px 2px gray inset; border-radius: 0px 0px 10px 10px; margin-top: 10px;">
	  <?php echo showFooter(); ?>
	</div>
     </div>
   </div>
 </div>

</div>

<?php //closeDB($con); ?>

</body>
</html>
