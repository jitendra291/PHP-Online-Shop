<?php
$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
 $selected = mysql_select_db("shopping_portal2",$link) 
  or die("Could not select examples");
  
/*function runQuery("", $str){
  $con = connectDB();
  $fres = mysqli_query($con,$str);
  if(!$fres){
    generateLog("\nQuery Error! '".$str."'\nDescription: ".mysqli_error($con)."\n");
  }
  closeDB($con);
  return $fres;
}

function connectDB(){
  

}

function closeDB($c){
  if($c){
    generateLog("\nClosing Database connection...\n");
    if(mysqli_close($c)){
      generateLog("Database connection closed successfully!\n");
    }else{
      generateLog("Error while closing database connection\nDescription: ".mysqli_error($c)."\n");
    }
    generateLog("================================================================================\n");
  }
}*/

function generateLog($info){/*
	$today = date("d-m-Y");
	$fpath = "log_info/".$today.".txt";
	if(!fopen($fpath, 'r')){
		$fh = fopen($fpath, 'w') or die("can't create file: ".$fpath);
		fclose($fh);
	}else{
		$fh = fopen($fpath, 'a') or die("can't open file ".$fpath." for appending!!!");
		fwrite($fh, $info);
		fclose($fh);
	}*/
}

function getStatusString($stat){
  switch($stat){
    case 1: return "<div style='color: yellow;'>Order in Revert Period</div><div style='color: yellow;'>Time Left: </div>"; break;
    case 2: return "<div style='color: yellow;'>Order Placed</div>"; break;
    case 3: return "<div style='color: yellow;'>Under Processing</div>"; break;
    case 4: return "<div style='color: yellow;'>Order Despatched</div>"; break;
    case 5: return "<div style='color: yellow;'>Order Delivered</div>"; break;
    case 6: return "<div style='color: red;'>Order Cancelled</div>"; break;
    case 7: return "<div style='color: yellow;'>Order Un-Delivered</div>"; break;
    default: return "<div style='color: red;'>Invalid Order ID</div>";
  }
}

function showFooter(){

}

