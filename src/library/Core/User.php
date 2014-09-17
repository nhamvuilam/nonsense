<?php
class Core_User{
	var $config;
	public function __construct(){
		$this->config = Core_Global::getApplicationIni()->api;
	}
	
	/***Get User Login**/
	public function getUserLogin($vngauth=''){
		$userinfo = array();
		$options = array(
			'host' => $this->config->sso->server,
			'port' => $this->config->sso->port
		);
		$session = new Core_Session($options);
		$useragent = strtoupper(md5($_SERVER['HTTP_USER_AGENT']));
		$result = $session->read($vngauth);
		if($result->resultCode == 0){
			if($result->session->useragent != $useragent){}
			$userinfo = array('passportid'=>$result->session->uin,'zingid'=>strtolower($result->session->accountName));
		}
		return $userinfo;
	}

	

	/***** Get User Friend List ********/
	public function getZingFriends($zingid=''){
	}
	/***** Get User Profile ********/
	public function getZingProfile($zingid=''){
	}
	/***** set ProductHistory *****/
	public function getProductHistory($zingid=''){
		return true;
	}
	/***** get ProductHistory ******/
	public function setProductHistory($zingid='',$productid=''){
		return true;
	}
}
?>