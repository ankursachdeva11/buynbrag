<?php
ini_set('display_errors',1);

require_once '../app/Mage.php';
umask(0);
Mage::app('default');
$productModel = Mage::getModel('catalog/product');
				$attr = $productModel->getResource()->getAttribute("supplier");
				if ($attr->usesSource()) {
					echo $color_id = $attr->getSource()->getOptionId(102);
				}
/*$arg_attribute = 'supplier';
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