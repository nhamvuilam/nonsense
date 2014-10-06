<?php
namespace Nvl\Cms\Adapter\Http\Controllers;
use Nvl\Cms\App;
class LoadController extends BaseController {    

    public function indexAction() {		
		$arrayData = App::postApplicationService()->queryPosts(array(), '', '', array(), $_GET['limit'], $_GET['offset']);		
		echo json_encode($arrayData);exit;		
    }
}