function showItemBlock($itemname,$itemid,$imagepath){
if(isset($_SESSION['gs_cart'])){
  $cart = $_SESSION['gs_cart'];
}else{
  $cart = "";
}
$city="Jodhpur";
	//$con = connectDB();
	//$query = "select * from subitems where ItemID='$itemid' order by Popularity desc";
       $query = "select * from subitems where SubItemID in ( select SubItemID from shopitems where ShopID in ( select ShopID from shopdetails where City like '%".$city."%' ) ) and ItemID='$itemid' order by Popularity desc";
	$looseAvail = 0;
       echo "<div class='itemBlock'>";
	  echo "<div class='itemName'>$itemname</div>";
	
	  echo "<div class='itemImage'><img src='$imagepath' alt='image not found' class='imageDim'/></div>";

	  $res1 = @mysql_query($query);
	  
	  $no_of_subitems = mysql_num_rows($res1);
	  $count = 0;
	  while($sub_ele = mysql_fetch_array($res1)){
	    if($sub_ele['Type'] == 'L'){
	      $ip = $sub_ele['Price'];
	      $subitemid = $sub_ele['SubItemID'];
	      $pop = $sub_ele['Popularity'];
	      $pos = strpos($cart,"i->".$subitemid);
	      if($pos === false){
		 $enVal = "";
		 $textdec = "";
	      }else{
		 $enVal = "checked disabled";
		 $textdec = "text-decoration: line-through;";
		 $count++;
	      }
	      echo "<div style=''>";
	      echo "<div class='itemLoosePrice'>";
	      echo "<label class='itemPriceTags'><div style='display: inline-block; width: 10%;'> <input type='checkbox' id='subcheck$subitemid' name='det$itemid' value='$subitemid' onclick='detailChecked($itemid,$subitemid);' $enVal/> </div>";
	      $pop = round($pop, 2);
	      echo "<div style='display: inline-block; width: 90%; text-align: center; $textdec' id='subcheckname$subitemid'>Rs. $ip</div></label>";
	      echo "</div>";
	      echo "</div>";
	      $looseAvail = 1;
	      
	    }
	  }
	  if($looseAvail == 1){
	    echo "<div style=''>";
	    echo "<div class='itemDetails'>";
	  }else{
	    echo "<div style=''>";
	    echo "<div class='itemDetails' style='height: 120px;'>";
	  }
	  $res1 = @mysql_query($query);
	  while($sub_ele = mysql_fetch_array($res1)){
	    if($sub_ele['Type'] == 'P'){
	      $quan = $sub_ele['Quantity'];
	      $price = $sub_ele['Price'];
	      $moredet = $sub_ele['SubItemName'];
	      echo "<label class='itemPriceTags'><div style='white-space: nowrap; border-bottom: 1px solid silver;'>";
	      $subitemid = $sub_ele['SubItemID'];
	      $pop = $sub_ele['Popularity'];
	      $pos = strpos($cart,"i->".$subitemid);
	      if($pos === false){
		 $enVal = "";
		 $textdec = "";
	      }else{
		 $enVal = "checked disabled";
		 $textdec = "text-decoration: line-through;";
		 $count++;
	      }
	      echo "<input type='checkbox' name='det$itemid' value='$subitemid' id='subcheck$subitemid' onclick='detailChecked($itemid,$subitemid);' $enVal/>";
	      $qRes = getQuantityWithUnits($quan);
	      $pop = round($pop, 2);
//echo "<label style='$textdec' id='subcheckname$subitemid'>"."Price: "." Rs. ".$price."</label><br/>";
	     	     
		 echo "<label style='$textdec' id='subcheckname$subitemid'>"."Price: "." Rs. ".$price."</label><br/>";
	      
		  echo "</div></label>";
	      echo "Rating : ".$pop."<br/>";
		  echo "&nbsp;&nbsp;&nbsp";
		  echo '<span class="rating">
        <input type="radio" class="rating-input"
    id="rating-input-1-5" name="rating-input-1"/>
        <label for="rating-input-1-5" class="rating-star"></label>
        <input type="radio" class="rating-input"
                id="rating-input-1-4" name="rating-input-1"/>
        <label for="rating-input-1-4" class="rating-star"></label>
        <input type="radio" class="rating-input"
                id="rating-input-1-3" name="rating-input-1"/>
        <label for="rating-input-1-3" class="rating-star"></label>
        <input type="radio" class="rating-input"
                id="rating-input-1-2" name="rating-input-1"/>
        <label for="rating-input-1-2" class="rating-star"></label>
        <input type="radio" class="rating-input"
                id="rating-input-1-1" name="rating-input-1"/>
        <label for="rating-input-1-1" class="rating-star"></label>
</span>';
	    }
	  }
	  echo "</div>";
	 echo "</div>";
       echo "</div>";
	if($count < $no_of_subitems){
	  return false;
	}else{
	  return true;
	}
	//closeDB($con);
}

function getQuantityWithUnits($q){
  if($q < 1000){
    return $q."gms";
  }else{
    return ($q/1000)."Kg";
  }
}

function getUserKilos($quant){
  return ((int)($quant/1000)) ;
}

function getUserGrams($quant){
  return ($quant % 1000);
}

function getDecimalString($num){
  if(is_float($num)){
    return $num;
  }else{
    return $num.".00";
  }
}

