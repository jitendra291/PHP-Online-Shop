/*developed by Jitendra chaudhary (jitendra291192@gmail.com) This project doesn't contain the sql file(I have lost that due to some unfortunate system crash).please make .sql file by reading the code...*/
<?php
if(isset($_SESSION['gs_userid']))
{
 $uid = $_SESSION['gs_userid'];
}
else
 $uid = null;

if(isset($_SESSION['added'])){
 $added = $_SESSION['added'];
 $_SESSION['added'] = 0;
}
else{
 $added = 0;
}

if(isset($_SESSION['cartVisibility'])){
 $cartVisible = $_SESSION['cartVisibility'];
}else{
 $cartVisible = null;
}

if(isset($_SESSION['gs_cart']))
 $cart = $_SESSION['gs_cart'];
else
 $cart = "";

if($cart != ""){
 $ec = explode(";",$cart);
 $cart_count = count($ec);
}else{
 $cart_count = 0;
}

if(isset($_SESSION['found_ids'])){
  $search_ids = $_SESSION['found_ids'];
  unset($_SESSION['found_ids']);
}else{
  $search_ids = null;
}

if(isset($_SESSION['gs_reg_status'])){
  $reg_status = $_SESSION['gs_reg_status'];
  unset($_SESSION['gs_reg_status']);
}else{
  $reg_status = "";
}

require_once('funcs/functions.php');

  //$con = connectDB();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US">
<head>
<title>Welcome to OnlineShop</title>
<?php echo includeAllFiles(); ?>

<script>
var isItemRemoved = false;
var allowPlaceOrder = true;

function getItemsInCart(){
 var xmlhttp;
 if(window.XMLHttpRequest){
   xmlhttp=new XMLHttpRequest();
 }else{
   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 }
 
 xmlhttp.onreadystatechange=function(){
   if(xmlhttp.readyState==4 && xmlhttp.status==200){
	var responseVal = xmlhttp.responseText;
	var splitRVal = responseVal.split(";");
	return splitRVal.length;
   }
 }
 xmlhttp.open("POST","showCart.php",true);
 xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
 xmlhttp.send();
 return "hahaha";
}

<?php getJqueryDropdowns(); ?>

var $dialog5;
$(function(){
	
	<?php getAllJqueryDialogs(); ?>
	
       $(window).scroll(function () {
		var currentScroll = $(this).scrollTop();
		if(currentScroll >= 100){
			$("#cartButtonTextFixed").css("display","block");
		}else{
			$("#cartButtonTextFixed").css("display","none");
		}
	});
	
})(jQuery);


function indexInit(){
 //getLocationInfo();
 //initialize();
 document.getElementById("cartButtonFixed").style.top = (screen.height/3)+"px";
}

function updateCartItem(subItemID,type){
 var xmlhttp;
 if(window.XMLHttpRequest){
   xmlhttp=new XMLHttpRequest();
 }else{
   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 }
 
 var itemQuantity = 0;
 if(type == 'P'){
   var obj = document.getElementById("qty" + subItemID);
   if(isNaN(obj.value) || (obj.value < 0)){
     obj.value = 0;
   }
   itemQuantity = obj.value;
   var pktString = document.getElementById("packetString" + subItemID);
   if(itemQuantity > 1){
     pktString.innerHTML = "Packets";
   }else{
     pktString.innerHTML = "Packet";	    
   }
 }else{
   var objkg = document.getElementById("qtykg" + subItemID);
   var objgms = document.getElementById("qtygms" + subItemID);
   if(isNaN(objkg.value) || (objkg.value < 0)){
     objkg.value = 0;
   }
   if(isNaN(objgms.value) || (objgms.value < 0)){
     objgms.value = 0;
   }
   itemQuantity = (parseInt(objkg.value) * 1000) + parseInt(objgms.value);
 }
 if(isNaN(itemQuantity)){
   itemQuantity = 0;
 }
 xmlhttp.onreadystatechange=function(){
   if(xmlhttp.readyState==4 && xmlhttp.status==200){
	var responseVal = xmlhttp.responseText;
	var splitRVal = responseVal.split(";");
	var str = "";
	var gt = 0;
	for(var i=0;i<splitRVal.length;i++){
		var sp = splitRVal[i].split("->");
		var ip = document.getElementById("itemPrice" + sp[1]).innerHTML;
		var ist = document.getElementById("itemSubTotal" + sp[1]);
		var it_type = sp[4];
		if(it_type == 'P'){
		  var st = sp[2]*ip;
		}else{
		  var st = (sp[2]/1000)*ip;
		}
		ist.innerHTML = st.toFixed(2);
		var qs = document.getElementById("quantityStatus" + (i+1));
		if((sp[2] > 0) && (sp[2] != "")){
		  qs.checked = true;
		}else{
		  qs.checked = false;
		}
		gt = gt + st;
	}
	document.getElementById("grandTotal").innerHTML = gt.toFixed(2);
   }
 }
 xmlhttp.open("POST","updateCart.php",true);
 xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
 xmlhttp.send("subItemID=" + subItemID + "&itemQuantity=" + itemQuantity);

}

