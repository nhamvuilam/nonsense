<?php
include_once $GLOBALS['SCRIBE_ROOT'].'/scribe.php';
include_once $GLOBALS['THRIFT_ROOT'].'/protocol/TBinaryProtocol.php';
include_once $GLOBALS['THRIFT_ROOT'].'/transport/TFramedTransport.php';
include_once $GLOBALS['THRIFT_ROOT'].'/transport/TSocketPool.php';
class Scriber {
    private $_scribe_servers = null; 
    private $_scribe_ports = null;

    private $_debug = 0;
    private $_send_timeout = 1000;
    private $_recv_timeout = 2500;
    private $_num_retries = 1;
    private $_randomize = false;
    private $_always_try_last = true;

    private $_socket = null;
    private $_transport = null;
    private $_protocol = null;
    private $_scribe_client = null;

    public function __construct($params = array()) {
	$this->_scribe_servers = 	$params['scribe_servers'];
	$this->_scribe_ports = 	$params['scribe_ports'];
	if(isset($params['debug']))
	    $this->_debug  = 	$params['debug'];
	if(isset($params['send_timeout']))
	    $this->_send_timeout = $params['send_timeout'];
	if(isset($params['recv_timeout']))
	    $this->_recv_timeout = $params['recv_timeout'];
	if(isset($params['num_retries']))
	    $this->_num_retries = $params['num_retries'];
	if(isset($params['randomize']))
	    $this->_randomize = $params['randomize'];
	if(isset($params['always_try_last']))
	    $this->_always_try_last = $params['always_try_last'];

	// Set up the socket connections
	$this->_socket = new TSocketPool($this->_scribe_servers, $this->_scribe_ports, TRUE );
	$this->_socket->setDebug($this->_debug);
	$this->_socket->setSendTimeout($this->_send_timeout);
	$this->_socket->setRecvTimeout($this->_recv_timeout);
	$this->_socket->setNumRetries($this->_num_retries);
	$this->_socket->setRandomize($this->_randomize);
	$this->_socket->setAlwaysTryLast($this->_always_try_last);
	$this->_transport = new TFramedTransport($this->_socket);
	$this->_protocol = new TBinaryProtocolAccelerated($this->_transport);

	// Create the client
	$this->_scribe_client = new scribeClient($this->_protocol);

    }

    public function writeLog($category,$message) {
	try {
	    $arr_msg = array();
	    $msg = new LogEntry;
	    $msg->category = $category;
	    $msg->message = $message;
	    $arr_msg[]= $msg;
	    $this->openTransport();
	    $result = $this->_scribe_client->Log($arr_msg);
	    if ($result <> 0) {
			throw new Exception('Warning: Log returned ' . $result);
	    }
	    return $result;
	}
	catch(Exception $ex) {
	    $this->closeTransport();
	    throw new Exception($ex->getMessage(),$ex->getCode());
	}

    }

    public function openTransport() {
	try {
	    if(!$this->_transport->isOpen())
		$this->_transport->open();
	}
	catch (Exception $ex) {

	    throw new Exception($ex->getMessage(),$ex->getCode());
	}

    }
    public function closeTransport() {
	if($this->_transport->isOpen())
	    $this->_transport->close();
    }
    public function  __destruct() {
	$this->closeTransport();
    }
}