function showHeader($uid,$city){
	if($city != "0")
	{
		$currentCity = "jodhpur";
	}else
	{
		$currentCity = "Jodhpur,Rajasthan";
	}
	
	//$con = connectDB();
	echo '<div class="mainTitle">';
		echo '<div class="mainTitleArea" style="background: ;">';
			echo '<div class="logo" style="display: inline-block; width: 22%; vertical-align: top;"><a href="index.php"><img src="images/logo.png"/></a></div>';
			echo '<div style="display: inline-block; width: 20%; vertical-align: top;">';
				echo '<div><input type="text" class="cityName" id="cityName" value="'.$currentCity.'" disabled/></div>';
				echo '<div style="padding: 5px 10px 0px 0px;"><a id="box_content" class="storeLink">Admin</a></div>';
			
				if($uid && ($city == "0")){
						}
			echo '</div>';
			echo '<div style="display: inline-block; width: 58%; vertical-align: top;">';
			echo '<div class="navOptionsArea" style="">';
			echo '<div id="loginMenu">';
				echo '<ul>';
					echo '<li> <a href="index.php" class="topNavItem">Home</a> </li>';
					if(!$uid){
						echo '<li id="customerLoginLink"> <a href="#" class="topNavItem">Login</a></li>';
						echo '<li id="customerRegisterLink"> <a href="#" class="topNavItem">Register</a></li>';
						echo '<li id="menu3"> <a href="trackOrder.php" class="topNavItem">Track Order</a>';
							echo '<ul id="submenu3" style="border-radius: 0px 0px 5px 5px;">';
								echo '<div class="trackOrderSubMenu">';
									echo '<div style="padding: 5px 5px 5px 5px; ">';
										echo 'Enter Order ID<br/>';
										echo '<input type="text" id="orderid" class="loginInputEmail"/>';
										echo '<div id="orderStatusLabel"></div>';
										echo '<input type="button" value="Track" onclick="trackOrder();"/>';
									echo '</div>';
								echo '</div>';
							echo '</ul>';
						echo '</li>';
					}
					if($uid != null){
						$res = @mysql_query("select Username from customerdetails where CID='$uid'");
						if($res){
							$row = mysql_fetch_array($res);
							$uname = $row['Username'];
						}
						echo '<li id="menu2"> <a href="#" class="topNavItem">'.$uname.'</a>';
							echo '<ul id="submenu2" style="border-radius: 0px 0px 5px 5px;">';
								echo '<div class="subMenu">';
									echo '<a href="myorders.php" class="subMenuLink"> <div class="subMenuItem"> My Orders </div> </a>';
									echo '<a href="personalDetails.php" class="subMenuLink"> <div class="subMenuItem"> Personal Details </div> </a>';
									echo '<a href="manageAddress.php" class="subMenuLink"> <div class="subMenuItemLast"> Manage Address </div> </a>';
								echo '</div>';
							echo '</ul>';
						echo '</li>';
						/*$res = @mysql_query("select ShopID, EnterpriseName, Verified from shopdetails where CID='$uid'");
						$storeCount = mysql_num_rows($res);
						if($storeCount > 0){
							echo '<li id="menu3"> <a href="#" class="topNavItem">My Stores</a>';
							echo '<ul id="submenu3" style="border-radius: 0px 0px 5px 5px;">';
							echo '<div class="subMenu">';
							$cnt = 0;
							while($row = mysql_fetch_array($res)){
								$cnt++;
								$shopid = $row['ShopID'];
								$ename = $row['EnterpriseName'];
								$verified = $row['Verified'];
								$entName = $ename;
								$storeLink = "store.php?sid=".$shopid;
								if($verified == 0){
									$entName .= "<br/><label style='color: rgb(210,0,0); font-size: 10px;'>(Not Verified)</label>";
									$storeLink = "#";
								}
								if($cnt < $storeCount){
									echo '<a href="'.$storeLink.'" class="subMenuLink"> <div class="subMenuItem">'.$entName.'</div> </a>';
								}else{
									echo '<a href="'.$storeLink.'" class="subMenuLink"> <div class="subMenuItemLast">'.$entName.'</div> </a>';
								}
							}
							echo '</div>';
							echo '</ul>';
							echo '</li>';
						}*/
						echo '<li> <a href="customerSettings.php" class="topNavItem">Settings</a> </li>';
						echo '<li> <a href="customerLogout.php" class="topNavItem">Logout</a> </li>';
					}
				echo '</ul>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			if($uid != null){
				
			}
		echo '</div>';
	echo '</div>';
	
	//closeDB($con);
}

function mres_ss($txt){
	
	$txt = htmlspecialchars(stripslashes($txt),ENT_QUOTES);
	$txt = str_ireplace("script", "blocked", $txt);
	$txt = mysql_real_escape_string($txt);
	return $txt;
}

function validEmail($email){
	$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
	if(preg_match($regex, $email)){
		return true;
	}
	return false;
}

function showMessage($message){
	if($message != ""){
		session_start();
		$_SESSION['gs_reg_status'] = $message;
		header("location: messagePage.php");
	}
}

