<?php

class ValidateException extends \Exception {   

    public function __construct($code, $message) {
        parent::_construct($code, $message);        
    }    
}
