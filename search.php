<?php
require_once('funcs/functions.php');
session_start();
$city = "Jodhpur";
//$con = connectDB();

				$ids = '';
				$row = '';
				$find = $_POST['searchtext'];
				$find = mres_ss($find);
				//echo $find;
				$c = (str_word_count($find));
				//echo "<br>";
//echo $c;
				$p = (str_word_count($find, 2));
				
					$j=0;
					//echo "<br>";
					//echo $p;
					/*for ($i = 0; $i < strlen($find); $i++)
					{
						if ($p[$i] != '')
						{
							$j = $j + 1;
							$ar[$j] = $p[$i];
						}
					}*/
					

					/*for ($num = 1; $num <= $c; $num++)
					{
						$arr1=$ar[$num]." ".$ar[($num % $c) + 1];
						$arr2=$ar[($num % $c) + 1]." ".$ar[$num];

						if(((($num % $c) + 1) <= $c)&&((($num % $c) + 2) <= $c)){
							$arr3=$ar[$num]." ".$ar[($num % $c) + 1]." ".$ar[($num % $c) + 2];
							$arr4=$ar[$num]." ".$ar[($num % $c) + 2]." ".$ar[($num % $c) + 1];
							$arr5=$ar[($num % $c) + 1]." ".$ar[$num]." ".$ar[($num % $c) + 2];
							$arr6=$ar[($num % $c) + 1]." ".$ar[($num % $c) + 2]." ".$ar[$num];
							$arr7=$ar[($num % $c) + 2]." ".$ar[$num]." ".$ar[($num % $c) + 1];
							$arr8=$ar[($num % $c) + 2]." ".$ar[($num % $c) + 1]." ".$ar[$num];
						}
						$query.= "SpecificName = '$ar[$num]' or SpecificName like '% ".$ar[$num]." %' or SpecificName like '$ar[$num]"." %' or SpecificName like '% ".$ar[$num]."' or SpecificName like '$arr1' or SpecificName like '% ".$arr1." %' or SpecificName like '$arr1"." %' or SpecificName like '% ".$arr1."' or SpecificName like '$arr2' or SpecificName like '% ".$arr2." %' or SpecificName like '$arr2"." %' or SpecificName like '% ".$arr2."' or ";
					}*/
					$query = "select distinct ItemID from items where SpecificName LIKE '%".$find."%' or ItemName LIKE '%".$find."%' or Manufacturer LIKE '%".$find."%'";
					//
					//$result.=" and ItemID in ( select ItemID from subitems where SubItemID in ( select SubItemID from shopitems where ShopID in ( select ShopID from shopdetails where City='$city' ) ) ) order by SpecificName;";
					//echo $query;
					//$result = substr($query,0,-3);
					//echo "<br><br>";
					//echo $result;
					$res = mysql_query($query);

					while ($row = mysql_fetch_array($res)) {
						if($ids != ""){
							//echo $ids;
							$ids .= "-".$row['ItemID'];
						}else{
							$ids = $row['ItemID'];
						}
					}

					if($row == '')
					{
					//$query = "select distinct ItemID from items where ";

					/*for ($num = 1; $num <= $c; $num++)
					{
						$arr1=$ar[$num]." ".$ar[($num % $c) + 1];
						$arr2=$ar[($num % $c) + 1]." ".$ar[$num];

						if(((($num % $c) + 1) <= $c)&&((($num % $c) + 2) <= $c)){
							$arr3=$ar[$num]." ".$ar[($num % $c) + 1]." ".$ar[($num % $c) + 2];
							$arr4=$ar[$num]." ".$ar[($num % $c) + 2]." ".$ar[($num % $c) + 1];
							$arr5=$ar[($num % $c) + 1]." ".$ar[$num]." ".$ar[($num % $c) + 2];
							$arr6=$ar[($num % $c) + 1]." ".$ar[($num % $c) + 2]." ".$ar[$num];
							$arr7=$ar[($num % $c) + 2]." ".$ar[$num]." ".$ar[($num % $c) + 1];
							$arr8=$ar[($num % $c) + 2]." ".$ar[($num % $c) + 1]." ".$ar[$num];
						}
						$query.= "SpecificName = '$ar[$num]' or SpecificName like '% ".$ar[$num]." %' or SpecificName like '$ar[$num]"." %' or SpecificName like '% ".$ar[$num]."' or SpecificName like '$arr1' or SpecificName like '% ".$arr1." %' or SpecificName like '$arr1"." %' or SpecificName like '% ".$arr1."' or SpecificName like '$arr2' or SpecificName like '% ".$arr2." %' or SpecificName like '$arr2"." %' or SpecificName like '% ".$arr2."' or ";
					}
					//$result = substr($query,0,-3);
					//$result.=" and ItemID in ( select ItemID from subitems) order by SpecificName;";
					
					echo "<br><br>";
					echo $result;
					
					$res = mysql_query($result);

					while ($row = mysql_fetch_array ($res)) {
						if($ids != ""){
							//echo $ids;
							$ids .= "-".$row['ItemID'];
						}
						else
						{
							$ids = $row['ItemID'];
						}
					}*/			
				}			

				//session_start();
				if($ids != ""){
					$_SESSION['found_ids'] = $find."-".$ids;
				}else{
					$_SESSION['found_ids'] = $find;
				}
//closeDB($con);
header("location: index.php");
//echo "q".$ids."q";

?>