function includeAllFiles(){
	echo '<link rel="stylesheet" type="text/css" media="all" href="styles/styles.css">
	<link rel="stylesheet" type="text/css" media="all" href="styles/styles1.css">
	<link rel="stylesheet" href="styles/jquery-ui.css" />
	
	<script language="JavaScript" src="http://j.maxmind.com/app/geoip.js"></script>
	
	<script type="text/javascript" src="js/javas.js"></script>
	<script type="text/javascript" src="js/textchange.js"></script>
	<script type="text/javascript" src="js/rup.js"></script>
	
	<script src="js/jquery-1.9.1.js"></script>
	<script src="js/jquery-ui.js"></script>';
}

function getJqueryDropdowns(){
	echo '$(document).ready(function(){
		$("#menu1").hover(function(){
			$("#submenu1").slideToggle("fast");
		});
		$("#menu2").hover(function(){
			$("#submenu2").slideToggle("fast");
		});
		$("#menu3").hover(function(){
			$("#submenu3").slideToggle("fast");
		});
		$("#loginmenu").hover(function(){
			$("#loginsubmenu").slideToggle("fast");
		});
		$("#registermenu").hover(function(){
			$("#registersubmenu").slideToggle("fast");
		});
	});';
}

function getJqueryCartDialog(){
echo '
	var $dialog = $("#dialog").dialog({
		autoOpen: false,
              modal: true,
              show: "none",
              hide: "none",
              width: 800,
		height: 450,
	 	resizable: false,
		sticky: true,
              close: function(){
			if(isItemRemoved){
				location.reload();
			}
		}
	})
	$("#cartButton").on("click", function(e) {
		e.preventDefault();
		$dialog.parent().css({position:"fixed"}).end().dialog("open");
	});
	$("#cartButtonFixed").on("click", function(e) {
		e.preventDefault();
		$dialog.parent().css({position:"fixed"}).end().dialog("open");
	});
	$("#close_dialog").click(function(){
		$("#dialog").dialog("close");
	});
	$("#dialog").dialog("option", "position", "center");
	$(".ui-dialog-titlebar").hide();
';

}

function getJqueryDialogs($dialogVariable, $bodyForDialog, $linkForDialog, $dialogCloseLink, $width, $height){
echo'
	var $dialog'.$dialogVariable.' = $("'.$bodyForDialog.'").dialog({
		dialogClass:"dialogTransparent",
		autoOpen: false,
              modal: true,
              show: "none",
              hide: "none",
              width: '.$width.',
		height: '.$height.',
	 	resizable: false,
              close: function(){
			//location.reload();
		}
	})
	$("'.$linkForDialog.'").on("click", function(e) {
		e.preventDefault();
		$dialog'.$dialogVariable.'.parent().css({position:"fixed"}).end().dialog("open");
	});
	$("'.$dialogCloseLink.'").click(function(){
		$("'.$bodyForDialog.'").dialog("close");
	});
	$(".ui-dialog-titlebar").hide();
';

}

function getAllJqueryDialogs(){
	getJqueryCartDialog();
	getJqueryDialogs(1, "#dialogRegister",       "#customerRegisterLink", "#regCloseDialog",            550, 500);
	getJqueryDialogs(4, "#dialogRegisterVendor", "#vendorRegisterLink",   "#regCloseDialogVendor",      900, 400);
	getJqueryDialogs(2, "#customerLogin",        "#customerLoginLink",    "#customerLoginCloseDialog",  400, 300);
	getJqueryDialogs(5, "#selectLocation",       "#cityName",             "#selectLocationCloseDialog", 500, 215);
    getJqueryDialogs(6, "#adminLogin",       "#box_content",               "#adminLoginCloseDialog",   400, 300);
	
	}
