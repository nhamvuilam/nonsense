<?php
namespace Nvl\Content\Adapter\Http\Controllers;

use Phalcon\Mvc\Controller as PhalconController;

class IndexController extends PhalconController {

    public function indexAction() {
        echo "<h1>Hello!</h1>";
    }

}
