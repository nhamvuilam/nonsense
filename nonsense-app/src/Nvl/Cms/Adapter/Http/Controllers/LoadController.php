<?php
namespace Nvl\Cms\Adapter\Http\Controllers;
use Nvl\Cms\App;
class LoadController extends BaseController {

    public function indexAction() {
    	if ($this->isAjax()) {
    		$arrayData = App::postApplicationService()->latestPosts($_GET['limit'], $_GET['offset']);
			echo json_encode($arrayData);exit;	
    	}		
    }
	
	public function incrLikeAction() {
		if ($this->isAjax()) {
			echo App::postApplicationService()->incrLikeCount($_GET['id']);
		}
	}
	
	public function incrCommentAction() {
		if ($this->isAjax()) {
			echo App::postApplicationService()->incrCommentCount($_GET['id']);
		}
	}
	
	public function decrLikeAction() {				
		if ($this->isAjax()) {
			echo App::postApplicationService()->decrLikeCount($_GET['id']);
		}
	}
	
	public function decrCommentAction() {
		if ($this->isAjax()) {
			echo App::postApplicationService()->decrCommentCount($_GET['id']);
		}
	}
	
}