function getAdminLogin(){

echo '
<div id="adminLogin" style="display: none;">
  <div class="customerLoginArea">
     <div class="mainLoginArea">
       <div class="loginHead" style="width: 94%;">
         <span style="float: left;">Admin Login</span>
         <span style="float: right; margin: -20px -20px 0px 0px; cursor: pointer;" id="adminLoginCloseDialog"><img src="images/close.png"/></span>
       </div>
       <div class="width100" style="margin-left: 10px;">
         <form method="post" action="admin/adminLogin.php" >
	    <table class="width100">
	      <tr>
	        <td class="colorLoginCaption">User Name </td>
             </tr>
             <tr>
	        <td>
		   <input type="text" id="emailid" name="email" class="custLoginInputEmail" maxlength=50 style="font-size: 14px;"/>
		   <div class="loginErrorMessages" id="loginError1">
		     Please enter your User Name!!!
		   </div>
		 </td>
	      </tr>
	      <tr>
		 <td class="colorLoginCaption"> Password </td>
	      </tr>
	      <tr>
		 <td>
		   <input type="password" id="password" name="password" class="custLoginInputPassword" maxlength=20 style="font-size: 14px;"/>
		   <div class="loginErrorMessages" id="loginError2">
		     Please enter your Password!!!
		   </div>
		 </td>
	      </tr>
	      <tr style="text-align: center;">
		 <td style="padding-top: 10px;"> <input type="submit" value="Login" class="styledButton"/> <input type="reset" value="Reset" class="styledButton"/> </td>
	      </tr>
	    </table>
	  </form>
       </div>
     </div>
   </div>
</div>
';

}
function getUserLogin(){

echo '
<div id="customerLogin" style="display: none;">
  <div class="customerLoginArea">
     <div class="mainLoginArea">
       <div class="loginHead" style="width: 94%;">
         <span style="float: left;">Customer Login</span>
         <span style="float: right; margin: -20px -20px 0px 0px; cursor: pointer;" id="customerLoginCloseDialog"><img src="images/close.png"/></span>
       </div>
       <div class="width100" style="margin-left: 10px;">
         <form method="post" action="customerLogin.php" onsubmit="return validateLogin()" >
	    <table class="width100">
	      <tr>
	        <td class="colorLoginCaption"> Email ID </td>
             </tr>
             <tr>
	        <td>
		   <input type="text" id="emailid" name="emailid" class="custLoginInputEmail" maxlength=50 style="font-size: 14px;"/>
		   <div class="loginErrorMessages" id="loginError1">
		     Please enter your Email-ID!!!
		   </div>
		 </td>
	      </tr>
	      <tr>
		 <td class="colorLoginCaption"> Password </td>
	      </tr>
	      <tr>
		 <td>
		   <input type="password" id="password" name="password" class="custLoginInputPassword" maxlength=20 style="font-size: 14px;"/>
		   <div class="loginErrorMessages" id="loginError2">
		     Please enter your Password!!!
		   </div>
		 </td>
	      </tr>
	      <tr style="text-align: center;">
		 <td style="padding-top: 10px;"> <input type="submit" value="Login" class="styledButton"/> <input type="reset" value="Reset" class="styledButton"/> </td>
	      </tr>
	    </table>
	  </form>
       </div>
     </div>
   </div>
</div>
';

}

