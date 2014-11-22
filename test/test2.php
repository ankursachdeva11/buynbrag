<?php 

ini_set('display_errors',1);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
set_time_limit(0);
require_once '../app/Mage.php';
umask(0);
Mage::app('default');

 $filename = "all_store_details1.csv";
$fp = fopen( $filename ,"r");
$i=0;
while ($line = fgets ($fp))
{
 		$pos=strpos($line,",");
	$arr = split (",", $line);
echo "update bnbMagento.testingsupplier_users  set phone='".$arr[1]."',city='".$arr[2]."',state='".$arr[3]."',country='".$arr[4]."',postalcode='".$arr[5]."' where name='".$arr[0]."';<br>";

	 }
fclose($fp);
 