<?php
session_start();

if(isset($_SESSION['gs_userid'])){
  $uid = $_SESSION['gs_userid'];
  
  //$con = connectDB();

  if(isset($_SESSION['gs_cart'])){
    $cart = $_SESSION['gs_cart'];
  }else{
    header("location: index.php");
  }
}else{
 $uid = null;
}
  require_once('funcs/functions.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
<head>
<title>Place Order - Online Shop</title>
<?php echo includeAllFiles(); ?>

<script> 

<?php getJqueryDropdowns(); ?>

function copyAddress(val){
  document.getElementById("addressid").value = val;
  document.getElementById("address").value = document.getElementById("uaddress"+val).innerHTML;
  document.getElementById("city").value = document.getElementById("ucity"+val).innerHTML;
  document.getElementById("state").value = document.getElementById("ustate"+val).innerHTML;
  document.getElementById("pincode").value = document.getElementById("upincode"+val).innerHTML;
  document.getElementById("phone").value = document.getElementById("uphone"+val).innerHTML;

  document.getElementById("dumeyaddressid").value = val;
  document.getElementById("dumeyaddress").value = document.getElementById("uaddress"+val).innerHTML;
  document.getElementById("dumeycity").value = document.getElementById("ucity"+val).innerHTML;
  document.getElementById("dumeystate").value = document.getElementById("ustate"+val).innerHTML;
  document.getElementById("dumeypincode").value = document.getElementById("upincode"+val).innerHTML;
  document.getElementById("dumeyphone").value = document.getElementById("uphone"+val).innerHTML;
}

function checkNewValues(){
  var anythingChanged = false;
  var oldAddress = document.getElementById("dumeyaddress");
  var newAddress = document.getElementById("address");
  if(oldAddress.value != newAddress.value){
    anythingChanged = true;
  }else{
    anythingChanged = anythingChanged || false;
  }

  var oldCity = document.getElementById("dumeycity");
  var newCity = document.getElementById("city");
  if(oldCity.value != newCity.value){
    anythingChanged = true;
  }else{
    anythingChanged = anythingChanged || false;
  }

  var oldState = document.getElementById("dumeystate");
  var newState = document.getElementById("state");
  if(oldState.value != newState.value){
    anythingChanged = true;
  }else{
    anythingChanged = anythingChanged || false;
  }
  
  var oldPincode = document.getElementById("dumeypincode");
  var newPincode = document.getElementById("pincode");
  if(oldPincode.value != newPincode.value){
    anythingChanged = true;
  }else{
    anythingChanged = anythingChanged || false;
  }

  var oldPhone = document.getElementById("dumeyphone");
  var newPhone = document.getElementById("phone");
  if(oldPhone.value != newPhone.value){
    anythingChanged = true;
  }else{
    anythingChanged = anythingChanged || false;
  }
  
  if(anythingChanged){
    document.getElementById("addressid").value = "0";
  }else{
    document.getElementById("addressid").value = document.getElementById("dumeyaddressid").value;
  }
}

function setLocDetails(){
  document.getElementById("city").value = geoip_city();
  document.getElementById("state").value = geoip_region_name();
}

function init(){
  setLocDetails();
}

</script>

</head>

<body onload="init()">
<div class="mainArea">
 <?php showHeader($uid,""); ?>
 <div class="rest">
   <div class="personalDetailsArea">
     <div id="dialogRegister" style="">
       <?php if($uid != null){ ?>
	 <form id="orderForm1" action="orderComplete.php" method="post" onsubmit="return formValidate(this.id,'oe',0,0,0);">
	   <div style="width: 100%; height: 40px; background: rgb(255,201,14); border-radius: 10px 10px 0px 0px; box-shadow: 0px 0px 5px 1px gray inset; font-weight: bold; text-align: center; color: black; font-size: 24px; padding-top: 5px;">
	     Order Details
	   </div>
	   <div style="width: 100%;">
             <div style="display: inline-block; width: 50%; padding: 10px 10px 10px 10px; color: white; border-right: 1px solid white;">
		<?php
		  $res = mysql_query("select Email,Username from customerdetails where CID='$uid'");
		  $row = mysql_fetch_array($res);
		  $uemail = $row['Email'];
		  $uname = $row['Username'];
		?>
	     <table width="100%">
	       <tr style="height: 30px;">
                <td style="width: 40%; font-size: 20px;">Email</td>
                <td><label id="emailid" class="width100" style="height: 20px;"><?php echo $uemail; ?></label></td>
              </tr>
	       <tr style="height: 30px;">
                <td style="font-size: 20px;">Name</td>
                <td>
                  <input type="text" id="custname" name="custname" value="<?php echo $uname ?>" maxlength=50 class="width100" style="height: 20px;"/>
                  <div class="errorMessages" id="oe1">Please enter a valid Name</div>
                </td>
              </tr>
	       <tr style="height: 30px;">
		  <td style="font-size: 20px;">Address</td>
		  <td>
		    <textarea id="address" name="address" class="width100" style="height: 50px; font-family: cambria;" onkeyup="checkNewValues()"></textarea>
		    <div class="errorMessages" id="oe2">Please enter a valid Address</div>
		  </td>
		</tr>
	       <tr style="height: 30px;">
		  <td style="font-size: 20px;">City</td>
		  <td>
		    <input type="text" id="city" name="city" maxlength=30 class="width100" style="height: 20px;" onkeyup="checkNewValues()"/>
		    <div class="errorMessages" id="oe3">Please enter a valid City</div>
		  </td>
		</tr>
	       <tr style="height: 30px;">
		  <td style="font-size: 20px;">State</td>
		  <td>
		    <input type="text" id="state" name="state" maxlength=20 class="width100" style="height: 20px;" onkeyup="checkNewValues()"/>
		    <div class="errorMessages" id="oe4">Please enter a valid State</div>
		  </td>
		</tr>
	       <tr style="height: 30px;">
		  <td style="font-size: 20px;">Pincode</td>
		  <td>
		    <input type="text" id="pincode" name="pincode" maxlength=6 style="width: 50%;" style="height: 20px;" onkeyup="checkNewValues()" onblur="checkNumber(this)"/>
		    <div class="errorMessages" id="oe5">Please enter a valid Pincode</div>
		  </td>
		</tr>
	       <tr style="height: 30px;">
		  <td style="font-size: 20px;">Mobile No.</td>
		  <td>
		    <input type="text" id="phone" name="mobileno" maxlength=10 style="width: 50%;" style="height: 20px;" onkeyup="checkNewValues()" onblur="checkNumber(this)"/>
		    <div class="errorMessages" id="oe6">Please enter a valid Mobile Number</div>
		  </td>
		</tr>
	       <tr>
		  <td></td>
		  <td>
		    <input type="hidden" id="addressid" name="addressid" />
		    <input type="hidden" id="dumeyaddressid" />
		    <textarea id="dumeyaddress" hidden></textarea>
		    <input type="hidden" id="dumeycity"/>
		    <input type="hidden" id="dumeystate"/>
		    <input type="hidden" id="dumeypincode"/>
		    <input type="hidden" id="dumeyphone"/>
		  </td>
		</tr>
	       <tr>
	         <td colspan=2 style="">
		    <div style="width: 100%; text-align: center; margin: 0px auto 0px auto; padding-top: 10px;">
                    <input type="submit" value="Place Order" class="bigStyledButton"/>
		      <input type="reset" value="Reset" style="border: 0px; color: blue; text-decoration: underline; background: transparent; cursor: pointer;"/>
		    </div>
                </td>
              </tr>
	     </table>
	     </div>
	     <div style="display: inline-block; width: 45%; vertical-align: top; padding: 10px 10px 10px 10px;">
		<?php
		  $res = mysql_query("select * from customeraddress where CID='$uid'");
		  $noa = mysql_num_rows($res);
		?>
		<table style="width:100%;">
		  <tr>
		    <td colspan=2 style="width:100%; text-align: center; color: black; background: white; font-weight: bold; font-size: 20px; border-radius: 10px 10px 0px 0px; box-shadow: 0px 0px 5px 1px gray inset; padding: 10px 0px 10px 0px;">
		      Select Address (<?php echo $noa; ?>)
		    </td>
 		  </tr>
		  <tr>
		    <td style="padding: 0px 5px 0px 5px; overflow: auto;">
		      <div <?php $w = $noa*50; echo "style='width: ".$w."%; height: 200px; overflow: auto; padding: 5px 5px 5px 5px;'"; ?>>
			<?php if($noa > 0){ ?>
			<?php
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
			    <div style="width: 95%; margin: 2px 5px 0px 5px; font-size: 12px; padding-bottom: 5px;" id="uaddress<?php echo $uaddressid;?>"><?php echo $uaddress; ?></div>
			    <div style="width: 95%; margin: 0px 5px 0px 5px; font-size: 12px; padding-bottom: 5px;" id="ucity<?php echo $uaddressid;?>"><?php echo $ucity; ?></div>
			    <div style="width: 95%; margin: 0px 5px 0px 5px; font-size: 12px; padding-bottom: 5px;" id="ustate<?php echo $uaddressid;?>"><?php echo $ustate; ?></div>
			    <div style="width: 95%; margin: 0px 5px 0px 5px; font-size: 12px; padding-bottom: 5px;">Pincode: <label id="upincode<?php echo $uaddressid;?>"><?php echo $upincode; ?></label> </div>
			    <div style="width: 95%; margin: 0px 5px 0px 5px; font-size: 12px; padding-bottom: 5px;">Mobile: +91-<label id="uphone<?php echo $uaddressid;?>"><?php echo $uphone; ?></label> </div>
		         </div>
			<?php
			  }
			?>
		<?php }else{ ?>
		      </div>
		    </td>
		  </tr>
		  <tr style="text-align: center; color: white;">
		    <td>No Addresses Available.</td>
		  </tr>
		<?php } ?>
		<tr style="text-align: center; color: white;">
		  <td style="padding: 10px; border-radius: 0px 0px 10px 10px; background: white; box-shadow: 0px 0px 5px 1px gray inset;">
		    <a href="manageAddress.php" style="color: black; color: blue; text-decoration: underline;">Manage Addresses</a>
		  </td>
		</tr>
		</table>
	     </div>
	   </div>
	   <div style="width: 100%; height: 30px; border-radius: 0px 0px 10px 10px; box-shadow: 0px 0px 5px 1px gray inset; text-align: center; color: yellow; font-size: 16px; padding-top: 10px;">
	     Note: You can modify or cancel your orders upto 30 minutes from the time of placement of order.
	   </div>
	 </form>
       <?php }else{ ?>
	 <form action="customerLogin.php?page=placeOrder.php" method="post">
	   <div style="width: 100%; height: 40px; background: white; border-radius: 10px 10px 0px 0px; box-shadow: 0px 0px 5px 1px gray inset; font-weight: bold; text-align: center; color: #36c5d8; font-size: 24px; padding-top: 5px;">
	     Please Login
	   </div>
	   <div style="width: 100%;">
             <div style="width: 40%; margin-left: auto; margin-right: auto; padding: 5px 5px 5px 5px; color: white;">
	     <table width="100%">
	       <tr> <td style="width: 40%; font-size: 20px;">Email</td> <td><input type="text" id="emailid" name="emailid" maxlength=50 class="width100" style="height: 20px;"/></td> </tr>
	       <tr> <td style="font-size: 20px;">Password</td> <td><input type="password" id="password" name="password" maxlength=20 class="width100" style="height: 20px;"/></td> </tr>
	       <tr>
	         <td colspan=2>
		   <div style="width: 52%; margin-left: auto; margin-right: auto; padding-top: 10px;">
                     <input type="submit" value="Login" style="background: url(images/regButton.png); width: 100px; height: 31px; border: 0px; font-size: 16px; font-weight: bold; color: white;"/>
                     <input type="reset" value="Reset" style="background: url(images/regButton.png); width: 100px; height: 31px; border: 0px; font-size: 16px; font-weight: bold; color: white;"/>
		   </div>
                 </td>
               </tr>
	     </table>
	     </div>
	   </div>
	 </form>
       <?php } ?>

     </div>
   </div>
 </div>

</div>

<?php //closeDB($con); ?>

</body>
</html>