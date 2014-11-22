<?php 

$conn = mysql_connect("bnbdb.c4xniebqwpch.ap-southeast-1.rds.amazonaws.com","bnbMagento","aaindus99"); 
mysql_select_db("bnbMagento",$conn);
extract($_REQUEST);
	 $sql = "SELECT count(*) FROM `shop_service_pincodes` WHERE  pincode=$pincode";
	 $sql1 = "SELECT delivey_type FROM `shop_service_pincodes` WHERE  pincode=$pincode";

echo json_encode(array(mysql_result(mysql_query($sql),0),mysql_result(mysql_query($sql1),0)));

@session_start();
$_SESSION['checked_pincode']=$pincode;

?>