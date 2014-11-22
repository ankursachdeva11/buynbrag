<?php

/**
 * PayU_Order_Model_Cron
 *
 * Order Status Update CRON class for Magento
 *
 * PHP versions 5.x
 *
 * PayU India
 * Copyright PayU India (http://payu.in)
 *
 * Redistributions of files is strictly prohibited.
 * 
 * @author		  Ashok Vishwakarma
 * @copyright     Copyright PayU India
 * @link          http://payu.in
 * @package       Model
 * @license       PayU India (http://payu.in)
 */
class PayU_Order_Model_Cron {

    /**
     * PayU Merchant key
     *
     * @var string
     * @access private
     */
    private $_merchant_key;

    /**
     * PayU Merchant salt
     *
     * @var string
     * @access private
     */
    private $_merchant_salt;

    /**
     * PayU WsURL
     *
     * @var string
     * @access private
     */
    private $_ws_url;

    /**
     * Command Parameter for PayU WsURL
     *
     * @var string
     * @access private
     */
    private $_command;

    /**
     * Query String for CURL request
     *
     * @var string
     * @access private
     */
    private $_query_string;

    /**
     * Current Magento Order Id
     *
     * @var string
     * @access private
     */
    private $_order_id;

    /**
     * CURL response for on http request
     *
     * @var string
     * @access private
     */
    private $_output;

    /**
     * Update Order Status
     *
     * @param null
     * @return null
     * @access public
     */
    public function updateOderStatus() {
        //Magento Order Collection Model
        $orderCollection = Mage::getResourceModel('sales/order_collection');
        //Fetching the Orders
        $orderCollection
                ->addFieldToFilter('state', 'new') // Where state is new
                ->addFieldToFilter('status', 'pending') // And status is pending
                ->getSelect();
        foreach ($orderCollection->getItems() as $order) {
            //Magento Order Model
            $orderModel = Mage::getModel('sales/order');
            //Loading current order into memory by its id
            $orderModel->load($order->getId());
            //Fetching the MihPayId for the current upprocessed order
            $verifyPayment = $this->verifyPayment($order->getIncrementId())->toArray();           
            if (isset($verifyPayment['status']) && $verifyPayment['status'] == 1) {                
                foreach ($verifyPayment['transaction_details'][$order->getIncrementId()] as $key => $value) {
                    //Check if payment is done for the current Order
                    $checkPayment = $this->checkPayment($verifyPayment['transaction_details'][$order->getIncrementId()][$key]['mihpayid'])->toArray();
                    if (isset($checkPayment['status']) && $checkPayment['status'] == 1 && $checkPayment['transaction_details'][$order->getIncrementId()]['unmappedstatus'] == 'captured') {
                        //Set the new status for the current order
                        $orderModel->setStatus('Processing');
                        //Save the current order
                        $orderModel->save();
                        break;
                    } elseif (isset($checkPayment['status']) && $checkPayment['status'] == 1 && $checkPayment['transaction_details'][$order->getIncrementId()]['unmappedstatus'] == 'userCancelled') {
                        //Set the new status for the current order
                        $orderModel->setStatus('Cancelled');
                        //Save the current order
                        $orderModel->save();
						
                    } else {
                        $orderModel->setStatus('holded');
                        //Save the current order
                        $orderModel->save();
						
                    }    
                }
            }  
        
        }
      
    }

    /**
     * Verify Payment
     *
     * @param String Current Magento Order Id
     * @return object
     * @access public
     */
    public function verifyPayment($order_id) {
        //Set the command varibale to verify payment API
        $this->_command = 'verify_payment';
        //Making HTTP request to PayU Verification service
        $this->_output = $this->_initData()
                ->_prepareData($order_id)
                ->_curlExecute();
        return $this;
    }

    /**
     * Check Payment
     *
     * @param String Current PayU Id (MihPayId)
     * @return object
     * @access public
     */
    public function checkPayment($mihpayid) {
        //Set the command varibale to verify payment API
        $this->_command = 'check_payment';
        //Making HTTP request to PayU Verification service
        $this->_output = $this->_initData()
                ->_prepareData($mihpayid)
                ->_curlExecute();
        return $this;
    }

    /**
     * Initialize Data
     *
     * @param null
     * @return object
     * @access private
     */
    private function _initData() {
        //Setting Merchnat Key
        $this->_merchant_key = "C0Dr8m";
        //Setting Merchnat Salt
        $this->_merchant_salt = "3sf0jURk";
        //Setting Ws URL
        $this->_ws_url = $this->_get_ws_url();
        return $this;
    }

    /**
     * Prepare Data
     *
     * @param String Current Magento Order Id or PayU MihPayId
     * @return object
     * @access private
     */
    private function _prepareData($order_id) {
        //Hash String
        $hash_str = $this->_merchant_key . '|' . $this->_command . '|' . $order_id . '|' . $this->_merchant_salt;
        // Hash
        $hash = strtolower(hash('sha512', $hash_str));
        //Request Parameters
        $r = array('key' => $this->_merchant_key, 'command' => $this->_command, 'hash' => $hash, 'var1' => $order_id);
        //Request Parameter http query string
        $this->_query_string = http_build_query($r);
        return $this;
    }

    /**
     * CURL Execute
     *
     * @param null
     * @return object
     * @access private
     */
    private function _curlExecute() {
        //Initalize CURL
        $c = curl_init();
        //Seting CURL Header to make a http request
        curl_setopt($c, CURLOPT_URL, $this->_ws_url);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $this->_query_string);
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
        //Executing CURL
        $o = curl_exec($c);
        //Check if CURL have any error
        if (curl_errno($c)) {
            $sad = curl_error($c);
            throw new Exception($sad);
        }
        //Closing CURL connection
        curl_close($c);
        return $o;
    }

    /**
     * Json to Array
     *
     * @param null
     * @return array
     * @access private
     */
    public function toArray() {
        //Json to Array
        return json_decode(json_encode(json_decode($this->_output)), true);
    }

    /**
     * Get Ws URL
     *
     * @param null
     * @return string
     * @access private
     */
    private function _get_ws_url() {
        //PayU getway mode configuration
        $mode = Mage::getStoreConfig('payment/payucheckout_shared/demo_mode');
        if ($mode == '') {
            return "https://info.payu.in/merchant/postservice?form=1";
        } else {
            return "https://test.payu.in/merchant/postservice?form=2";
        }
    }

}