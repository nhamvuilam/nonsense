<?php

class Core_OAuth_Factory {

    /**
     * Array of supported network
     */
    private $supported = null;

    /**
     * Constructor
     */
    public function __construct() {
        $this->config = Core_Global::getApplicationIni()->oauth;
        $this->supported = $this->config->supported;
    }

    /**
     * Factory method which returns a handler object for specific social network
     * @param $type The social network type
     * @return Core_OAuth_Abstract Authentication object for specific type or null if type is not supported
     */
    public function getOAuth($type, $key = NULL, $url = NULL) {
        $class = $this->supported->{$type}->class;
        if (isset($class) && class_exists($class)) {
            $oauth = new $class($this->config->consumer->linkback, $type, 
                                $this->config->proxy->address, $this->config->proxy->port,
                                $key, $url);
//            $oauth->consumerKey = $this->supported->{$type}->key;
//            $oauth->consumerSecret = $this->supported->{$type}->secret;
            $oauth->setVariable('consumerKey',$this->supported->{$type}->key);
            $oauth->setVariable('consumerSecret',$this->supported->{$type}->secret);
            return $oauth;
        }
        return null;
    }

}

?>
