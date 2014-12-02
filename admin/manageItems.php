<?php
session_start();
if(isset($_SESSION['gs_admin'])){
  $aid = $_SESSION['gs_admin'];
}else{
  $aid = "";
  header("location: index.php");
}
//require_once("../funcs/functions.php");
require_once("functions.php");
//$con = mysql_connect("localhost","user10","user10","user10") or die("Connection Error");
$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
 $selected = mysql_select_db("shopping_portal2",$link) 
  or die("Could not select examples");
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
<head>
<title>Online Shop- Manage Items</title>
<link rel="stylesheet" href="../styles/adminstyles.css" media="all"></link>

<script>

function showAddNewItemForm(igc){
  var frm = document.getElementById("addNewItem" + igc).style;
  if(frm.display == "block"){
    frm.display = "none";
  }else{
    frm.display = "block";
  }
}

function showItemGroup(igc){
  var frm = document.getElementById("itemGroup" + igc).style;
  if(frm.display == "block"){
    frm.display = "none";
  }else{
    frm.display = "block";
  }
}

function showSubItemForm(iid){
  var frm = document.getElementById("addSubItem" + iid).style;
  if(frm.display == "block"){
    frm.display = "none";
  }else{
    frm.display = "block";
  }
}

function deleteStuff(iid, table){
  if(confirm("Are you sure?")){
    var xmlhttp;
    if(window.XMLHttpRequest){
      xmlhttp=new XMLHttpRequest();
    }else{
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange=function(){
      if(xmlhttp.readyState==4 && xmlhttp.status==200){
	 var responseVal = xmlhttp.responseText;
	 updateLog(responseVal);
      }
    }
    xmlhttp.open("POST","delete.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("itemID=" + iid + "&table=" + table);
  }
}

function updateStuff(obj, iid, attr, table){
 var xmlhttp;
 if(window.XMLHttpRequest){
   xmlhttp=new XMLHttpRequest();
 }else{
   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 }
 
 xmlhttp.onreadystatechange=function(){
   if(xmlhttp.readyState==4 && xmlhttp.status==200){
	var responseVal = xmlhttp.responseText;
	updateLog(responseVal);
   }
 }
 xmlhttp.open("POST","update.php",true);
 xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
 xmlhttp.send("itemID=" + iid + "&itemVal=" + obj.value + "&attr=" + attr + "&table=" + table);
}

function updateLog(message){
  var lm = document.getElementById("logMessages");
  lm.innerHTML = message + lm.innerHTML;
}

function goto(loc){
  window.location.href = loc + ".php";
}

</script>
</head>
<body>

<?php
  $q = "select * from admin where AID='$aid'";
  $res = mysql_query($q);
  $row = mysql_fetch_array($res);
  $email = $row['Email'];
?>
  <div style="border-bottom: 1px solid #36c5d8; text-align: center; font-size: 20px; font-weight: bold;">
    Welcome <?php echo $email; ?>
  </div>
  <?php showNavigation(); ?>

<div style="">
<?php
  $q = "select ItemGroupName, ItemGroupID from itemgroups order by ItemGroupName";
 // echo $q;
  $res = mysql_query($q);
  $igcount = 0;
  while($row = mysql_fetch_array($res)){
    $igcount++;
    $ign = $row['ItemGroupName'];
	$igno= $row['ItemGroupID'];
?>
  <div style="">
    <div style="height: 30px; font-size: 20px; color: white; font-weight: bold; background: #36c5d8; margin-bottom: 5px; padding: 5px; border-radius: 5px;">
      <div style="display: inline-block; cursor: pointer;" onclick="showItemGroup(<?php echo $igcount; ?>);"><?php echo $ign; ?></div>
      <div class="adminLinks" style="display: inline-block;" onclick="showAddNewItemForm(<?php echo $igcount; ?>);">+Add New Item</div>
    </div>
  </div>
  <div style="">
    <div id="addNewItem<?php echo $igcount; ?>" class="addNewItem">
      <form enctype="multipart/form-data" action="addNewItem.php" method="post">
	 <table>
	   <tr> <td>Item Name</td>       <td><input type="text" id="newItemName" name="newItemName" /></td> </tr>
	   <tr> <td>Alter Name</td>      <td><input type="text" id="newAlterName" name="newAlterName" /></td> </tr>
	   <tr> <td>Specific Name</td>   <td><input type="text" id="newSpecificName" name="newSpecificName" /></td> </tr>
	   <tr> <td>Manufacturer</td>    <td><input type="text" id="newManufacturer" name="newManufacturer" /></td> </tr>
	   <tr> <td>Quantity</td>    <td><input type="text" id="quantity" name="quantity" /></td> </tr>
	   <tr> <td>Price</td>    <td><input type="text" id="quantity" name="price" /></td> </tr>
	   <tr> <td>Item Group Name</td> <td><input type="text" id="newItemGroupName" name="newItemGroupName" value="<?php echo $ign; ?>" disabled/></td> </tr>
	   <tr> <td>Image</td>           <td><input type="file" name="newImage" /></td> </tr>
	   <input type="hidden" name="igno" value="<?php echo $igno; ?>"/>
	   <tr> <td colspan=2><input type="submit" value="Add Item" /></td> </tr>
	 </table>
      </form>
    </div>
    <div id="itemGroup<?php echo $igcount; ?>" style="display: none;">
      <?php
	 $q = "select * from items where ItemGroupID='$igno' order by ItemName";
	 $res1 = mysql_query($q);
	 while($row1 = mysql_fetch_array($res1)){
	   $iid = $row1['ItemID'];
	   $itemName = $row1['ItemName'];
	   $q = "select * from subitems where ItemID='$iid' order by SubItemName";
	   $res2 = mysql_query($q) ;
	   $i=0;
      ?>
	 <div style="width: 62%; height: auto; background: rgb(230,230,230); margin-bottom: 2px; padding: 5px; border-radius: 5px;">
	   <div style="border-bottom: 1px solid white;">
	     <?php
		$imagePath = "../images/product/$iid.jpg";
		if(file_exists($imagePath)){
		  $imageString = "<a href='$imagePath'><label class='deleteLink'>View Image</label></a>";
		}else{
		  $imageString = "";
		}
	     ?>
	     <div style="display: inline-block;"><input type="text" style="border: 0px; background: transparent; color: black; font-weight: bold;" value="<?php echo $itemName; ?>" onblur="updateStuff(this, <?php echo $iid; ?>,'ItemName', 'items');"/><?php echo $imageString; ?></div>
	     <div class="deleteLink" style="color: red;" onclick="deleteStuff(<?php echo $iid; ?>, 'items');">Delete</div>
	   </div>
	   <div>
	     <table>
		<?php
		  while($row2 = mysql_fetch_array($res2)){
		    $i++;
		    $sid = $row2['SubItemID'];
		    $subItemName = $row2['SubItemName'];
		    $quantity = $row2['Quantity'];
		    $price = $row2['Price'];
		    $type = $row2['Type'];
		?>
		  <tr style="color: black;">
		    <td><?php echo $i."."; ?></td>
		    <td style="padding: 0px 10px 0px 10px; border-right: 1px solid white;"><input type="text" title="Sub Item Name" value="<?php echo $subItemName; ?>" onblur="updateStuff(this, <?php echo $sid; ?>, 'SubItemName', 'subitems');" /></td>
		    <td style="padding: 0px 10px 0px 10px; border-right: 1px solid white;">
		      <select onchange="updateStuff(this, <?php echo $sid; ?>, 'Type', 'subitems');">
			 <option value="P" <?php if($type == "P"){ echo "selected"; } ?> >Packed</option>
			
		      </select>
		    </td>
		    <td style="padding: 0px 10px 0px 10px; border-right: 1px solid white;"><input type="text" title="Quantity" value="<?php echo $quantity; ?>" size="5" onblur="updateStuff(this, <?php echo $sid; ?>, 'Quantity', 'subitems');" /> Packets </td>
		    <td style="padding: 0px 10px 0px 10px; border-right: 1px solid white;">Rs. <input type="text" title="Price" value="<?php echo $price; ?>" size="5" onblur="updateStuff(this, <?php echo $sid; ?>, 'Price', 'subitems');" /></td>
		    <td style="padding: 0px 10px 0px 10px;"><div class="deleteLink" onclick="deleteStuff(<?php echo $sid; ?>, 'subitems');">Delete</div></td>
		  </tr>
		<?php } ?>
	     </table>
	     <table>
		<tr>
		  <td>
		    <div class="adminLinks" style="float: left;" onclick="showSubItemForm(<?php echo $iid; ?>);">+Add Sub Item</div>
		    <div class="addNewSubItem" id="addSubItem<?php echo $iid; ?>">
		      <form action="addSubItem.php" method="post">
			 <table>
			   <tr> <td>Sub Item Name</td>       <td><input type="text" id="newSubItemName" name="newSubItemName" /></td> </tr>
			   <tr> <td>Quantity</td> <td><input type="text" id="newQuantity"    name="newQuantity" />   </td> </tr>
			   <tr> <td>Price</td>               <td><input type="text" id="newPrice"       name="newPrice" />      </td> </tr>
			   <tr>
			     <td>Type</td>
			     <td>
				<select name="newType">
				  <option value="P">Packed</option>
				</select>
				<input type="hidden" name="itemid" value="<?php echo $iid; ?>" />
			     </td>
			   </tr>
			   <tr> <td colspan=2><input type="submit" value="Add Sub Item" /></td> </tr>
			 </table>
		      </form>
		    </div>
		  </td>
		</tr>
	     </table>
	   </div>
	 </div>
      <?php
        }
      ?>
    </div>
<?php
  }
?>
</div>

<!--<div style="color: white; position: fixed; bottom: 0px; right: 0px; width: 400px; height: 150px; background: rgba(150,150,150,0.6); font-size: 12px; pointer-events: none; padding: 5px; border-top-left-radius: 10px;">
  <div style="border-top-left-radius: 10px; border-bottom: 1px solid white; padding: 2px; font-size: 16px; color: ;">Activity</div>
  <div style="padding: 2px; overflow: auto; height: 120px;" id="logMessages">
  </div>
</div>-->

<?php //closeDB($con); ?>

</body>
</html>