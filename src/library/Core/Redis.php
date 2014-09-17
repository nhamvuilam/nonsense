<?php

class Core_Redis {

    protected $_redis;

    public function __construct($options = array()) {
        try {
            if ($options instanceof Zend_Config) {
                $options = $options->toArray();
            }
            if (empty($options['server'])) {
                return false;
                //Zend_Cache::throwException('Redis \'server\' not specified.');
            }

            if (empty($options['port']) && substr($options['server'], 0, 1) != '/') {
                return false;
                //Zend_Cache::throwException('Redis \'port\' not specified.');
            }

            $this->_redis = new Redis();
            
            if (isset($options['timeout'])) {
                $this->_redis->connect($options['server'], $options['port'], $options['timeout']);
            } else {
                $this->_redis->connect($options['server'], $options['port']);
            }
            
            //Authen when it's in production and staging
            if (in_array(APPLICATION_ENV, array('staging', 'production'))) {
                if (isset($options['password']) && !empty($options['password'])) {
                    try{
                        $this->_redis->auth($options['password']);
                    } catch (Exception $e){
                        Core_Log::sendLog('REDIS ERROR ' . $e->getMessage());
                    }
                }
            }

            $this->_redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);

            if (!empty($options['prefix']))
                $this->_redis->setOption(Redis::OPT_PREFIX, $options['prefix']);
        } catch (Exception $e) {
            return false;
        }
    }

    public function __call($name, $args) {
        return call_user_func_array(array($this->_redis, $name), $args);
    }

}