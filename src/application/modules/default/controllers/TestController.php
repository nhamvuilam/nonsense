<?php

class TestController extends Zend_Controller_Action {
	public function init() {
	}
    public function indexAction() {
        $this->_helper->layout->disableLayout();
	die('ABCD');
    }

}

?>
