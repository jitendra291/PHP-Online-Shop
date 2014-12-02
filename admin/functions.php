<?php

function showNavigation(){
  
  echo "<div style='margin: 10px 0px 10px 0px; border-bottom: 1px solid #36c5d8;'>";
  $gt = 'goto("index");';
  echo "<div class='adminButtons' style='margin-right: 10px; display: inline-block;' onclick='$gt'>Home</div>";
  $gt = 'goto("manageItems");';
  echo "<div class='adminButtons' style='margin-right: 10px; display: inline-block;' onclick='$gt'>Manage Items</div>";
 /* $gt = 'goto("showAdmins");';
  echo "<div class='adminButtons' style='margin-right: 10px; display: inline-block;' onclick='$gt'>View All Admins</div>";
  $gt = 'goto("createNewAdmin");';
  echo "<div class='adminButtons' style='margin-right: 10px; display: inline-block;' onclick='$gt'>Create New Admin</div>";*/
  $gt = 'goto("../index");';
  echo "<div class='adminButtons' style='display: inline-block;' onclick='$gt'>Logout</div>";
  echo "</div>";
  
}

?>