function checkPlaceOrder(){
 var xmlhttp;
 if(window.XMLHttpRequest){
   xmlhttp=new XMLHttpRequest();
 }else{
   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 }
 
 xmlhttp.onreadystatechange=function(){
   if(xmlhttp.readyState==4 && xmlhttp.status==200){
     var responseVal = xmlhttp.responseText;
     var splitRVal = responseVal.split(";");
     var cartLength = splitRVal.length;
     var status = true;
     for(var i=0;i<cartLength;i++){
	var qs = document.getElementById("quantityStatus" + (i+1));
	status = status && qs.checked;
     }
     if(status){
	window.location.href = "placeOrder.php";
     }else{
	alert("Please mention quantities of all the items in your cart");
     }
   }
 }
 xmlhttp.open("POST","showCart.php",true);
 xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
 xmlhttp.send();
}

function removeCartItem(subItemID){

if(confirm("Are you sure you want to delete this item?")){
 var xmlhttp;
 if(window.XMLHttpRequest){
   xmlhttp=new XMLHttpRequest();
 }else{
   xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 }
 xmlhttp.onreadystatechange=function(){
   if(xmlhttp.readyState==4 && xmlhttp.status==200){
     var responseVal = xmlhttp.responseText;
     var gt = 0;
     var cartLength = 0;
     document.getElementById("cartListRow" + subItemID).style.display = "none";
     if((responseVal != "")&&(responseVal != null)){
	var splitRVal = responseVal.split(";");
	cartLength = splitRVal.length;
	for(var i=0;i<cartLength;i++){
		var sp = splitRVal[i].split("->");
		var ip = document.getElementById("itemPrice" + sp[1]).innerHTML;
		if(sp[4] == "P"){
		  var st = sp[2]*ip;
		}else{
		  var st = (sp[2]/1000)*ip;
		}
		gt = gt + st;
	}
	document.getElementById("cartButtonText").innerHTML = "Cart (" + cartLength + ")";
     }
     document.getElementById("grandTotal").innerHTML = gt.toFixed(2);
     document.getElementById("cartButtonText").innerHTML = "Cart (" + cartLength + ")";
     document.getElementById("cartButtonTextFixed").innerHTML = "Cart (" + cartLength + ")";
     document.getElementById("dialogCartTitleText").innerHTML = "Cart Items (" + cartLength + ")";
     isItemRemoved = true;
   }
 }
 xmlhttp.open("POST","removeItem.php",true);
 xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
 xmlhttp.send("subItemID=" + subItemID);
}

}


