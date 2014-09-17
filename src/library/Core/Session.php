<?php

if (!isset($GLOBALS['THRIFT_ROOT'])) {
    $GLOBALS['THRIFT_ROOT'] = dirname(__FILE__) . '/thriftlib';
}
require_once $GLOBALS['THRIFT_ROOT'] . '/Thrift.php';
require_once $GLOBALS['THRIFT_ROOT'] . '/protocol/TBinaryProtocol.php';
require_once $GLOBALS['THRIFT_ROOT'] . '/transport/TSocket.php';
require_once $GLOBALS['THRIFT_ROOT'] . '/transport/THttpClient.php';
require_once $GLOBALS['THRIFT_ROOT'] . '/transport/TFramedTransport.php';
include_once $GLOBALS['THRIFT_ROOT'] . '/packages/sms/sms_types.php';
include_once $GLOBALS['THRIFT_ROOT'] . '/packages/sms/SessionServiceRead.php';
include_once $GLOBALS['THRIFT_ROOT'] . '/packages/sms/SessionServiceWrite.php';

class Core_Session {

    private $_socket = null;
    private $_transport = null;
    private $_protocol = null;
    private $_client_read = null;
    private $_client_write = null;
    private $_session = null;
    private $_sessionId = null;

    public function __construct($options) {
        $this->_socket = new TSocket($options['host'], $options['port']);
        $this->_transport = new TFramedTransport($this->_socket);
        $this->_protocol = new TBinaryProtocolAccelerated($this->_transport);
        $this->_client_read = new SessionServiceReadClient($this->_protocol);
        $this->_client_write = new SessionServiceWriteClient($this->_protocol);
    }

    public function create($uin, $zing, $account, $localIp, $useragent, $longSession) {
        $this->openTransport();
        return $this->_client_write->Create($uin, $zing, $account, $localIp, $useragent, $longSession);
    }

    public function read($zauth) {
        $this->openTransport();
        return $this->_client_read->GetSession($zauth);
    }

    public function openTransport() {
        if (!$this->_transport->isOpen())
            $this->_transport->open();
    }

    public function __destruct() {
        if ($this->_transport->isOpen())
            $this->_transport->close();
    }

    public function GetSessionWithCheckIP($sessionId, $clientIp) {
        $this->openTransport();
        return $this->_client_read->GetSessionWithCheckIP($sessionId, $clientIp);
    }

    public function GetSessionWithCheckIPBrowser($sessionId, $clientIp, $useragent) {
        $this->openTransport();
        return $this->_client_read->GetSessionWithCheckIPBrowser($sessionId, $clientIp, $useragent);
    }

    public function GetSessionWithCheckBrowser($sessionId, $useragent) {
        $this->openTransport();
        return $this->_client_read->GetSessionWithCheckBrowser($sessionId, $useragent);
    }

    public function getVNGSession($_server = '', $vngauth = 'vngauth') {
        try {
            $obj = new Core_Session($_server);
            $useragent = strtoupper(md5($_SERVER['HTTP_USER_AGENT']));
            $result = $obj->read($vngauth);
            $ip = $_SERVER['REMOTE_ADDR'];
            if ($result->resultCode == 0) {
                if ($result->session->useragent != $useragent)
                    return false;
                return array('uin' => $result->session->uin, 'acn' => strtolower($result->session->accountName));
            }
            return false;
        } catch (Exception $e) {
            Model_Redis::getInstance()->monitorDaily(array('type' => 'fe_vng_session_exception', 'code' => -1, 'info' => array('store' => 'Core_Session_getVNGSession', 'err' => $e->getMessage(), 'date' => date("Y-m-d H:i:s"))));
            return array('uin' => '', 'acn' => '');
        }
    }

    /**
     * Check user login or not
     * @return true if user login, otherwise is false
     */
    public function isLogin() {
        $eProfile = Core_Sso_Auth::getInstance()->getUserSession()->profile;
        if (!empty($eProfile) && !empty($eProfile['Id'])) {
            return true;
        }
        return false;
    }

}

?>
