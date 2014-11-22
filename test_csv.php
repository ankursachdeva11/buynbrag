<?php 
ini_set('max_execution_time', 300);
ini_set('display_errors',1);
require_once('app/Mage.php');
Mage::init(); 

$products = Mage::getModel('catalog/product')->getCollection();
foreach($products as $prod) {
	$product = Mage::getModel('catalog/product')->load($prod->getId());
	$qtyStock = Mage::getModel('cataloginventory/stock_item')->loadByProduct($prod)->getQty();
	if($qtyStock==0){
echo $product->getName().'-'.$qtyStock.'<br>';
	}

}
/*// Check if there is a stock item object
$stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct('336');
$stockItemData = $stockItem->getData();
if (empty($stockItemData)) {

    // Create the initial stock item object
    $stockItem->setData('manage_stock',1);
    $stockItem->setData('is_in_stock',$qty ? 1 : 0);
    $stockItem->setData('use_config_manage_stock', 0);
    $stockItem->setData('stock_id',1);
    $stockItem->setData('product_id','336');

    $stockItem->setData('qty',0);
	
    $stockItem->save();

    // Init the object again after it has been saved so we get the full object
    $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct('336');
}

// Set the quantity
$stockItem->setData('qty',$qty);
$stockItem->save();
$product->save();*/
?>