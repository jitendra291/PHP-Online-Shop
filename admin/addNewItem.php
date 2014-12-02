<?php
session_start();
$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
 $selected = mysql_select_db("shopping_portal2",$link) 
  or die("Could not select examples");
  
if(isset($_SESSION['gs_admin'])){
  $aid = $_SESSION['gs_admin'];
}else{
  $aid = "";
  header("location: index.php");
}

$iname = $_POST['newItemName'];
$aname = $_POST['newAlterName'];
$sname = $_POST['newSpecificName'];
$manu = $_POST['newManufacturer'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];
$ign = $_POST['igno'];

$q = "insert into items (ItemName, AlterName, SpecificName, Manufacturer, ItemGroupID) values ('$iname','$aname','$sname','$manu','$ign')";
mysql_query($q);
$insertID_main = mysql_insert_id($link);

$ext = pathinfo($_FILES['newImage']['name'], PATHINFO_EXTENSION);
$target_path = "../images/product/".$insertID_main.".".$ext;
echo "Target Path: ".$target_path."<br/>";
$val = move_uploaded_file($_FILES['newImage']['tmp_name'], $target_path);
echo "Upload Value:".$val;

if($val) {
    echo "Item added successfully";
}else{
    echo "There was an error uploading the file, please try again!";
}
$q2 = "insert into subitems (ItemID,Quantity, Price, type) values ('$insertID_main','$quantity','$price','P')";
mysql_query($q2);
//echo $q2;
$insertID_sub = mysql_insert_id($link);

$q3 ="insert into shopitems(SubItemID,Availability, Price,ShopID) values ('$insertID_sub','$quantity','$price','6')";
mysql_query($q3);
header("location: manageItems.php");
//echo $q3;
?>