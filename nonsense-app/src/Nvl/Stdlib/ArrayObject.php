<?php
//
// ArrayObject.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 21, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Stdlib;

/**
 * Base class which will store properties in an array.
 *
 * Class properties can be access through:
 * - getData() and setData() method
 * - getXxx() and setXxx() method
 */
class ArrayObject {
    /**
     * Static variable to store cached properties's underscore names
     * @var array
     */
    private static $_underscoreCache = array();

    /**
     * Properties array
     * @var array
     */
    private $_data;

    /**
     * Constructors
     * @param array $data
     */
    public function __construct($data = array()) {
        if (!empty($data)) {
            $this->load($data);
        }
    }

    /**
     * Get property
     *
     * @param string $name Property name
     * @param boolean $disableEscape Set to TRUE to disable html escape
     * @return mixed
     */
    public function getData($name, $disableEscape = null) {
        if (isset($this->_data[$name])) {
            if (empty($disableEscape) && is_string($this->_data[$name])) {
                return htmlspecialchars($this->_data[$name], ENT_QUOTES);
            }
            return $this->_data[$name];
        }
        return null;
    }

    /**
     * Set property value
     *
     * @param string $name
     * @param mixed  $value
     * @return ArrayObject
     */
    public function setData($name, $value) {
        if (!empty($name) && is_string($name)) {
            $this->_data[$name] = $value;
        }
        return $this;
    }

    /**
     * Unset data
     * @param string $key
     */
    public function unsetData($key) {
        unset($this->_data[$key]);
        return $this;
    }

    /**
     * Load class properties using provided array
     *
     * @param array $arr
     * @return ArrayObject
     */
    public function load($arr) {
        $this->_data = array_merge(!empty($this->_data) ? $this->_data : array(), $arr);
        return $this;
    }

    /**
     * Set/Get attribute wrapper
     *
     * @param   string $method
     * @param   array $args
     * @return  mixed
     */
    public function __call($method, $args) {
        switch (substr($method, 0, 3)) {
            case 'get' :
                //Varien_Profiler::start('GETTER: '.get_class($this).'::'.$method);
                $key = $this->_underscore(substr($method,3));
                $data = $this->getData($key, isset($args[0]) ? $args[0] : null);
                //Varien_Profiler::stop('GETTER: '.get_class($this).'::'.$method);
                return $data;

            case 'set' :
                //Varien_Profiler::start('SETTER: '.get_class($this).'::'.$method);
                $key = $this->_underscore(substr($method,3));
                $result = $this->setData($key, isset($args[0]) ? $args[0] : null);
                //Varien_Profiler::stop('SETTER: '.get_class($this).'::'.$method);
                return $result;

            case 'uns' :
                //Varien_Profiler::start('UNS: '.get_class($this).'::'.$method);
                $key = $this->_underscore(substr($method,3));
                $result = $this->unsetData($key);
                //Varien_Profiler::stop('UNS: '.get_class($this).'::'.$method);
                return $result;

            case 'has' :
                //Varien_Profiler::start('HAS: '.get_class($this).'::'.$method);
                $key = $this->_underscore(substr($method,3));
                //Varien_Profiler::stop('HAS: '.get_class($this).'::'.$method);
                return isset($this->_data[$key]);
        }
        throw new \RuntimeException("Invalid method ".get_class($this)."::".$method."(".print_r($args,1).")");
    }

    /**
     * Converts field names for setters and geters
     *
     * $this->setMyField($value) === $this->setData('my_field', $value)
     * Uses cache to eliminate unneccessary preg_replace
     *
     * @param string $name
     * @return string
     */
    protected function _underscore($name) {
        if (isset(self::$_underscoreCache[$name])) {
            return self::$_underscoreCache[$name];
        }
        $result = strtolower(preg_replace('/(.)([A-Z])/', "$1_$2", $name));
        self::$_underscoreCache[$name] = $result;
        return $result;
    }

    /**
     * @return Data array
     */
    public function toArray() {
        return $this->_data;
    }

}