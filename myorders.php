<?php

session_start();
if(isset($_SESSION['gs_userid'])){
  $uid = $_SESSION['gs_userid'];
  
  if(isset($_SESSION['placed_order_id'])){
    $poi = $_SESSION['placed_order_id'];
    unset($_SESSION['placed_order_id']);
  }else{
    $poi = "";
  }
  
  require_once('funcs/functions.php');
  //$con = connectDB();
}else{
  header("location: index.php");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
<head>
<title>My Orders - Online Shop</title>
<?php echo includeAllFiles(); ?>

<script>

<?php getJqueryDropdowns(); ?>

function openOrderList(orderID){
	var temp = document.getElementById("viewOrderList" + orderID);
	var temp1 = 	document.getElementById("viewItemsLink" + orderID);
	if(temp.style.display == "block"){
		temp.style.display = "none";
		temp1.innerHTML = "View Items";
	}else{
		temp.style.display = "block";
		temp1.innerHTML = "Hide Items";
	}
}

function cancelOrder(orderID){
	if(confirm("Are you sure?")){
		window.location = "orderListRemove.php?oloid=" + orderID;
	}
}

function showOrderList(status){
  var os1 = document.getElementById("orderStatus1");
  var os2 = document.getElementById("orderStatus2");
  var os3 = document.getElementById("orderStatus3");
  if(status == 1){
	os1.className = "orderStatusButtons orderStatusButtonsClicked";
	os2.className = "orderStatusButtons";
	os3.className = "orderStatusButtons";
  }else if(status == 2){
	os1.className = "orderStatusButtons";
	os2.className = "orderStatusButtons orderStatusButtonsClicked";
	os3.className = "orderStatusButtons";
  }else{
	os1.className = "orderStatusButtons";
	os2.className = "orderStatusButtons";
	os3.className = "orderStatusButtons orderStatusButtonsClicked";
  }
  $(document).ready(function(){
    //var mdTables = $("#mainDisplay > label");
    //var $rowCount = mdTables.size();
    //alert($rowCount);
    
    var i=1;
    var dispCount=0;
    $("#mainDisplay > label").each(function(){
      if((this.id) == ("row" + i + "_" + status)){
        $("#"+this.id).css("display", "block");
        dispCount++;
      }else{
        $("#"+this.id).css("display", "none");
      }
      i++;
    });
    
    if(dispCount == 0){
      $("#emptyListMessage").css("display","block");
      $("#emptyListMessageText").text("No Orders");
    }else{
      $("#emptyListMessage").css("display","none");
    }
    
  });
  
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
	  <?php echo getPageTitle("My Orders",$_SERVER["PHP_SELF"]); ?>
	</div>
	<?php if($poi != ""){ ?>
	  <div style="color: yellow; margin: 10px 10px 20px 10px; font-size: 20px; background: green; box-shadow: 0px 0px 2px 1px white inset; border-radius: 10px;">
	    <div style="padding: 10px;">Order placed successfully!!! Order ID: <?php echo $poi; ?></div>
	  </div>
	<?php } ?>
       <div style="margin: 10px 0px 10px 10px; color: white; border-bottom: 1px solid orange; width: 98%;">
	  <div class="orderStatusButtons orderStatusButtonsClicked" onclick="showOrderList(1);" id="orderStatus1">In-Progress Orders</div>
	  <div class="orderStatusButtons" onclick="showOrderList(2);" id="orderStatus2">Delivered Orders</div>
	  <div class="orderStatusButtons" onclick="showOrderList(3);" id="orderStatus3">Cancelled Orders</div>
       </div>
       <div style="width: 98%; margin-top: 10px; margin-left: auto; margin-right: auto; text-align: center; background: white; border-radius: 5px 5px 0px 0px; box-shadow: 0px 0px 4px 1px gray ;">
         <table class="width100">
           <tr style="width: 100%; height: 30px;">
             <td style="width: 10%; border-right: 1px solid silver;">Order ID</td>
             <td style="width: 25%; border-right: 1px solid silver;">Name</td>
             <td style="width: 10%; border-right: 1px solid silver;">Date</td>
             <td style="width: 10%; border-right: 1px solid silver;">Time</td>
             <td style="width: 20%; border-right: 1px solid silver;">Status</td>
             <td style="width: 25%;">Address</td>
           </tr>
         </table>
       </div>
       <div style="width: 98%; margin-top: 2px; margin-left: auto; margin-right: auto; text-align: center; color: white;">
         <div class="width100" id="mainDisplay">
           <?php
             $res = mysql_query("select * from orders where CID='$uid' order by OrderID desc");
               $completeAddress = "";
		 $totalRowCount = 0;
		 $displayedRows = 0;
               while($row = mysql_fetch_array($res)){
                 $totalRowCount = $totalRowCount + 1;
		   $addressid = $row['AddressID'];
                 $r = mysql_query("select * from customeraddress where AddressID='$addressid'");
		   $addRow = mysql_fetch_array($r);
		   $completeAddress = $addRow['Address']."<br/>";
		   $completeAddress = $completeAddress.$addRow['City']."<br/>";
		   $completeAddress = $completeAddress.$addRow['State']."<br/>";
		   $completeAddress = $completeAddress."Pincode: ".$addRow['Pincode']."<br/>";
		   $completeAddress = $completeAddress."Mobile: +91-".$addRow['Phone']."<br/>";
           ?>
	     <?php  ?>
	     <?php if($row['Status'] == 5){ ?>
             <label style="display: none;" id="row<?php echo $totalRowCount.'_2'; ?>">
	     <?php }else if($row['Status'] == 6){ ?>
	      <label style="display: none;" id="row<?php echo $totalRowCount.'_3'; ?>">
	     <?php }else{ $displayedRows = $displayedRows + 1; ?>
	      <label style="display: block;" id="row<?php echo $totalRowCount.'_1'; ?>">
	     <?php } ?>
	       <table class="width100" style="border-bottom: 1px solid white;">
              <tr style="width: 100%; height: 30px; vertical-align: top;">
               <td style="width: 10%;">
		   <div><?php echo $row['OrderID']; ?><div>
		   <?php if(($row['Status']!=5) && ($row['Status']!=6)){ ?>
		     <div id="viewItemsLink<?php echo $row['OrderID']; ?>" style="" class="myordersViewList" onclick="openOrderList(<?php echo $row['OrderID']; ?>)">View Items</div>
		     <div><a href="#" class="myordersViewList" onclick="cancelOrder(<?php echo $row['OrderID']; ?>);">Cancel</a></div>
                 <?php }else if($row['Status']!=6){ ?>
		     <div id="viewItemsLink<?php echo $row['OrderID']; ?>" style="" class="myordersViewList" onclick="openOrderList(<?php echo $row['OrderID']; ?>)">View Items</div>
		   <?php } ?>
		 </td>
               <td style="width: 25%;"><?php echo $row['OrderName']; ?></td>
               <td style="width: 10%;"><?php echo $row['Date']; ?></td>
               <td style="width: 10%;"><?php echo $row['Time']; ?></td>
               <td style="width: 20%;"><?php echo getStatusString($row['Status']); ?></td>
               <td style="width: 25%; text-align: left; font-size: 12px;"><?php echo $completeAddress; ?></td>
              </tr>
		<tr>
		  <?php
		    $orderID = $row['OrderID'];
		    $res1 = mysql_query("select SubItemID,Quantity from orderlist where OrderID='$orderID'");
		    $no_of_items = mysql_num_rows($res1);
		    $ostatus = $row['Status'];
		    if($ostatus != 6){
		  ?>
		    <td colspan=4>
			<div style="width: 100%; display: none;" id="viewOrderList<?php echo $orderID; ?>">
				<div style="width: 100%; color: white; font-weight: bold; background: orange; border-radius: 10px 10px 0px 0px; box-shadow: 0px 0px 5px 1px gray inset; padding: 5px;">
					<div style="display: inline-block; width: 35%; border-right: 1px solid gray;">Item Details</div>
					<div style="display: inline-block; width: 25%; border-right: 1px solid gray;">Item Price</div>
					<div style="display: inline-block; width: 15%; border-right: 1px solid gray;">Quantity</div>
					<div style="display: inline-block; width: 20%;">Sub Total</div>
				</div>
				<?php
					$grandTotal = 0;
					while($row1 = mysql_fetch_array($res1)){
						$subItemId = $row1['SubItemID'];
						$userQuantity = $row1['Quantity'];
						$res2 = mysql_query("select * from subitems where SubItemID=$subItemId");
						$row2 = mysql_fetch_array($res2);
						$itemId = $row2['ItemID'];
						$type = $row2['Type'];
						$subItemName = $row2['SubItemName'];
						$itemPrice = $row2['Price'];
						$itemQuantity = $row2['Quantity'];
						$res3 = mysql_query("select ItemName from items where ItemID='$itemId'");
						$row3 = mysql_fetch_array($res3);
						$itemName = $row3['ItemName'];
						if($type == "P"){
							$subTotal = $userQuantity * $itemPrice;
						}else{
							$subTotal = ($userQuantity/1000) * $itemPrice;
						}
						$grandTotal += $subTotal;
				?>
				<div style="width: 100%; color: black; padding: 5px; background: white; box-shadow: 0px 0px 5px 1px gray inset; font-size: 12px;">
					<div style="display: inline-block; width: 35%; border-right: 1px solid silver; text-align: left; font-weight: bold;"><?php echo $itemName; ?></div>
					<div style="display: inline-block; width: 25%; border-right: 1px solid silver; text-align: left;">Rs.
						<?php
							if($type == "P"){
								echo $itemPrice." per Packet";
							}else{
								echo $itemPrice." per Kg";
							}
						?>
					</div>
					<div style="display: inline-block; width: 15%; border-right: 1px solid silver;">
						<?php
							if($type == "P"){
								echo $userQuantity." Packet(s)";
							}else{
								echo getQuantityWithUnits($userQuantity);
							}
						?>
					</div>
					<div style="display: inline-block; width: 20%; text-align: right;">Rs. <?php echo $subTotal; ?></div>
				</div>
				<?php
					}
				?>
				<div style="width: 100%; color: black; padding: 5px; background: silver; box-shadow: 0px 0px 5px 1px gray inset; font-size: 12px;">
					<div style="display: inline-block; width: 77%; text-align: left; font-weight: bold;">Grand Total</div>
					<div style="display: inline-block; width: 20%; text-align: right; font-weight: bold;">Rs. <?php echo $grandTotal; ?></div>
				</div>
			</div>
		    </td>
		  <?php } ?>
		</tr>
	       </table>
             </label>

           <?php
             }
           ?>
	    <?php if($displayedRows == 0){ ?>
	      <div id="emptyListMessage" style="display: block;">
           <?php }else{ ?>
             <div id="emptyListMessage" style="display: none;">
           <?php } ?>
               <table class="width100" style="border-bottom: 1px solid white;">
                 <tr style="width: 100%; height: 30px; vertical-align: top;">
                   <td style="width: 100%;" id="emptyListMessageText">No Orders</td>
                 </tr>
	        </table>
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
