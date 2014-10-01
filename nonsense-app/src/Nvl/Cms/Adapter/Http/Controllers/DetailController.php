<?php
namespace Nvl\Cms\Adapter\Http\Controllers;
use Nvl\Cms\App;
class DetailController extends BaseController {
	
	public function initialize()
    {
        $this->view->setLayout('main');        
    }
	   
    public function indexAction() {
    	$id = $this->getGetParam('id');		
    	$arrayData = array(
			'id' => 1,
			'type' => 'image',
			'post_url' => 'http://img-9gag-lol.9cache.com/photo/aAVP4Go_460sa_v1.gif',
			'timestamp' => '1411808560',
			'tags' => '',
			'image' => array(
				'caption' => 'image 1',
				'sizes' => array(
					array('url' => 'http://img-9gag-lol.9cache.com/photo/aAVP4Go_460sa_v1.gif', 'width' => '362', 'height' => '415')
				)
			)
		);
		$this->view->setVars(array(
            'data' => $arrayData,
            'display_slidebar' => 1
        ));				
    }

}
