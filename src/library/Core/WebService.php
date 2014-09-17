<?php

class Core_WebService {

    const MD5_ALGORITHM = 1;
    const SHA1_ALGORITHM = 2;

    protected $endpoint;
    protected $soapClient;
    private $log;

    public function __construct($endpoint) {
        $this->endpoint = $endpoint;
        $this->soapClient = new SoapClient($this->endpoint);
        //$this->log = Core_Logger::getLogger($this);
        $this->init($endpoint);
    }

    public function init($endpoint) {
        
    }

    public function __call($name, $arguments) {
        try {
            // prepare parameters before calling web service
            $params = $this->prepareParams($arguments);

            // call webservice and return result
            $result = $this->soapClient->__soapCall($name, array($params));

            // prepare results before return
            $ret = $this->prepareResults($name, $arguments, $result);

            return $ret;
        } catch (Exception $e) {
            //$this->log->error($e, "{$this->endpoint}\t{$name}\tParams:" . json_encode($params));
            return null;
        }
    }

    protected function prepareParams($arguments) {
        return $arguments;
    }

    protected function prepareResults($methodName, $arguments, $results) {
        return $results;
    }

}

?>