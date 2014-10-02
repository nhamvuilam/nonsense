<?php
namespace Nvl\Cms\Adapter\Http\Controllers;
use Nvl\Cms\App;
class IndexController extends BaseController {

    public function initialize()
    {
        $this->view->setLayout('main');
    }

    public function indexAction() {

		$arrayData = App::postApplicationService()->queryPosts();
		$this->view->setVars(array(
            'posts' => $arrayData,
            'display_slidebar' => 1
        ));
    }

}
