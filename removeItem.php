<?php
$sid = $_POST['subItemID'];
session_start();
$cart = $_SESSION['gs_cart'];
$cartItem = explode(";",$cart);

$newCart = "";
for($i=0;$i<count($cartItem);$i++)
{
 $item = explode("->",$cartItem[$i]);
 if($item[1] != $sid)
 {
  if($newCart != "")
   $newCart = $newCart.";".$cartItem[$i];
  else
   $newCart = $cartItem[$i];
 }
}

if($newCart == ""){
 $newCart = null;
}
$_SESSION['gs_cart'] = $newCart;
echo $newCart;

?>