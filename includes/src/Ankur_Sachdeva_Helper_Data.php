<?php

class Ankur_Sachdeva_Helper_Data extends Mage_Core_Helper_Abstract
{
public static function getFullUrl (Mage_Catalog_Model_Product $product , 
        Mage_Catalog_Model_Category $category = null , 
        $mustBeIncludedInNavigation = true ){

    // Try to find url matching provided category
    if( $category != null){
        // Category is no match then we'll try to find some other category later
        if( !in_array($product->getId() , $category->getProductCollection()->getAllIds() ) 
                ||  !self::isCategoryAcceptable($category , $mustBeIncludedInNavigation )){
            $category = null;
        }
    }
    if ($category == null) {
        if( is_null($product->getCategoryIds() )){
            return $product->getProductUrl();
        }
        $catCount = 0;
        $productCategories = $product->getCategoryIds();
        // Go through all product's categories
        while( $catCount < count($productCategories) && $category == null ) {
            $tmpCategory = Mage::getModel('catalog/category')->load($productCategories[$catCount]);
            // See if category fits (active, url key, included in menu)
            if ( !self::isCategoryAcceptable($tmpCategory , $mustBeIncludedInNavigation ) ) {
                $catCount++;
            }else{
                $category = Mage::getModel('catalog/category')->load($productCategories[$catCount]);
            }
        }
    }
    $url = (!is_null( $product->getUrlPath($category))) ?  Mage::getBaseUrl() . $product->getUrlPath($category) : $product->getProductUrl();
    return $url;
}

/**
 * Checks if a category matches criteria: active && url_key not null && included in menu if it has to
 */
public static function isCategoryAcceptable(Mage_Catalog_Model_Category $category = null, $mustBeIncludedInNavigation = true){
    if( !$category->getIsActive() || is_null( $category->getUrlKey() )
        || ( $mustBeIncludedInNavigation && !$category->getIncludeInMenu()) ){
        return false;
    }
    return true;
}
}