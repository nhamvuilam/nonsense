<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Base
 *
 * @author longnc
 */
class Core_Translate_Base {
    //put your code here
    protected static $_instance = null;
    protected $source;
    protected $session;
    protected $support;
    /**
     * 
     * @param String $key
     * @param String $default
     * @return String
     */
    public function translate($key,$default = '') {
        if($this->source == null || empty($this->source)) {
            return $default;
        }
        if(isset($this->source[$key])) {
            return $this->source[$key];
        }
        return $default;
    }
}
