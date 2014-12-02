<?php
session_start();

if(isset($_SESSION['gs_userid'])){
  $uid = $_SESSION['gs_userid'];
  
  if(isset($_SESSION['gs_cart'])){
    $cart = $_SESSION['gs_cart'];
  }else{
    $cart = null;
  }
  
  require_once('funcs/functions.php');
  if($cart){
   // $con = connectDB();
    
    $currDate = date("d-m-Y");
    $currTime = date("H:i:s");
    $addressID = mres_ss($_POST['addressid']);
    $custName = mres_ss($_POST['custname']);
    
    if(($addressID == 0)||($addressID == "")){
      $newaddress = mres_ss($_POST['address']);
      $newcity = mres_ss($_POST['city']);
      $newstate = mres_ss($_POST['state']);
      $newpincode = mres_ss($_POST['pincode']);
      $newphone = mres_ss($_POST['mobileno']);
      $query = "insert into customeraddress (CID,Address,City,State,Pincode,Phone) values ('$uid','$newaddress','$newcity','$newstate','$newpincode','$newphone')";
      mysql_query($query);
      $addressID = mysql_insert_id($link);
    }
    
    $query = "insert into orders (OrderName,CID,Date,Time,Status,AddressID) values ('$custName','$uid','$currDate','$currTime','1','$addressID')";
    mysql_query($query);
    $insertID = mysql_insert_id($link);
    
    if($insertID > 0){
      $cartItem = explode(";",$cart);
      for($i=0;$i<count($cartItem);$i++){
        $temp = explode("->",$cartItem[$i]);
        $subItemID = $temp[1];
        
        $res1 = mysql_query("select ItemID from items where SubItemID = $subItemID");
        $row1 = mysql_fetch_array($res1);
        $itemID = $row1['ItemID'];
        $res1 = mysql_query("select count(*) as ItemCount from subitems where ItemID = $itemID");
        $row1 = mysql_fetch_array($res1);
        $itemCount = $row1['ItemCount'];
        
        $itemQuantity = $temp[2];
        $query = "insert into orderlist (OrderID,SubItemID,Quantity) values ('$insertID','$subItemID','$itemQuantity')";
        mysql_query($query);
        $popFactor = 1 + (0.1*$itemCount);
        $query = "update subitems set Popularity = Popularity*$popFactor where SubItemID = $subItemID";
        mysql_query($query);
        calculatePopularities($subItemID);
      }
      $_SESSION['gs_cart'] = null;
      $_SESSION['placed_order_id'] = $insertID;
      header("location: myorders.php");
    }else{
      $regs = "An error has been encountered while processing your order.<br/>Sorry for your Inconvenience...";
    }
   // closeDB($con);
  }else{
    $regs = "No Items in your CART";
  }

  showMessage($regs);
}else{
  header("location: index.php");
}

?>