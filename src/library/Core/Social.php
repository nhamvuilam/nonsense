<?php
class Core_Social {    
	protected static $_instance = null;
	protected $session;
	protected $app;
	protected $seckey = '123sociallogin';
	public static function getInstance(){
		if(!empty(self::$_instance)){
			return self::$_instance;
		}
		self::$_instance = new Core_Social();
		return self::$_instance;
		return new Core_Social();
	}
	public function __construct(){
		$this->session = new Zend_Session_Namespace('socialauth');
		$this->app = Core_Global::getApplicationIni();
	}
	public function __destruct() {
	}
	public function setKey() {
		$key = Core_Utils_Tools::genSecureKey();
		$key = strtolower($key);
		$this->session->key = $key;
		return $key;
	}
	public function getKey() {
		if(isset($this->session->key)) return $this->session->key;
		return '';
	}
}
