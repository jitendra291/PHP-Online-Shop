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
<title>Personal Details - GrocStore</title>
<?php echo includeAllFiles(); ?>

<script>

<?php getJqueryDropdowns(); ?>

</script>

</head>

<body onload="init()">
<div class="mainArea">
 <?php showHeader($uid,""); ?>
 <div class="rest">
   <div class="personalDetailsArea">
     <div id="dialogRegister">
       <div style="width: 100%; height: 40px; background: white; color: black; border-radius: 10px 10px 0px 0px; box-shadow: 0px 0px 10px 2px gray inset; text-align: center; font-size: 24px; font-weight: bold; padding-top: 5px;">
	  <?php echo getPageTitle("Personal Details",$_SERVER["PHP_SELF"]); ?>
	</div>
	
  <div class="pDArea">
     <div class="mainLoginArea">
	<?php
	  $res = mysql_query("select Email,Username,Phone from customerdetails where CID='$uid'");
	  $row = mysql_fetch_array($res);
	  
	?>
       <div class="width100" style="padding-top: 10px; border-right: 1px solid white;">
         <form action="updatePersonalDetails.php" method="post" onsubmit="return validate();" >
           <table class="tableStyle">
             <tr>
               <td> <span class="regText"> Username </span> <span class="errorMessages" id="error4">Please enter your Name!!!</span> </td>
             </tr>
             <tr>
               <td>
                 <input type="text" id="custName" value="<?php echo $row['Username']; ?>" name="custName" class="inputEmail" maxlength=30/>
               </td>
             </tr>
             <tr>
               <td> <span class="regText"> Mobile No. </span> <span class="errorMessages" id="error5">Please enter your Mobile Number!!!</span> </td>
             </tr>
             <tr>
               <td style="padding-bottom: 5px;">
                 <div class="mobileArea" >
                   <table>
                     <tr>
                       <td class="mobileCode">+91</td>
                       <td class="width100"> <input type="text" id="mobileNo" value="<?php echo $row['Phone']; ?>" name="mobileNo" class="mobileNo" maxlength=10 onchange="checkNumber(this)"/> </td>
                     </tr>
                   </table>
                 </div>
               </td>
             </tr>
             <tr>
               <td>
		   <div class="buttonArea">
                   <input type="submit" value="Update" class="styledButton" style="width: 200px; height: 40px; font-size: 20px;" />
		   </div>
               </td>
             </tr>
           </table>
         </form>
       </div>
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
