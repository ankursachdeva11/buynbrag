<?php
class Adodis_Latesttweets_Block_Latesttweets extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getLatesttweets()     
     { 
        if (!$this->hasData('latesttweets')) {
            $this->setData('latesttweets', Mage::registry('latesttweets'));
        }
        return $this->getData('latesttweets');
        
    }
}