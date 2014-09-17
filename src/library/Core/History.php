<?php

class Core_History {

    protected static $_instance = null;

    public static function getInstance() {
        if (empty(self::$_instance)) {
            self::$_instance = new Core_History;
        }
        return self::$_instance;
    }

    public function add($product_id = '') {
        //$qty = Model_Order::getInstance()->chkPriceQuantity($product_id, 2);
        //$base = Model_Product::getInstance()->base($product_id);		
        //if($base['product_quantity'] > 0){
        $caching = Core_Global::getCaching();
        $keymemcache = Core_Global::getKeyPrefixCaching('user_history_key');
        $zingId = Model_User::getInstance()->getZingId();
        //$zingId = '';				
        if (empty($zingId)) {
            $session = new Zend_Session_Namespace('historyview');
            if ($session->data != "") {
                $zingId = $session->data;
            } else {
                $session->data = uniqid(APPLICATION_SERVER);
                $session->setExpirationSeconds(30 * 24 * 60 * 60);
                $zingId = $session->data;
            }

            //$zingId = isset($_COOKIE['historyview']) ? $_COOKIE['historyview'] : uniqid(APPLICATION_SERVER);
            //$expiretime = 30*24*60*60;	
            //if(!isset($_COOKIE['historyview'])){				
            //	setcookie("historyview", $zingId, time()+$expiretime);
            //}	
        }
        $result = $caching->load($keymemcache . $zingId);

        if (is_array($result) && (false !== ($index = array_search($product_id, $result)))) {
            unset($result[$index]);
        }
        $result[] = $product_id;
        $caching->save($result, $keymemcache . $zingId);
        //}    		    	    	
    }

    public function get() {
        static $history = NULL;

        if (empty($history)) {
            $caching = Core_Global::getCaching();
            $keymemcache = Core_Global::getKeyPrefixCaching('user_history_key');
            $zingId = Model_User::getInstance()->getZingId();
            if (empty($zingId)) {
                $session = new Zend_Session_Namespace('historyview');
                if ($session->data != "") {
                    $zingId = $session->data;
                } else {
                    //$session->data = uniqid(APPLICATION_SERVER);
                    //$session->setExpirationSeconds(30*24*60*60);					
                    $zingId = uniqid(APPLICATION_SERVER);
                }
                //$zingId = isset($_COOKIE['historyview']) ? $_COOKIE['historyview'] : uniqid(APPLICATION_SERVER);			 					
            }
            $history = $caching->load($keymemcache . $zingId);
        }

        return $history;
    }

    public function saveBookInfo($cName, $cEmail, $cPhoneNum, $search_id) {
        $session = new Zend_Session_Namespace('booking_info');
        $data = array(
            'cName' => $cName,
            'cEmail' => $cEmail,
            'cPhoneNum' => $cPhoneNum,
            'search_id' => $search_id
        );
        $session->data = $data;
    }

    public function getBookInfo() {
        $session = new Zend_Session_Namespace('booking_info');
        if (empty($session->data['cEmail'])) {
            $data = array(
                'cName' => "",
                'cEmail' => "",
                'cPhoneNum' => ""
            );
            $session->data = $data;
        }
        return $session->data;
    }

    public function saveSessionBookingHistory($order_id, $bookingInfo) {
        $session = new Zend_Session_Namespace('booking_history_order_' . $order_id);
        $session->data = $bookingInfo;
    }

    public function getSessionBookingHistory($order_id) {
        $session = new Zend_Session_Namespace('booking_history_order_' . $order_id);
        return $session->data;
    }

    public function saveSessionCancelInfo($order_id, $cancelInfo) {
        $session = new Zend_Session_Namespace('cancel_info_' . $order_id);
        $session->data = $cancelInfo;
    }

    public function getSessionCancelInfo($order_id) {
        $session = new Zend_Session_Namespace('cancel_info_' . $order_id);
        return $session->data;
    }

    public function saveSessionAmendInfo($order_id, $amendInfo) {
        $session = new Zend_Session_Namespace('amend_info' . $order_id);
        $session->data = $amendInfo;
    }

    public function getSessionAmendInfo($order_id) {
        $session = new Zend_Session_Namespace('amend_info' . $order_id);
        return $session->data;
    }

    public function saveRoomSearchTransaction($hotel_id) {
        $session = new Zend_Session_Namespace('search_room_tran_' . $hotel_id);
        $session->setExpirationSeconds(60 * 10); // 10 minutes        
        $session->data = 1;
    }

    public function checkRoomSearchTransaction($hotel_id) {
        $session = new Zend_Session_Namespace('search_room_tran_' . $hotel_id);
        if ($session->data)
            return TRUE;
        return FALSE;
    }
    
    public function saveHistorySearch($data){
        $session = new Zend_Session_Namespace('history-search');
        $session->data = $data;
    }
    
    public function getHistorySearch(){
        $session = new Zend_Session_Namespace('history-search');
        return $session->data;
    }

}

?>