function addToCart(itemID){

var trows = document.getElementById("cartTable").getElementsByTagName("tr");
var count = trows.length;
var cartElementsCount = count + 1;

var subitems = document.getElementsByName("det"+itemID);
var str = "",itemsChecked=0;
for(var i=0;i<subitems.length;i++){
  if(subitems[i].checked && !subitems[i].disabled){
    if(str == ""){
      str = subitems[i].value;
    }else{
      str += "-" + subitems[i].value;
    }
    subitems[i].checked = true;
    subitems[i].disabled = true;
    document.getElementById("subcheckname"+subitems[i].value).style.textDecoration = "line-through";
    itemsChecked++;
  }
}

if(str == ""){
  alert("Please select an item");
  return ;
}
var xmlhttp;
if(window.XMLHttpRequest){
  xmlhttp=new XMLHttpRequest();
}else{
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
 xmlhttp.onreadystatechange=function(){
   if(xmlhttp.readyState==4 && xmlhttp.status==200){
	var responseVal = xmlhttp.responseText;
	
	var splitRVal = responseVal.split(";");
	document.getElementById("cartButtonText").innerHTML = "Cart (" + (splitRVal.length) + ")";
	document.getElementById("cartButtonTextFixed").innerHTML = "Cart (" + (splitRVal.length) + ")";
	
	var iltemp = document.getElementsByName("det" + itemID);
	var il = document.getElementById("itemLink" + itemID);
	var count = 0;
	for(var i=0;i<iltemp.length;i++){
	  if(iltemp[i].checked || iltemp[i].disabled){
	    count++;
	  }
	}
	if(iltemp.length == count){
	  il.innerHTML = "All items have been selected.";
	  il.style.color = "green";
	}else{
	  il.innerHTML = "Please select one or more items.";
	  il.style.color = "blue";
	}
	il.style.background = "transparent";
	il.onclick = "";
	
	for(var i=1;i<=itemsChecked;i++){
	  var currItem = splitRVal[splitRVal.length-i].split("->");
	  var subItemId = currItem[1];
	  var tempItemId = subItemId;
	  var userQuantity = currItem[2];
	  var subItemName = currItem[3];
	  var type = currItem[4];
	  var quantity = currItem[5];
	  var itemPrice = currItem[6];
	  var itemName = currItem[7];
	  if(type == "P"){
	    var subTotal = itemPrice * userQuantity;
	  }else{
	    var subTotal = itemPrice * (userQuantity/1000);
	  }
	  subTotal = subTotal.toFixed(2);
	  var units = "";
	  if(type == "P"){
	    qunits = getQuantityWithUnits(quantity);
	    perString = "per piece";
	  }else{
	    qunits = "";
	    perString = "per Kg";
	  }
	  var itemSubString = "";
	  if(subItemName != ""){
	    itemSubString = subItemName + ", ";
	  }
	  var htmlString = "<tr class='cartListRow' id='cartListRow" + subItemId + "'><td style='width: 3%;'><div class='dialogCartItemRemove' onclick='removeCartItem(" + subItemId + ")'></div></td><td style='width: 37%;'>" + itemName + "<div style='font-size: 12px; margin-left: 12px;'>" + itemSubString + qunits + " " + "</div></td><td style='width: 20%; padding-left: 10px;'><div>Rs.&nbsp;<label id='itemPrice" + subItemId + "'>" + itemPrice + "</label> <label style='font-size: 10px;'>" + perString + "</label> </div></td>";
	  htmlString = htmlString + "<td style='width: 20%; padding-left: 10px;'>";
	  var up_cart = "";
	  up_cart = '"' + type + '"';
	  up_cart = "updateCartItem(" + subItemId + "," + up_cart + ")";
	  if(type == "P"){
	    htmlString = htmlString + "<input type='text' autocomplete='off' id='qty" + subItemId + "' name='qty" + subItemId + "' value='" + userQuantity + "' size=2 style='text-align: center;font-size: 12px; outline: none;' onkeyup='" + up_cart + "'" + "/" + "><span style='font-size: 12px;' id='packetString" + subItemId + "'> Packet</span>";
	  }else{
	    htmlString = htmlString + "<input type='text' autocomplete='off' id='qtykg" + subItemId + "' name='qtykg" + subItemId + "' value='" + userQuantity + "' size=2 style='text-align: center;font-size: 12px; outline: none;' onkeyup='" + up_cart + "'" + "/" + "> <span style='font-size: 12px;'>Kg</span> ";
	    htmlString = htmlString + "<input type='text' autocomplete='off' id='qtygms" + subItemId + "' name='qtygms" + subItemId + "' value='" + userQuantity + "' size=2 style='text-align: center;font-size: 12px; outline: none;' onkeyup='" + up_cart + "'" + "/" + "> <span style='font-size: 12px;'>gms</span>";
	  }
	  if((userQuantity > 0)&&(userQuantity != "")){
	    tempQS = "checked";
	  }else{
	    tempQS = "";
	  }
	  htmlString = htmlString + "</td><td style='width: 20%; text-align: right; padding-right: 5px;'><span style='display: inline-block; float: left; padding-left: 5px;'>Rs.</span><span id='itemSubTotal" + subItemId + "'>" + subTotal + "</span> <input type='checkbox' id='quantityStatus" + (cartElementsCount + (i-1)) + "' " + tempQS + " disabled hidden/></td></tr>";
	  var row = $(htmlString);
         $("#cartTable").append(row);
	}
	
	document.getElementById("cartBottom").style.display = "block";
	document.getElementById("dialogCartTitleText").innerHTML = "Cart Items (" + (splitRVal.length) + ")";
	var gt = 0;
	for(var i=0;i<splitRVal.length;i++){
	  currItem = splitRVal[i].split("->");
	  if(currItem[4] == "P"){
           gt = gt + document.getElementById("itemPrice"+currItem[1]).innerHTML * currItem[2];
	  }else{
	    gt = gt + document.getElementById("itemPrice"+currItem[1]).innerHTML * (currItem[2]/1000);
	  }
	}
	
	document.getElementById("grandTotal").innerHTML = gt.toFixed(2);
   }
 }
 
 xmlhttp.open("POST","cart.php",true);
 xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
 xmlhttp.send("subitems=" + str);


}

function detailChecked(itemID,subItemID){
  var checklist = document.getElementsByName("det"+itemID);
  var check = 0;
  
  for(var i=0;i<checklist.length;i++){
    //alert("Result: " + (!checklist[i].disabled && checklist[i].checked));
    if(checklist[i].checked && !checklist[i].disabled){
      check = 1;
      break;
    }
  }
  
  var itematc = document.getElementById("itemLink"+itemID);
  var itemhref = document.getElementById("itemLink"+itemID);
  if(check == 1){
    itematc.style.background = "url(images/atc_blue.png) no-repeat";
    itematc.innerHTML = "";
    itematc.onclick = function onclick(event){ addToCart(itemID) }
  }else{
    itematc.innerHTML = "Please select one or more items.";
    itematc.style.color = "blue";
    itematc.style.background = "transparent";
    itematc.onclick = "";
  }
  
}

function getQuantityWithUnits(q){
  if(q < 1000){
    return q + "gms";
  }else{
    return (q/1000) + "Kg";
  }
}

function emptyCart(){
	if(confirm("Are you sure?")){
		window.location = "emptyCart.php";
	}
}

</script>

</head>

<body onload="indexInit()">

<div class="mainArea">
  <?php showHeader($uid,"0"); ?>
<div class="rest">
 <?php
   //if(isset($_SESSION['gs_city'])){
     $city = "jodhpur";
   //}else{
   //  header("location: index.php");
   //}
 ?>
 <div class="searchArea">
  <table width="99%">
   <tr>
    <td class="searchTextArea">
     <div class="searchTextBoxArea">
	<form id="searchForm1" action="search.php" method="post" onsubmit="return searchValidate(this);">
         <input type="text" name="searchtext" id="searchtext" class="searchTextBox" placeholder="What would you like to purchase?"/>
	  <input type="submit" value="Search" class="sButton"/>
       </form>
     </div>
    </td>
    <td width="1%"></td>
    <td>
      <a style="cursor: pointer;" id="cartButton">
        <div class="cartButton" id="cartButtonText">
          Cart (<?php echo $cart_count; ?>)
        </div>
      </a>
    </td>
   </tr>
  </table>
 </div>

   <a style="position: fixed; bottom: 0px; right: 0px; cursor: pointer; background: red; height: 0px;" id="cartButtonFixed">
     <div class="cartButtonFixed" id="cartButtonTextFixed">
       Cart (<?php echo $cart_count; ?>)
     </div>
   </a>

       <?php
	 if(($cart!=null)||($cart!=""))
	  $items_in_cart = count(explode(';',$cart));
	 else
	  $items_in_cart = 0;
	?>
	 <div id="dialog" title="Cart Items (<?php echo $items_in_cart; ?>)" class="dialogArea">
	 
         <div class="dialogBody">
		<div class="dialogTitleArea">
                <span class="dialogTitle" id="dialogCartTitleText">Cart Items (<?php echo $items_in_cart; ?>)</span>
                <span id="close_dialog" class="dialogClose"></span>
              </div>
		<div class="dialogCartTitle">
	           <table class="width98p">
			<tr>
			  <td width="40%">Item Details</td>
			  <td width="20%">Item Price</td>
			  <td style="width: 20%; text-align: center;">Quantity</td>
			  <td style="width: 20%; text-align: center;">Sub Total</td>
			</tr>
		    </table>
		</div>
		<div class="dialogCartItem">
		    
		    <table style="width:100%;" id="cartTable"> 
			<?php
			 if($items_in_cart){
			   $cartItems = explode(";",$cart);
			   $grandTotal = 0;
			   $subTotal = 0;
			   for($i=0;$i<count($cartItems);$i=$i+1){
			     $subitems = explode("->",$cartItems[$i]);
			     $subitemid = $subitems[1];
			     $userquantity = $subitems[2];
			     $res = mysql_query("select ItemID,SubItemName,Type,Price,Quantity from subitems where SubItemID='$subitemid'");
			     $row = mysql_fetch_array($res);
			     
			     $itemId = $row['ItemID'];
			     $subItemName = $row['SubItemName'];
			     $type = $row['Type'];
			     $price = $row['Price'];
			     $quantity = $row['Quantity'];
			     
			     $res = mysql_query("select ItemName from items where ItemID='$itemId'");
			     $row = mysql_fetch_array($res);
			     $itemName = $row['ItemName'];
			?>
			  <tr class="cartListRow" id="cartListRow<?php echo $subitemid; ?>">
			    <td style="width: 3%;">
				<div class="dialogCartItemRemove" onclick="removeCartItem(<?php echo $subitemid; ?>)"></div>
			    </td>
			    <td style="width: 37%;">
				<?php
				  echo "<div>".$itemName;
				  if($type == "P"){
				    echo "</div><div style='font-size: 12px; margin-left: 10px;'>";
				    if($subItemName != ""){
				      echo $subItemName.", ";
				    }
				    echo getQuantityWithUnits($quantity)."</div>";
				  }else{
				    //echo $type;
				  }
				?>
			    </td>
			    <td style="width: 20%; padding-left: 10px;">
				<div>
				  Rs.
				  <label id="itemPrice<?php echo $subitemid; ?>">
				  <?php echo $price; echo "    "; ?>
				  </label>
				  <label style="font-size: 10px;">
				  <?php
				    if($type == "P"){
				      echo "per packet";
				    }else{
				      echo "per Kg";
				    }
				  ?>
				  </label>
				</div>
			    </td>
			    <td style="width: 20%; padding-left: 10px;">
				<?php if($type == "P"){ ?>
				  <input type="text" autocomplete="off" id="<?php echo 'qty'.$subitemid; ?>" name="<?php echo 'qty'.$subitemid; ?>" value="<?php echo $userquantity; ?>" size=2 style="text-align: center; font-size: 12px; outline: none;" onkeyup="updateCartItem(<?php echo $subitemid; ?>, 'P')" />
				  <span style="font-size: 12px;" id="packetString<?php echo $subitemid; ?>">
				  <?php
				    if($userquantity > 1){
				      echo "Packets";
				    }else{
				      echo "Packet";
				    }
				  ?>
				  </span>
				<?php
				  }else{
				    $usergrams = getUserGrams($userquantity);
				    $userkilos = getUserKilos($userquantity);
				?>
				  <input type="text" autocomplete="off" id="<?php echo 'qtykg'.$subitemid; ?>" name="<?php echo 'qtykg'.$subitemid; ?>" value="<?php echo $userkilos; ?>" size=2 style="text-align: center; font-size: 12px; outline: none;" onkeyup="updateCartItem(<?php echo $subitemid; ?>, 'L')" />
				  <span style="font-size: 12px;">Kg</span>
				  <input type="text" autocomplete="off" id="<?php echo 'qtygms'.$subitemid; ?>" name="<?php echo 'qtygms'.$subitemid; ?>" value="<?php echo $usergrams; ?>" size=2 style="text-align: center; font-size: 12px; outline: none;" onkeyup="updateCartItem(<?php echo $subitemid; ?>, 'L')" />
				  <span style="font-size: 12px;">gms</span>
				<?php } ?>
			    </td>
			    <td style="width: 20%; text-align: right; padding-right: 5px;">
				<?php
				  if($type == "P"){
				    $subTotal = $price*$userquantity; $grandTotal = $grandTotal + $subTotal;
				  }else{
				    $subTotal = $price*($userquantity/1000); $grandTotal = $grandTotal + $subTotal;
				  }
				?>
				<div> <span style="display: inline-block; float: left; padding-left: 5px;">Rs.</span> <span id="itemSubTotal<?php echo $subitemid; ?>"><?php echo getDecimalString($subTotal); ?></span> </div>
				<?php
			         if(($userquantity > 0)&&($userquantity != "")){
				    $tempQS = "checked";
			         }else{
				    $tempQS = "";
			         }
			       ?>
			       <input type="checkbox" id="quantityStatus<?php echo ($i+1); ?>" <?php echo $tempQS; ?> disabled hidden/>
			    </td>
			  </tr>
			<?php
			   }
			 }else{
			   //echo "<tr class='cartListRow'> <td>No Items in your Cart</td> </tr>";
			 }
			 
			?>
		    </table>
		    
		</div>
	<?php if($items_in_cart){ ?>
		<div id="cartBottom" style="display: block;">
       <?php }else{ ?>
		<div id="cartBottom" style="display: none;">
	<?php } ?>
		  <table width="98%">
			<tr>
			  <td style="width: 40%;"> <a href="#" class="dialogEmptyCart" onclick="emptyCart();">Empty Cart</a> </td>
			  <td style="width: 40%; text-align: right; font-weight: bold; font-size: 20px;">Grand Total:</td>
			  <td style="width: 20%; text-align: right; font-weight: bold; font-size: 20px;"><label style="float: left;">Rs.</label><label id="grandTotal"><?php echo getDecimalString($grandTotal); ?></label></td>
			</tr>
			<tr>
			  <td colspan=4>
			    <label style="color: black; font-size: 12px; padding-left: 5px;">
				Press 'ESC' key to Close.
			    </label>
			    <a id="placeorderhref" onclick="checkPlaceOrder();"><div class="placeOrder">Place Order</div></a>
			  </td>
			</tr>
		  </table>
		</div>
         </div>
	 
       </div>


 <div class="productList">
 <table>
 <tr>
 <td style="width: 20%; vertical-align: top;">
  <div class="leftNavList">
   <a href="index.php"><div class="leftNavTitle">All Products</div></a>
   
   <?php
    //$q2 = "select ItemGroupID, ItemGroupName from itemgroups where ItemGroupID in ( select ItemGroupID from items where ItemID in( select ItemID from subitems where SubItemID in ( select SubItemID from shopitems where ShopID in ( select ShopID from shopdetails where City like '%".$city."%' ) ) ) ) order by Popularity desc";
$q = "select ItemGroupID, ItemGroupName from itemgroups";
	//echo $q;   
   $res = mysql_query($q);
    while($ele = mysql_fetch_array($res)){
      $igid = $ele['ItemGroupID'];
      //$ic = runQuery($con, "select count(*) as ItemCount from items where ItemGroupID='$igid'");
      //$ic_row = mysqli_fetch_array($ic);
      //$icount = $ic_row['ItemCount'];
   ?>
    <a href="index.php?ign=<?php echo $igid; ?>"><div class="leftNavLink"><?php echo $ele['ItemGroupName']; ?></div></a>
   <?php } ?>
  </div>
 </td>

 <?php if(isset($search_ids)){ ?>

 <td valign="top">
  <div class="groupArea">
   <?php
     $sid = explode("-",$search_ids);
     $searched_for = array_shift($sid);
   ?>
   <div class="groupTitle">Search Results for "<?php echo $searched_for; ?>"</div>
    <?php
     for($i=0;$i<count($sid);$i++){
	if($sid[$i] == ""){
	  continue;
	}
       $res = mysql_query("select * from items where ItemID='$sid[$i]'");
       $ele = mysql_fetch_array($res);
       if(($i%4)==0){
    ?>
       <div>
    <?php
       }
    ?>
       <div class="itemArea">
         <?php
	    $imgPath = "images/product/".$ele['ItemID'].".jpg";
	    if(!file_exists($imgPath)){
	      $imgPath = "images/products/rice/rice1.jpg";
	    }
	    $all_items_in_cart = showItemBlock($ele['ItemName'],$ele['ItemID'],$imgPath);
	  ?>
         <?php
	    if(!$all_items_in_cart){
         ?>
	    <a id="itemHref<?php echo $ele['ItemID']; ?>">
	      <div class="itemATC" id="itemLink<?php echo $ele['ItemID']; ?>" onclick="addToCart(<?php echo $ele['ItemID']; ?>)">Please select one or more items.</div>
           </a>
         <?php }else{ ?>
	    <div style="color: green; margin-top: 10px; height: 20px; text-align: center;" id="itemLink<?php echo $ele['ItemID']; ?>">All items have been selected.</div>
         <?php } ?>
       </div>
     <?php if((($i+1)%4)==0){ ?>
       </div>
     <?php } ?>
    <?php
     }
     if(!count($sid)){
	echo "<div style='color: red; margin-top: 5px;'>No items found</div>";
     }
    ?>
  </div>
 </td>

 <?php }else if(!isset($_GET['ign'])){ ?>
 <td valign="top">
 <?php
 $q3 = "select ItemGroupID, ItemGroupName from itemgroups where ItemGroupID in ( select ItemGroupID from items where ItemID in( select ItemID from subitems where SubItemID in ( select SubItemID from shopitems where ShopID in ( select ShopID from shopdetails where City like '%".$city."%' ) ) ) ) order by Popularity desc";
 $q="select ItemGroupID, ItemGroupName from itemgroups";
 $res = mysql_query($q);
 
 while($ele = mysql_fetch_array($res)){
 $jitu=$ele['ItemGroupID'];
 $q = "select ItemID, ItemName from items where ItemID in( select ItemID from subitems where SubItemID in ( select SubItemID from shopitems where ShopID in ( select ShopID from shopdetails where City like '%".$city."%' ) ) ) and ItemGroupID='".$ele['ItemGroupID']."' order by Popularity desc";
 $q4 = "select ItemID, ItemName from items where ItemGroupID =$jitu";
 //echo $q4;
 $sub_res = mysql_query($q);
 $total_count = mysql_num_rows($sub_res);
 ?>
  <div class="groupArea">
   <div class="groupTitle"><?php echo $ele['ItemGroupName']; ?> (<?php echo $total_count; ?>)</div>
   <div style="overflow: auto; width: 770px;">
   <div style="width: <?php echo 194*$total_count; ?>px;">
   
   <?php while(($sub_ele = mysql_fetch_array($sub_res))){ ?>
   <div class="itemArea">
     <?php
	$imgPath = "images/product/".$sub_ele['ItemID'].".jpg";
	if(!file_exists($imgPath)){
	  $imgPath = "images/product/1.jpg";
	}
	$all_items_in_cart = showItemBlock($sub_ele['ItemName'],$sub_ele['ItemID'],$imgPath);
     ?>
     <?php
	if(!$all_items_in_cart){
     ?>
        
	 <a id="itemHref<?php echo $sub_ele['ItemID']; echo "test"; ?>">
	   <div class="itemATC" id="itemLink<?php echo $sub_ele['ItemID']; ?>" onclick="addToCart(<?php echo $sub_ele['ItemID']; ?>)">Please select one or more items.</div>
        </a>
     <?php }else{ ?>
	 <div style="color: green; margin-top: 10px; height: 20px; text-align: center;" id="itemLink<?php echo $sub_ele['ItemID']; ?>">All items have been selected.</div>
     <?php } ?>
   </div>
   <?php } ?>
   </div>
   </div>

  </div>
 <?php
  }
 ?>
  </td>

<?php
	}else{
	  $ign = (int)$_GET['ign'];
	  //echo $ign;
?>

 <td valign="top">
  <div class="groupArea">
   <?php
     $res = mysql_query("select ItemGroupName from itemgroups where ItemGroupID = $ign");
     if(mysql_num_rows($res)>0){
       $row = mysql_fetch_array($res);
       $igname = $row['ItemGroupName'];
     }else{
       $igname = "Invalid Selection";
     }
   ?>
   <div class="groupTitle"><?php echo $igname; ?></div>
    <?php
     $q = "select ItemID, ItemName from items where ItemID in( select ItemID from subitems where SubItemID in ( select SubItemID from shopitems where ShopID in ( select ShopID from shopdetails where City like '%".$city."%' ) ) ) and ItemGroupID='".$ign."' order by Popularity desc";
     //$q2= "select ItemID,ItemName from items where ItemGroupID =$ign";
	// echo $q;
	 $res = mysql_query($q);
     $count = mysql_num_rows($res);
     if($count == 0){
	echo "<div style='margin: 5px; color: red;'>Oops! No items found</div>";
     }
     $i=0;
     while($ele = mysql_fetch_array($res)){
    ?>
      <?php if(($i%4)==0){ ?>
       <div>
      <?php } ?>
	<div class="itemArea">
         <?php
	    $imgPath = "images/product/".$ele['ItemID'].".jpg";
	    if(!file_exists($imgPath)){
	      $imgPath = "images/product/rice/rice1.jpg";
	    }
	    $all_items_in_cart = showItemBlock($ele['ItemName'],$ele['ItemID'],$imgPath);
	  ?>
         <?php
	    if(!$all_items_in_cart){
         ?>
	    <a id="itemHref<?php echo $ele['ItemID']; ?>">
	      <div class="itemATC" id="itemLink<?php echo $ele['ItemID']; ?>" onclick="addToCart(<?php echo $ele['ItemID']; ?>)">Please select one or more items.</div>
           </a>
         <?php }else{ ?>
	    <div style="color: green; margin-top: 10px; height: 20px; text-align: center;" id="itemLink<?php echo $ele['ItemID']; ?>">All items have been selected.</div>
         <?php } ?>
       </div>
      <?php if((($i+1)%4)==0){ ?>
       </div>
      <?php } ?>
    <?php
     $i=$i+1;}
    ?>
  </div>
 </td>
<?php } ?>
 </tr>
 </table>
 <div class="footer"> </div>
 </div>
</div>
</div>

<?php echo getAllDialogBodyDefinitions(); ?>

<div id="selectLocation" style="box-shadow: 0px 0px 10px 1px gray; font-family: cambria; background: rgba(56,197,216,1.0); margin: 0px; padding: 0px; border-radius: 10px;">
  <div style="padding: 5px; text-align: center; color: rgb(255,145,0); font-size: 20px; font-weight: bold; background: white; border-bottom: 1px solid white;">SELECT LOCATION</div>
  <div style="padding: 5px;">
    <div style="font-size: 16px; color: white; text-align: center;">Sorry! We are not able to find your location at the moment. So, please select your location from the list shown below</div>
    <div style="color: white; font-weight: bold; font-size: 20px; padding: 10px; text-align: center;">
      <div style="color: rgb(200,0,0); font-weight: normal; font-size: 16px;" id="manualLocationErrorMessage"></div>
      <label></label>
      <label>
	 <select onchange="setManualLocation(this.value);" id="manualLocation" style="font-weight: bold; color: rgb(255,145,0); border: 0px; outline: none; font-family: cambria; padding: 5px; border-radius: 5px; box-shadow: 0px 0px 15px 2px silver inset; width: 350px; height: 40px;">
	   <option value="0">(select)</option>
	   <option value="Jodhpur">Jodhpur</option>
	 </select>
      </label>
      
    </div>
  </div>
</div>

<!--
<div id="addNotification" style="position: fixed; bottom: 0px; padding: 5px; text-align: center; width: 100%; background: rgba(0,0,0,0.5); color: white; word-wrap: break-word;">
Item(s) have been added to the cart. For more quantity view your cart.
</div>
-->

<?php //closeDB($con); ?>

<div id="progressBar"></div>
</body>
</html>
