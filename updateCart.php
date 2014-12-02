<?php
session_start();
$cart = $_SESSION['gs_cart'];
$subItemID = $_POST['subItemID'];
$itemQuantity = $_POST['itemQuantity'];
$newCart = "";

$exp_cart = explode(";",$cart);
$str = "";
for($i=0;$i<count($exp_cart);$i++){
 $sub_exp_cart = explode("->",$exp_cart[$i]);
 $res = strcmp($sub_exp_cart[1], $subItemID);
 if($res == 0){
   $newCartString = "i->".$sub_exp_cart[1]."->".$itemQuantity."->".$sub_exp_cart[3]."->".$sub_exp_cart[4]."->".$sub_exp_cart[5]."->".$sub_exp_cart[6]."->".$sub_exp_cart[7];
   if($newC == ""){
     $newC = $newCartString;
   }else{
     $newC = $newC.";".$newCartString;
   }
 }else{
   if($newC == ""){
     $newC = $exp_cart[$i];
   }else{
     $newC = $newC.";".$exp_cart[$i];
   }
 }

}
$_SESSION['gs_cart'] = $newC;
echo $newC;

?>