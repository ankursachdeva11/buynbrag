<?php 
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsBlacknwhite_Model_Productimg
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'zoom', 'label'=>Mage::helper('ThemeOptionsBlacknwhite')->__('Cloud Zoom')),
			array('value'=>'slider', 'label'=>Mage::helper('ThemeOptionsBlacknwhite')->__('Slider'))
        );
    }

}