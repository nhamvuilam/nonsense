<?php
class Core_Cache
{	
	private static $_instance = null;
	
	public $_cache;
	
	public $keyPrefix = '';
	
    public static function getInstance($config = array()){		
		$_instance = new Core_Cache;
		$_instance->_cache = Zend_Cache::factory('Core', 'Memcached', $config['frontend'], $config['backend']);		
		return $_instance;
	}
	
	protected function generateUniqueKey($key){
		return preg_replace('/[^a-zA-Z0-9_]/i', '_', $this->keyPrefix.$key);
	}
	
	public function load($id, $doNotTestCacheValidity = false){
		if($key = $this->generateUniqueKey($id)){
			return $this->_cache->load($key, $doNotTestCacheValidity);
		}
		return false;		
    }
	
	public function save($data, $id, $tags = array(), $specificLifetime = false){
		if($key = $this->generateUniqueKey($id)){
        	return $this->_cache->save($data, $key, $tags, $specificLifetime);
		}
		return false;
    }
	
	public function remove($id){
        return $this->_cache->remove($this->generateUniqueKey($id));
    }
	
	public function __call($method, $args){
		return call_user_func_array(array($this->_cache, $method), $args);
	}
}