function getVendorRegistration(){
$temp = "'vre'";
echo '
<div id="dialogRegisterVendor" style="display: none;">
  <div class="registerAreaVendor" style="margin: 10px; box-shadow: 0px 0px 10px 2px gray;">
     <div class="mainLoginArea">
       <div class="loginHead">
         <span style="float: left;">STORE REGISTRATION</span>
         <span style="float: right; margin: -20px -20px 0px 0px; cursor: pointer;" id="regCloseDialogVendor"><img src="images/close.png"/></span>
       </div>
       <div class="width100">
         <form id="registerForm2" action="regVendor.php" method="post" onsubmit="return formValidate(this.id,'.$temp.',0,0,0);" >
	    <div style="display: inline-block; width: 49.5%; vertical-align: top;">
	      <table class="tableStyle">
		 <tr>
                 <td> <span class="regText"> Enterprise Name </span> <span class="errorMessages floatRight" id="vre1">Please enter your enterprise name!!!</span> </td>
               </tr>
               <tr>
                 <td>
                   <input type="text" id="enterprisename" name="enterprisename" class="inputEmail" style="font-family: cambria;" maxlength=150 placeholder="Enter your enterprise name here"/>
                 </td>
               </tr>

               <tr>
                 <td> <span class="regText"> Mobile No. </span> <span class="errorMessages floatRight" id="vre2">Please enter your Mobile Number!!!</span> </td>
               </tr>
               <tr>
                 <td style="padding-bottom: 0px;">
                   <div class="mobileArea" >
                     <table>
                       <tr>
                         <td>
			      <div class="mobileCode" style="display: inline-block; vertical-align: top;">+91-</div>
			      <div style="display: inline-block; vertical-align: top; margin-top: -3px; background: transparent;"> <input type="text" id="mobileno" name="mobileno" style="font-family: cambria;" maxlength=10 onchange="checkNumber(this)" class="mobileNo" placeholder="Enter your mobile number here"/> </div>
			    </td>
                       </tr>
                     </table>
                   </div>
                 </td>
               </tr>

		 <tr>
                 <td> <span class="regText"> Delivery Radius (in Kilometers) </span> <span class="errorMessages floatRight" id="vre3">Please enter your delivery radius!!!</span> </td>
               </tr>
               <tr>
                 <td>
                   <input type="text" id="vendelradius" name="deliveryradius" class="inputEmail" style="font-family: cambria;" maxlength=2 onchange="checkNumber(this)" placeholder="Enter your delivery radius here"/>
                 </td>
               </tr>
             
           </table>
	    </div>
	    
	    <div style="display: inline-block; width: 49.5%; vertical-align: top;">
	      <table class="tableStyle">
	        <tr>
                 <td> <span class="regText"> Address </span> <span class="errorMessages floatRight" id="vre4">Please enter your address!!!</span> </td>
               </tr>
               <tr>
                 <td>
                   <input type="text" id="venaddress" name="address" class="inputEmail" style="font-family: cambria;" maxlength=100 placeholder="Enter your address here"/>
                 </td>
               </tr>
		 
		 <tr>
                 <td> <span class="regText"> City </span> <span class="errorMessages floatRight" id="vre5">Please enter your city!!!</span> </td>
               </tr>
               <tr>
                 <td>
                   <input type="text" id="vencityname" name="city" class="inputEmail" style="font-family: cambria;" maxlength=50 placeholder="Enter your city here"/>
                 </td>
               </tr>

		 <tr>
                 <td> <span class="regText"> State </span> <span class="errorMessages floatRight" id="vre6">Please enter your state!!!</span> </td>
               </tr>
               <tr>
                 <td>
                   <input type="text" id="venstate" name="state" class="inputEmail" style="font-family: cambria;" maxlength=50 placeholder="Enter your state here"/>
                 </td>
               </tr>
		 
		 <tr>
                 <td> <span class="regText"> Pincode </span> <span class="errorMessages floatRight" id="vre7">Please enter your pincode!!!</span> </td>
               </tr>
               <tr>
                 <td>
                   <input type="text" id="venpincode" name="pincode" class="inputEmail" style="font-family: cambria;" maxlength=6 onchange="checkNumber(this)" placeholder="Enter your pincode here"/>
                 </td>
               </tr>
		 
	      </table>
	    </div>

	    <div style="text-align: center; border-top: 1px solid white; padding: 10px 0px 10px 0px; margin-top: 10px;">
	      <input type="submit" value="Register" class="styledButton" />
	      <input type="reset" value="Reset" class="styledButton" />  
	    </div>
           
         </form>
       </div>
     </div>
   </div>
</div>
';
}

