<?php

class IndexController extends Zend_Controller_Action {

    private $app;
    private $session;
    private $log;

    public function init() { 
        $this->session = new Zend_Session_Namespace(SESSION_USER_NAMESPACE);
        $this->app = Core_Global::getApplicationIni();
        $this->log = Core_Log::getInstance();
    }
    
    public function indexAction() {
    }
}
