<?php
session_start();
if(isset($_SESSION['gs_userid'])){
  $uid = $_SESSION['gs_userid'];
  if(isset($_GET['sid'])){
    $sid = (int)$_GET['sid'];
  }
  
  require_once("funcs/functions.php");
  //$con = connectDB();
  
  $res = mysql_query("select Username from customerdetails where CID='$uid'");
  $row = mysql_fetch_array($res);
  $vendorName = $row['Username'];
  $res = mysql_query("select * from shopdetails where ShopID='$sid' and CID = '$uid'");
  if(mysql_num_rows($res) > 0){
    $row = mysql_fetch_array($res);
    $enterpriseName = $row['EnterpriseName'];
    $entCity = $row['City'];
    $entAddress = $row['Address'];
  }else{
    showMessage("Forbidden Access! You are not previlaged to access this page");
  }
  if(isset($_SESSION['gs_shopitems_stat'])){
    $si_stat = $_SESSION['gs_shopitems_stat'];
    unset($_SESSION['gs_shopitems_stat']);
  }else{
    $si_stat = null;
  }
  
}else{
  $uid = "";
  header("location: index.php");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
<head>
<title><?php echo $enterpriseName; ?> - grocStore</title>
<?php echo includeAllFiles(); ?>

<script>

<?php getJqueryDropdowns(); ?>

function addToList(id){
  var cb = document.getElementById("checkbox" + id);
  var al = document.getElementById("addList");
  //var adr = document.getElementById("addDivRow" + id);
  if(cb.checked){
    al.value = al.value + id + "--";
    //adr.style.background = "rgb(255,239,185)";
  }else{
    var temp = al.value;
    temp = temp.replace(id+"--", "");
    al.value = temp;
    //adr.style.background = "rgb(255,255,255)";
  }
  var cnt = getListCount("add");
  document.getElementById("addSelectCount").innerHTML = "(" + cnt + ")";
}

function addToDeleteList(id){
  var dcb = document.getElementById("delcheckbox" + id);
  var dl = document.getElementById("deleteList");
  //var adr = document.getElementById("delDivRow" + id);
  if(dcb.checked){
    dl.value = dl.value + id + "--";
    //ddr.style.background = "rgb(255,239,185)";
  }else{
    var temp = dl.value;
    temp = temp.replace(id+"--", "");
    dl.value = temp;
    //ddr.style.background = "rgb(255,255,255)";
  }
  var cnt = getListCount("delete");
  document.getElementById("delSelectCount").innerHTML = "(" + cnt + ")";
}

function getListCount(str){
  var l = document.getElementById(str + "List").value;
  var cnt = l.split("--").length-1;
  return cnt;
}

function addMyItems(){
  var al = document.getElementById("addList");
  al.value = al.value.trim();
  if(al.value != ""){
    if(confirm("Are you sure?")){
      return true;
    }
  }else{
    alert("Please select some items");
  }
  return false;
}

function deleteMyItems(){
  var dl = document.getElementById("deleteList");
  dl.value = dl.value.trim();
  if(dl.value != ""){
    if(confirm("Are you sure?")){
      return true;
    }
  }else{
    alert("Please select some items");
  }
  return false;
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
	  <?php echo getPageTitle($enterpriseName,$_SERVER["PHP_SELF"]."?sid=$sid"); ?>
	</div>
	<div style="padding: 5px 20px 5px 5px; float: right; font-size: 12px;">
		<label style="color: white;"><?php echo $entAddress." ".$entCity; ?></label>
	</div>	
	<div style="padding-top: 10px;">
		<?php if($si_stat){ ?>
			<div style="background: green; text-align: center;">
				<div style="padding: 5px; font-size: 20px; display: inline-block; color: yellow;"><?php echo $si_stat; ?></div>
			</div>
		<?php } ?>
		<div style="width: 90%; height: auto; margin: 20px auto 50px auto; box-shadow: 0px 0px 10px 2px gray; border-radius: 10px;">
			<div style="font-weight: bold; background: orange; color: white; padding: 10px; border-radius: 10px 10px 0px 0px; text-align: center;">
				<div style="display: inline-block; width: 40%; border-right: 1px solid gray;">Product Details</div>
				<div style="display: inline-block; width: 30%; border-right: 1px solid gray;">Market Price</div>
				<div style="display: inline-block; width: 28%;">Available Quantity</div>
			</div>
			<form action="addStoreItems.php" method="post" onsubmit="return addMyItems();">
			<div style="width: 100%; height: 300px; overflow: auto; background: white;">
			<?php
				$q = "select * from subitems where SubItemID not in (select SubItemID from shopitems where ShopID='$sid')";
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
						<div style="display: inline-block;">
							<input type="checkbox" id="checkbox<?php echo $subItemID; ?>" name="checkbox" onclick="addToList(<?php echo $subItemID; ?>);" />
						</div>
						<div style="display: inline-block; vertical-align: top;">
							<label>
								<div style="font-weight: bold;"><?php echo $itemName; ?></div>
								<div><?php echo $subString; ?></div>
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
			<div style="padding: 5px; font-weight: bold; height: 30px; background: orange; color: white; border-radius: 0px 0px 10px 10px; float: left;">
				<label style="display: inline-block; float: left; padding: 0px 10px 0px 10px;">
					<input type="hidden" name="addList" id="addList" />
					<input type="submit" value="Add Selected Items" style="border: 0px; text-decoration: blue; color: blue; background: transparent; cursor: pointer; font-weight: bold;" /> <label style="color: blue;" id="addSelectCount">(0)</label>
				</label>
				<label style=""><input type="hidden" value="<?php echo $sid; ?>" name="shopId"/></label>
			</div>
			<div style="padding: 5px 10px 5px 10px; font-weight: bold; height: 30px; background: orange; color: white; border-radius: 0px 0px 10px 10px; float: right;">
				Total Items: <?php echo $itemsAvail; ?>
			</div>
			</form>
		</div>
		<div style="text-align: left; margin-left: 50px;">
			<label style="color: white; font-weight: bold; font-size: 20px; text-decoration: underline;">Items Available</label>
		</div>
		<div style="width: 90%; height: auto; margin: 20px auto 50px auto; box-shadow: 0px 0px 10px 2px gray; border-radius: 10px;">
			<div style="font-weight: bold; background: orange; color: white; padding: 10px; border-radius: 10px 10px 0px 0px; text-align: center;">
				<div style="display: inline-block; width: 40%; border-right: 1px solid gray;">Product Details</div>
				<div style="display: inline-block; width: 30%; border-right: 1px solid gray;">Market Price</div>
				<div style="display: inline-block; width: 28%;">Available Quantity</div>
			</div>
			<form action="deleteStoreItems.php" method="post" onsubmit="return deleteMyItems();">
			<div style="width: 100%; height: 300px; overflow: auto; background: white;">
			<?php
				$q = "select * from subitems where SubItemID in (select SubItemID from shopitems where ShopID='$sid')";
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
				<label>
				<div style="width: 98.5%; border-bottom: 1px solid silver; padding: 5px;" class="divRows" id="delDivRow<?php echo $subItemID; ?>">
					<?php
						if($type == "P"){
							$value = 50;
							$units = " packet";
						}else{
							$value = 100;
							$units = " kgs";
						}
					?>
					<div style="display: inline-block; padding: 0px 10px 0px 10px;">
						<label> <input type="checkbox" id="delcheckbox<?php echo $subItemID; ?>" name="delcheckbox" onclick="addToDeleteList(<?php echo $subItemID; ?>);" /> </label>
					</div>
					<div style="display: inline-block; width: 36%; vertical-align: top;">
						<label style="display: inline-block;">
							<div style="font-weight: bold;"><?php echo $itemName; ?></div>
							<div><?php echo $subString; ?></div>
						</label>
					</div>
					<div style="display: inline-block; width: 30%; vertical-align: top;">
						<label style=""> <div style="">Rs. <?php echo $price; ?> / <?php echo $units; ?></div><div>My Price - Rs. <?php echo $price; ?></div> </label>
					</div>
					<div style="display: inline-block; width: 24%; text-align: center;">
						<label style=""> <?php echo $value ?> <?php echo $units."s"; ?> </label>
					</div>
				</div>
				</label>
			<?php
				}
				if($itemsAvail == 0){
					echo '<div style="text-align: center; font-size: 32px; font-weight: bold; color: silver; margin-top: 100px;">No items in your shop</div>';
				}
			?>
			</div>
			<div style="padding: 5px; font-weight: bold; height: 30px; background: orange; color: white; border-radius: 0px 0px 10px 10px; float: left;">
				<label style="display: inline-block; float: left; padding: 0px 10px 0px 10px;">
					<input type="hidden" name="deleteList" id="deleteList" />
					<input type="submit" value="Delete Selected Items" style="border: 0px; text-decoration: blue; color: blue; background: transparent; cursor: pointer; font-weight: bold;" /> <label style="color: blue;" id="delSelectCount">(0)</label>
				</label>
				<label style=""><input type="hidden" value="<?php echo $sid; ?>" name="shopId"/></label>
			</div>
			</form>
			<div style="padding: 5px; font-weight: bold; height: 30px; background: orange; color: white; border-radius: 0px 0px 10px 10px; float: right;">
				<label style="display: inline-block; float: right; padding: 0px 10px 0px 10px;">
					Total Items: <?php echo $itemsAvail; ?>
				</label>
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

