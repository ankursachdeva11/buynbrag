<?php 

ini_set('display_errors',1);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
set_time_limit(0);
require_once '../app/Mage.php';
umask(0);
Mage::app('default');


$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$setup->addAttribute('customer', 'fuid', array(
    'label'     => 'Facebook UID',
    'type'      => 'varchar',
    'input'     => 'text',
    'visible'   => true,
    'required'  => false,
    'position'  => 1,
    ));
/* From Stackover http://stackoverflow.com/questions/4549112/can-no-longer-add-registration-fields-in-magento-1-4-2-0*/
$eavConfig = Mage::getSingleton('eav/config');
$attribute = $eavConfig->getAttribute('customer', 'fuid');
$attribute->setData('used_in_forms', array('adminhtml_customer','customer_account_create','customer_account_edit'));  //enable all action
//$attribute->setData('used_in_forms', array('adminhtml_customer'));  //to make the attribute can be created in backend only
//$attribute->setData('used_in_forms', array('customer_account_create')); //to make the attribute can be created in registration only
//$attribute->setData('used_in_forms', array('customer_account_edit')); // to make the attribute can be edited in the frontend only
 
$attribute->save();
$setup->addAttribute('customer', 'fbusername', array(
    'label'     => 'Facebook Username',
    'type'      => 'varchar',
    'input'     => 'text',
    'visible'   => true,
    'required'  => false,
    'position'  => 1,
    ));
/* From Stackover http://stackoverflow.com/questions/4549112/can-no-longer-add-registration-fields-in-magento-1-4-2-0*/
$eavConfig = Mage::getSingleton('eav/config');
$attribute = $eavConfig->getAttribute('customer', 'fbusername');
$attribute->setData('used_in_forms', array('adminhtml_customer','customer_account_create','customer_account_edit'));  //enable all action
//$attribute->setData('used_in_forms', array('adminhtml_customer'));  //to make the attribute can be created in backend only
//$attribute->setData('used_in_forms', array('customer_account_create')); //to make the attribute can be created in registration only
//$attribute->setData('used_in_forms', array('customer_account_edit')); // to make the attribute can be edited in the frontend only
 
$attribute->save();
$setup->addAttribute('customer', 'about', array(
    'label'     => 'About Me',
    'type'      => 'varchar',
    'input'     => 'text',
    'visible'   => true,
    'required'  => false,
    'position'  => 1,
    ));
/* From Stackover http://stackoverflow.com/questions/4549112/can-no-longer-add-registration-fields-in-magento-1-4-2-0*/
$eavConfig = Mage::getSingleton('eav/config');
$attribute = $eavConfig->getAttribute('customer', 'about');
$attribute->setData('used_in_forms', array('adminhtml_customer','customer_account_create','customer_account_edit'));  //enable all action
//$attribute->setData('used_in_forms', array('adminhtml_customer'));  //to make the attribute can be created in backend only
//$attribute->setData('used_in_forms', array('customer_account_create')); //to make the attribute can be created in registration only
//$attribute->setData('used_in_forms', array('customer_account_edit')); // to make the attribute can be edited in the frontend only
 
$attribute->save();
//$setup->removeAttribute('customer', 'fbusername');
//$setup->removeAttribute('customer', 'fuid');
//$setup->removeAttribute('customer', 'about');