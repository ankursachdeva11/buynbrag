<?php
require_once('app/Mage.php');

Mage::init();

$dbhost = 'bnbdb.c4xniebqwpch.ap-southeast-1.rds.amazonaws.com';
$dbuser = 'bnbuser';
$dbpass = '34d04b8745abd3ef7ea88d9ac0637e64';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

if(! $conn )
{
    die('Could not connect: ' . mysqli_error());
}


$user_query ='SELECT * FROM user_details limit 16900 ,10000';

mysqli_select_db($conn, 'bnbdb');
$user_retval = mysqli_query($conn, $user_query);

while($user = mysqli_fetch_array($user_retval, MYSQL_ASSOC) )
{
    $fbid = $user['fb_uid'];
    $fbusername = $user['username'];
    $password = $user['password'];
    $email = $user['email'];
    $full_name = $user['full_name'];
    $last_name = $user['nick_name'];
    $gender = $user['gender'];
    $street = $user['address'];
    $city = $user['city'];
    $dob = $user['date_of_birth'];
    $mob = $user['mob'];
    $state = $user['state'];
    $pin = $user['pin'];
    $created_at = $user['joined_date'];
    $about = $user['about_me'];
 



$first_name = explode(" ",$full_name);


	$email = $email;
	$firstName = $first_name[0];	
	$middleName = "";
	$lastName = $last_name;
 
	$address_city =$city;
	$address_country_id = "IN";
	$address_postcode = $pin;
    $address_street = $street;
	$address_telephone = $mob;
 
 
	$customer = Mage::getModel('customer/customer');
 
	$customer->setWebsiteId(Mage::app()->getWebsite()->getId());	
 
	$customer->loadByEmail($email);
 
	if (!$customer->getId()) {
 
		$customer->setEmail($email);
		$customer->setFirstname($firstName);
		$customer->setMiddlename($middleName);	
		$customer->setLastname($lastName);				
		$customer->setPassword('123456');
		$customer->setCreated_at($created_at); // set it
		$customer->setDob($dob);	
	    $customer->setCountryId('IN');
	    $customer->setFuid($fbid);
	    $customer->setGender(($gender !='male') ? '2':'1');
	    $customer->setStore_id('1');
	    $customer->setFbusername($fbusername);
	    $customer->setAbout($about);



		
 
 
	
 
	try {
		$customer->save();
		$customer->setConfirmation(null);
		if($customer->save()){

          $customer->loadByEmail($email);
          	$_custom_address = array (
			'firstname' => $first_name[0],
			'lastname' => $last_name,
			'street' => array (
				'0' => $street
			),
			'city' => $city,
			'region_id' => '',
			'region' => $state,
			'postcode' => $address_postcode,
			'country_id' => 'IN', /* Croatia */
			'telephone' => $mob,
		);
          	$customAddress = Mage::getModel('customer/address');
 
		$customAddress->setData($_custom_address)
					->setCustomerId($customer->getId())
					->setIsDefaultBilling('1')
					->setIsDefaultShipping('1')
					->setSaveInAddressBook('1');
		try {
			$customAddress->save();
		}
		catch (Exception $ex) {
			//Zend_Debug::dump($ex->getMessage());
		}
 
        echo "#".$user['user_id']." ".$customer->firstname." ".$customer->lastname." information is saved!<br>";

   }
   else{

        echo "An error occured while saving customer";
    }

		//$customer->sendPasswordReminderEmail(); // save successful, send new password
 
	}
	catch (Exception $ex) {
		Zend_Debug::dump($ex->getMessage());
	}
	}
}
?>