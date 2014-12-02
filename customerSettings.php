<?php

session_start();
if(isset($_SESSION['gs_userid'])){
  $uid = $_SESSION['gs_userid'];
}else{
  header("location: index.php");
}

if(isset($_SESSION['pass_stat'])){
  $ps = $_SESSION['pass_stat'];
  unset($_SESSION['pass_stat']);
}else{
  $ps = null;
}

require_once('funcs/functions.php');
//connectDB();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
<head>
<title>Settings - grocStore</title>
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
	  <?php echo getPageTitle("Settings",$_SERVER["PHP_SELF"]); ?>
	</div>
	
	<?php
	  if($uid){
	?>
	<form id="settingsForm1" method="post" action="changeSettings.php" onsubmit="return formValidate(this.id,'se',1,2,3);">
	<div style="width: 450px; margin: 10px auto 10px auto; color: orange; background: white; box-shadow: 0px 0px 10px 2px gray; padding: 10px; border-radius: 10px;">
	  <?php if($ps){ echo getMessageDialog($ps); } ?>
	  <div style="padding: 5px; border-bottom: 1px solid silver;">
	    <div style="display: inline-block; width: 40%;">Current Password </div>
	    <div style="display: inline-block;"><input type="password" name="currpass" value"<?php ?>" class="inputEmail"/></div>
	    <div id="se1" class="errorMessages" style="">Field Empty!</div>
	  </div>
	  <div style="padding: 5px;">
	    <div style="display: inline-block; width: 40%;">New Password</div>
	    <div style="display: inline-block;"><input type="password" name="newpass" value"<?php ?>" class="inputEmail"/></div>
	    <div id="se2" class="errorMessages">Field Empty!</div>
	  </div>
	  <div style="padding: 5px; border-bottom: 1px solid silver;">
	    <div style="display: inline-block; width: 40%;">Re-Type New Password</div>
	    <div style="display: inline-block;"><input type="password" name="renewpass" value"<?php ?>" class="inputEmail"/></div>
	    <div id="se3" class="errorMessages">Field Empty!</div>
	  </div>
	  <div style="text-align: center; margin-top: 10px;">
	    <div style="display: inline-block;"><input type="submit" value="Change" class="styledButton"/></div>
	    <div style="display: inline-block;"><input type="reset" value="Reset" class="styledButton"/></div>
	  </div>
	</div>
	</form>
	<?php
	  }
	?>
	
       <div style="width: 100%; height: 100px; background: white; box-shadow: 0px 0px 10px 2px gray inset; border-radius: 0px 0px 10px 10px; margin-top: 10px;">
	  <?php echo showFooter(); ?>
	</div>
     </div>
   </div>
 </div>

</div>

</body>
</html>
