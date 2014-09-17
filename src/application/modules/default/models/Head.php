<?php

class Model_Head {

    protected static $_instance = null;

    /**
     * 
     * @return \Model_Head
     */
    public static function getInstance() {
        if (!empty(self::$_instance)) {
            return self::$_instance;
        }
        self::$_instance = new Model_Head();
        return self::$_instance;
    }

    public function __construct() {
        $this->headFiles = array('/js_templates.php');
        $this->title = SITE_TITLE;
        $this->description = SITE_DESCRIPTION;
        $this->keyword = SITE_KEYWORDS;
    }

    public function __destruct() {
        
    }

    private $title;
    private $description;
    private $keyword;
    private $headFiles;
    private $cssFiles = array();
    private $jsFiles = array();

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getKeyword() {
        return $this->keyword;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setKeyword($keyword) {
        $this->keyword = $keyword;
    }

    public function appendCssFiles($array,$path = '/css/') {
        foreach ($array as $file) {
            $this->cssFiles[] = Core_Global::getApplicationIni()->static_url . $path . $file;
        }
    }
    public function appendJsFiles($array,$path = '/js/') {
        foreach ($array as $file) {
            $this->jsFiles[] = Core_Global::getApplicationIni()->static_url . $path . $file;
        }
    }
    
    public function getCssFiles() {
        return $this->cssFiles;
    }

    public function getJsFiles() {
        return $this->jsFiles;
    }
    
    public function appendHeadFile($path) {
        $this->headFiles[] = $path;
    }

    public function getHeadFiles() {
        return $this->headFiles;
    }

}
