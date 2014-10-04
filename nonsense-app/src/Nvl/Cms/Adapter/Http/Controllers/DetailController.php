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
		$arrayData = array(
			'post' => $post,
		);

		/*
		$arrayData = array(
    	    'total' => 1,
            'current' => 0,
            'next' => 0,
            'previous' => 0,
            'posts' => array(
				'id' => 1,
				'type' => 'image',
				'post_url' => '/nham/1',
				'tags' => array('Nham','Fun'),
				'content' => array(
					'type' => 'image',
					'caption' => 'How to fun tonight',
					'images' => array(
						'medium' => array(
							'url' => 'http://localhost-nhamvl.test/photos/medium_450_82e1cc36eb68cf1bac6cb1a03b45537a.jpg',
							'width' => 450,
							'height' => 358
						),
						'large' => array(
							'url' => 'http://localhost-nhamvl.test/photos/large_450_13ccdb88b4d1dff24a8d89e2fb5711d6.jpg',
							'width' => 450,
							'height' => 358
						)
					)
				)
			),
        );
        */
		$this->view->setVars(array('data' => $arrayData, 'display_slidebar' => 1));
	}

}
