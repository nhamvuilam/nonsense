<?php

class Core_Debug {

    protected static $_instance = null;
    private $tracker;
    public $logger;

    public static function getInstance() {
        //Check instance
        if (empty(self::$_instance)) {
            self::$_instance = new Core_Debug;
        }

        //Return instance
        return self::$_instance;
    }

    public function add($name, $time, $arg = array(), $result = array()) {
        if ('development' == APPLICATION_ENV || isset($_GET['debug'])) {
            $this->tracker[] = array($name, $time, $arg, $result);
        }
    }

    public function append($key, $name, $result = array()) {
        if ('development' == APPLICATION_ENV || isset($_GET['debug'])) {
            $this->lg($name);

            if (empty($this->tracker[$key]))
                $this->tracker[$key] = array($key, 0, array($name => $result), array());
            else
                $this->tracker[$key][2][$name] = $result;
        }
    }

    public function get() {
        return $this->tracker;
    }

    public function lg($name) {
        $data = array('key' => $name, 'class' => array());

        $trace = array_reverse(debug_backtrace());
        foreach ($trace as $row) {
            if (!empty($row['class']) && preg_match('/^Widget|Core|Model|Form\_/', $row['class']) && !in_array($row['class'], array('Core_Debug', 'Core_Cache', 'Core_Widget', 'Widget_Public_Layout'))) {
                $class = $row['class'];
                if (!preg_match('/^Widget\_/', $row['class']) && !empty($row['type']) && !empty($row['function'])) {
                    $class = "{$class}{$row['type']}{$row['function']}()";
                }

                $data['class'][] = $class;
            }
        }

        $this->logger[] = $data;
    }
    
    public function debugapi($data, $exit = true, $request = 'debug_api'){
        if(isset($_REQUEST[$request]) && $_REQUEST[$request] == 1){
            echo '<pre>';
            print_r($data);
            if($exit) exit;
        }
    }

}

?>