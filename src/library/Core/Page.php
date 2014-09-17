<?php

class Core_Page {

    protected static $_instance = null;
    public $_request = null;
    public $_view = null;
    public $image;
    public $_page = array(
        'title' => null,
        'meta' => array(
            'description' => null,
            'keywords' => null,
            'robots' => null,
        ),
        'layout' => null,
        'widget' => array()
    );

    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function init($request, $view) {
        $this->_request = $request;
        $this->_view = $view;
    }

    public function load() {
        $req = array(
            'title' => $this->_request->getParam("title", "index")
        );

        list($this->_page, $req) = Model_Page::getInstance()->find($req);
//		echo '<pre>';
//        print_r($this->_page);
//        echo '|';
//        print_r($req); exit;

        if (!empty($this->_page) && !empty($req)) {
            foreach ($req as $k => $v) {
                $this->_request->setParam($k, $v);
                if (preg_match('/^meta\_(\w+)$/', $k, $match)) {

                    if ('title' == $match[1]) {
                        if (!empty($this->_page['title'])) {
                            $this->_page['title'] = strtr($this->_page['title'], array('{title}' => $v));
                        } else {
                            $this->_page['title'] = $v;
                        }
                    } else {
                        if (!empty($this->_page['meta'][$match[1]])) {
                            $this->_page['meta'][$match[1]] = strtr($this->_page['meta'][$match[1]], array('{' . $match[1] . '}' => $v));
                        } else {
                            $this->_page['meta'][$match[1]] = $v;
                        }
                    }
                }
            }
        }
        //exit;

        if (empty($this->_page)) {
            throw new Zend_Exception(Core_Global::getMessage()->public_error404);
        }

        if (empty($this->_page['title']))
            $this->_page['title'] = PAGE_TITLE;

        if (empty($this->_page['meta']['description']))
            $this->_page['meta']['description'] = PAGE_DESCRIPTION;

        if (empty($this->_page['meta']['keywords']))
            $this->_page['meta']['keywords'] = PAGE_KEYWORDS;
    }

    public function getPane($i) {
        return isset($this->_page['widget'][$i]) ? $this->_page['widget'][$i] : array();
    }

}

?>
