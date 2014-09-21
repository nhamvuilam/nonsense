<?php
namespace Nvl\Content\Adapter\Http\Controllers;

class IndexController extends BaseController {

    public function indexAction($name = "there" ) {
        echo "<h1>Hello!</h1>";
    }

}
