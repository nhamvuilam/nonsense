<?php
class Core_Request{
	protected $_request;

    public static function getInstance($className=__CLASS__){
		static $_instance = null;
        //Check instance
        if(empty($_instance)){
            $_instance = new $className;

            if($request = Core_Page::getInstance()->_request)
                $_instance->_request = Core_Page::getInstance()->_request;
            else
                $_instance->_request = Zend_Controller_Front::getInstance()->getRequest();

        }

        //Return instance
        return $_instance;
    }

	public function getParam($key, $default=NULL){
		$result = $this->_request->getParam($key, $default);

		if(in_array($key, array('category'))){
			$result = (int)$result;
		}

		return $result;
	}

	public function __call($method, $args){
		return call_user_func_array(array($this->_request, $method), $args);
	}

}