function getUserRegistration(){
$temp = "'re'";
echo '
<div id="dialogRegister" style="display: none;">
  <div class="registerArea" style="margin: 10px; box-shadow: 0px 0px 10px 2px gray;">
     <div class="mainLoginArea">
       <div class="loginHead">
         <span style="float: left;">USER REGISTRATION</span>
         <span style="float: right; margin: -20px -20px 0px 0px; cursor: pointer;" id="regCloseDialog"><img src="images/close.png"/></span>
       </div>
       <div class="width100">
         <form id="registerForm1" action="regCustomer.php" method="post" onsubmit="return formValidate(this.id,'.$temp.',1,2,3);" >
           <table class="tableStyle">
             <tr>
               <td> <span class="regText"> Email-ID </span> <span class="errorMessages floatRight" id="re1">Please enter your Email-ID!!!</span> </td>
             </tr>
             <tr>
               <td>
                 <input type="text" id="regemailid" name="emailid" class="inputEmail" style="font-family: cambria;" maxlength=50 placeholder="Enter your email-id here"/>
               </td>
             </tr>
             <tr>
               <td> <span class="regText"> Password </span> <span class="errorMessages floatRight" id="re2">Please enter your Password!!!</span> </td>
             </tr>
             <tr>
               <td style="padding-bottom: 5px;">
                 <input type="password" id="regpassword" name="password" class="inputPassword" style="font-family: cambria;" maxlength=20 placeholder="Enter your password here"/>
               </td>
             </tr>
             <tr>
               <td> <span class="regText"> Re-Type Password </span> <span class="errorMessages floatRight" id="re3">Please Re-enter your Password!!!</span> </td>
             </tr>
             <tr>
               <td style="padding-bottom: 5px;">
                 <input type="password" id="repassword" name="repassword" class="inputPassword" style="font-family: cambria;" maxlength=20 placeholder="Re-Type your password here"/>
               </td>
             </tr>
             <tr>
               <td> <span class="regText"> Username </span> <span class="errorMessages floatRight" id="re4">Please enter your Name!!!</span> </td>
             </tr>
             <tr>
               <td>
                 <input type="text" id="custName" name="custName" class="inputEmail" style="font-family: cambria;" maxlength=50 placeholder="Enter your name here"/>
               </td>
             </tr>
             <tr>
               <td> <span class="regText"> Mobile No. </span> <span class="errorMessages floatRight" id="re5">Please enter your Mobile Number!!!</span> </td>
             </tr>
             <tr>
               <td style="padding-bottom: 0px;">
                 <div class="mobileArea" >
                   <table>
                     <tr>
                       <td>
			    <div class="mobileCode" style="display: inline-block; vertical-align: top;">+91-</div>
                         <!--<td class="width100" style="vertical-align: top;"> <input type="text" id="mobileNo" name="mobileNo" class="mobileNo" maxlength=10 onchange="checkNumber(this)"/> </td>-->
			    <div style="display: inline-block; vertical-align: top; margin-top: -3px; background: transparent; width: 50px;"> <input type="text" id="mobileNo" name="mobileNo" style="font-family: cambria;" maxlength=10 onchange="checkNumber(this)" class="mobileNo" placeholder="Enter your mobile number here"/> </div>
			  </td>
                     </tr>
                   </table>
                 </div>
               </td>
             </tr>
             <tr>
               <td>
		   <div class="buttonArea">
                   <input type="submit" value="Register" class="styledButton" />
                   <input type="reset" value="Reset" class="styledButton" />  
		   </div>
               </td>
             </tr>
           </table>
         </form>
       </div>
     </div>
   </div>
</div>
';
}

function getAllDialogBodyDefinitions(){
	echo getUserRegistration();
	echo getVendorRegistration();
	echo getUserLogin();
	echo getAdminLogin();
}

function getPageTitle($title, $link){
	return '<a href="'.$link.'" style="color: orange;">'.$title.'</a>';
}

function getMessageDialog($message){
	return '<div style="width: 98%; margin-bottom: 5px; border-top: 1px solid silver; border-bottom: 1px solid silver; background: rgba(0,255,0,0.1); padding: 5px;">'.$message.'</div>';
}

function calculatePopularities($sid){
	//$con = connectDB();
	
	$res = mysql_query("select ItemID from subitems where SubItemID = $sid");
	$row = mysql_fetch_array($res);
	$iid = $row['ItemID'];
	
	$res = mysql_query("select ItemGroupID from itemgroups where ItemID = $iid");
	$row = mysql_fetch_array($res);
	$igid = $row['ItemGroupID'];
	
	$res = mysql_query("select AVG(Popularity) as Pop from subitems where ItemID=$iid");
	$row = mysql_fetch_array($res);
	$pop = $row['Pop'];
	mysql_query("update items set Popularity = $pop where ItemID = $iid");

	$res = mysql_query("select AVG(Popularity) as Pop from items where ItemGroupID=$igid");
	$row = mysql_fetch_array($res);
	$pop = $row['Pop'];
	mysql_query("update itemgroups set Popularity = $pop where ItemGroupID = $igid");
	
	//closeDB($con);
}

?>