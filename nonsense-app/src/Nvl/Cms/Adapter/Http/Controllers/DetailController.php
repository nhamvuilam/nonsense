<?php
namespace Nvl\Cms\Adapter\Http\Controllers;
use Nvl\Cms\App;
class DetailController extends BaseController {

	public function initialize() {
		$this->view->setLayout('main');
	}

	public function indexAction() {
		$id = $this->dispatcher->getParam("id");
		$post = App::postApplicationService()->postInfo($id);			
		$this->view->setVars(array('post' => $post, 'display_slidebar' => 1));
	}

}
