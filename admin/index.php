<?php
session_start();
if(isset($_SESSION['gs_admin'])){
  $aid = $_SESSION['gs_admin'];
  require_once("../funcs/functions.php");
  require_once("functions.php");
  
}else{
  $aid = "";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
<head>
<title>Online Shop - Admin Portal</title>
<link rel="stylesheet" href="../styles/adminstyles.css" media="all"></link>

<script>

function goto(loc){
  window.location.href = loc + ".php";
}

function init(){
  document.getElementById("email").focus();
}

</script>
</head>
<body onload="init();">

<?php if($aid == ""){ ?>
  <div style="background: #36c5d8; color: white; border-radius: 5px; width: 250px;position:absolute;left: 40%;top:20%;">
    <div style="border-top-left-radius: 5px; border-top-right-radius: 5px; background: rgba(255,255,255,0.4); padding: 5px; font-weight: bold; text-align: center; color: black;">Login</div>
    <div style="padding: 5px;">
      <form action="adminLogin.php" method="post">
        <table>
          <tr> <td>Email</td> <td><input type="text" id="email" name="email" style="border: 0px; border-radius: 2px; outline: none; padding-left: 2px;"/></td> </tr>
          <tr> <td>Password</td> <td><input type="password" id="password" name="password" style="border: 0px; border-radius: 2px; outline: none; padding-left: 2px;"/></td> </tr>
          <tr>
	     <td colspan=2 style="border-top: 1px solid white; text-align: center; padding-top: 5px;">
		<input type="submit" value="Login" style="border: 0px; border-radius: 5px; padding: 5px 20px 5px 20px; font-weight: bold; cursor: pointer;"/>
		<input type="reset" value="Reset" style="border: 0px; border-radius: 5px; padding: 5px 20px 5px 20px; font-weight: bold; cursor: pointer;"/>
	     </td>
	   </tr>
        </table>
      </form>
    </div>
  </div>
<?php
  }else{
    $q = "select * from admin where AID='$aid'";
    $res = mysql_query($q);
    $row = mysql_fetch_array($res);
    $cb = $row['CreatedBy'];
    $email = $row['Email'];
?>
  <div style="border-bottom: 1px solid #36c5d8; text-align: center; font-size: 20px; font-weight: bold;">
    Welcome <?php echo $email; ?>
  </div>
  <?php showNavigation(); ?>
  
  <div style="text-align: center;">
    <?php
      if($cb != 0){
	 $q = "select Email from admin where AID='$cb'";
	 $res = mysql_query($q);
	 $row = mysql_fetch_array($res);
	 echo "This account is created by <u>".$row['Email']."</u>.";
      }
    ?>
  </div><div style="width: 90%; height: auto; margin: 20px auto 50px auto; box-shadow: 0px 0px 10px 2px gray; border-radius: 10px;">
			<div style="font-weight: bold; background: orange; color: white; padding: 10px; border-radius: 10px 10px 0px 0px; text-align: center;">
				<div style="display: inline-block; width: 40%; border-right: 1px solid gray;">Product Details</div>
				<div style="display: inline-block; width: 30%; border-right: 1px solid gray;">Market Price</div>
				<div style="display: inline-block; width: 28%;">Available Quantity</div>
			</div>
			<form action="addStoreItems.php" method="post" onsubmit="return addMyItems();">
			<div style="width: 100%; height: 450px; overflow: auto; background: white;">
			<?php
				$q = "select * from subitems where SubItemID !=''";
				$res = mysql_query($q);
				$itemsAvail = mysql_num_rows($res);
				while($row = mysql_fetch_array($res)){
					$subItemID = $row['SubItemID'];
					$itemID = $row['ItemID'];
					$res1 = mysql_query("select * from items where ItemID='$itemID'");
					$row1 = mysql_fetch_array($res1);
					$itemName = $row1['ItemName'];
					$subItemName = $row['SubItemName'];
					$quantity = $row['Quantity'];
					$price = $row['Price'];
					$type = $row['Type'];
					if($type == "P"){
						$subString = "<div style='font-size: 12px;'>".$subItemName." ".$quantity."gms </div>";
					}else{
						$subString = "<div style='font-size: 12px;'>".$subItemName." 1</div>";
					}
			?>
				<div style="width: 100%; height: auto; border-bottom: 1px solid silver;" id="addDivRow<?php echo $subItemID; ?>">
					<?php
						if($type == "P"){
							$value = 50;
							$units = " packet";
						}else{
							$value = 100;
							$units = " kgs";
						}
					?>
					<label class="divRows" style="display: inline-block; padding: 5px; width: 40%;">
						
						<div style="display: inline-block; vertical-align: top;">
							<label>
								<div style="font-weight: bold;"><?php echo $itemName; echo $itemID;?></div>
								
							</label>
						</div>
					</label>
					<label class="divRows" style="display: inline-block; width: 30%; vertical-align: top;">
						<label>
							<div style="font-weight: bold;">Rs. <?php echo $price; ?> / <?php echo $units; ?></div>
							<div>My Price - Rs. <input type="text" id="myprice<?php echo $subItemID ?>" name="myprice<?php echo $subItemID; ?>" size=2 style="text-align: center;" value="<?php echo $price; ?>"/></div>
						</label>
					</label>
					<label class="divRows" style="display: inline-block; width: 24%; text-align: center;">
						<label>Minimum <input type="text" id="avail<?php echo $subItemID ?>" name="avail<?php echo $subItemID ?>" size=2 maxlength=4 style="text-align: center;" value="<?php echo $value ?>"/><?php echo $units."s"; ?></label>
					</label>
				</div>
			<?php
				}
				if($itemsAvail == 0){
					echo '<div style="text-align: center; font-size: 32px; font-weight: bold; color: silver; margin-top: 100px;">Oops! No items found</div>';
				}
			?>
			</div>
			
			<div style="padding: 5px 10px 5px 10px; font-weight: bold; height: 30px; background: orange; color: white; border-radius: 0px 0px 10px 10px; float: right;">
				Total Items: <?php echo $itemsAvail; ?>
			</div>
			</form>
		</div>
  
<?php }  ?>

</body>
</html>