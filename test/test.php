<?php 

//$conn = mysql_connect("bnbdb.c4xniebqwpch.ap-southeast-1.rds.amazonaws.com","bnbMagento","aaindus99"); 
//mysql_select_db("bnbMagento",$conn);
//$qry=mysql_fetch_array(mysql_query("show field bnbMagento.testingsupplier_users"));
//print_r($qry);


//$qr=mysql_query("show columns from testingsupplier_users");
//echo mysql_num_rows($qr);
//while($r=mysql_fetch_array($qr)){
//echo $r['Field']."<br>";	
//}
ini_set('display_errors',1);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
set_time_limit(0);
require_once '../app/Mage.php';
umask(0);
Mage::app('default');
/*
$arg_attribute = 'supplier';
for($i=100;$i<319;$i++)
 {
 $attribute_model        = Mage::getModel('eav/entity_attribute');
 
$attribute_code         = $attribute_model->getIdByCode('catalog_product', 'supplier');
 $attribute              = $attribute_model->load($attribute_code);
 
if(!attributeValueExists('supplier',$i))
 {
 $value['option'] = array($i);
 $order['option'] = $i;
 $result = array('value' => $value,'order' => $order);
 $attribute->setData('option',$result);
 $attribute->save();
 }
 }
 
function attributeValueExists($arg_attribute, $arg_value)
 {
 $attribute_model        = Mage::getModel('eav/entity_attribute');
 $attribute_options_model= Mage::getModel('eav/entity_attribute_source_table') ;
 
$attribute_code         = $attribute_model->getIdByCode('catalog_product', $arg_attribute);
 $attribute              = $attribute_model->load($attribute_code);
 
$attribute_table        = $attribute_options_model->setAttribute($attribute);
 $options                = $attribute_options_model->getAllOptions(false);
 
foreach($options as $option)
 {
 if ($option['label'] == $arg_value)
 {
 return $option['value'];
 }
 }
 return false;
 }*/
 $filename = "test.csv";
$fp = fopen( $filename ,"r");
$i=0;
while ($line = fgets ($fp))
{
	if($i<$_REQUEST['t'] && $i>$_REQUEST['f']){
	$arr = split (",", $line);
	//$ltu='';
	//for($i=0;$i<62;$i++){
		//$ltu.="'".$arr[$i]."',";
	//}
	if($arr[0]!=""){
			echo $arr[0].' - '.$arr[1].'<br>';
			 $SKU = $arr[0];
				$productid = Mage::getModel('catalog/product')
									  ->getIdBySku(trim($SKU));
				 if($productid!=""){
				// Initiate product model
				$productModel = Mage::getModel('catalog/product');
				$attr = $productModel->getResource()->getAttribute("supplier");
				if ($attr->usesSource()) {
					echo $color_id = $attr->getSource()->getOptionId((int)$arr[1]);
				}
				$product = Mage::getModel('catalog/product');
				$product ->load($productid);
				 $product->setData("supplier",$color_id)->save();																	
				 }
	}
	}
	//$ltu=substr($ltu,0,-1);
//	 $query = "INSERT INTO `testingsupplier_users` VALUES (".$ltu.")";
	// mysql_query($query);
	$i++;
	 }
fclose($fp);
 
/* $SKU = "S116P1005";
$productid = Mage::getModel('catalog/product')
	                  ->getIdBySku(trim($SKU));
 
// Initiate product model
$productModel = Mage::getModel('catalog/product');
$attr = $productModel->getResource()->getAttribute("supplier");
if ($attr->usesSource()) {
    $color_id = $attr->getSource()->getOptionId(116);
}
$product = Mage::getModel('catalog/product');
$product ->load($productid);
 $product->setData("supplier",$color_id)->save();*/
// Load specific product whose tier price want to update

 /*setOrAddOptionAttribute($product, 'supplier', '116');

 function setOrAddOptionAttribute($product, $arg_attribute, $arg_value) {
	$attribute_model = Mage::getModel('eav/entity_attribute');
	$attribute_options_model = Mage::getModel('eav/entity_attribute_source_table');

	$attribute_code = $attribute_model->getIdByCode('catalog_product', $arg_attribute);
	$attribute = $attribute_model->load($attribute_code);

	$attribute_options_model->setAttribute($attribute);
	$options = $attribute_options_model->getAllOptions(false);

	// determine if this option exists
	$value_exists = false;
	foreach($options as $option) {
		if ($option['label'] == $arg_value) {
			$value_exists = true;
			break;
		}
	}

	// if this option does not exist, add it.
	if (!$value_exists) {
		$attribute->setData('option', array(
			'value' => array(
				'option' => array($arg_value,$arg_value)
			)
		));
		$attribute->save();
	}

	$product->setData($arg_attribute, $arg_value);
}*/