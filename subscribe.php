<?php

require_once "./app/Mage.php"; 
 Mage::app('default');
	$email=$_REQUEST['email'];



		
// if we found the customer
$subscriber = Mage::getModel('newsletter/subscriber')->loadByEmail($email);
        if($subscriber->getStatus() != Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED) {
            
   
        if($subscriber->setImportMode(true)->subscribe($email)) echo 'done';

   

				}
				else{
					
				echo 'already';	
				}
?>