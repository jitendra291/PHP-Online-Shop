<?php
session_start();
if(isset($_SESSION['gs_reg_status'])){
  $regstatus = $_SESSION['gs_reg_status'];
  unset($_SESSION['gs_reg_status']);
}else{
  $regstatus = "";
  header("location: index.php");
}

if(isset($_SESSION['gs_userid'])){
  $uid = $_SESSION['gs_userid'];
}else{
  $uid = "";
}

require_once("funcs/functions.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
<head>
<title>Welcome to Online Shop - Registration</title>
<?php echo includeAllFiles(); ?>

<script>
var $dialog5;
$(function(){
	<?php getAllJqueryDialogs(); ?>
})(jQuery);
</script>

</head>

<body>
<div class="mainArea">
 <?php echo showHeader($uid,""); ?>

 <div style="width: 1000px; margin: 0px auto 0px auto; background: #36c5d8; border-radius: 0px 0px 10px 10px;">
   <div style="color: yellow; padding: 10px; font-size: 20px;"> <?php echo $regstatus; ?> </div>
 </div>

 <?php echo showFooter(); ?>

</div>

<?php echo getAllDialogBodyDefinitions(); ?>

</body>
</html>