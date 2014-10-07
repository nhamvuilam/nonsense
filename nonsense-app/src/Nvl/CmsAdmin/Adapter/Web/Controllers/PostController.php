<?php
//
// PostController.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Oct 7, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\CmsAdmin\Adapter\Web\Controllers;

use Nvl\Cms\App;
use Nvl\Cms\Adapter\Http\Controllers\BaseController;

/**
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 */
class PostController extends BaseController {

    const HOME_URL = '/nghiemtuc/post';

	public function initialize() {
		$this->view->setLayout('main');
	}

    function indexAction($offset = 0) {
        $posts = $this->postService()->pendingPosts(10, $offset);
        var_dump($posts);
        $this->view->setVars(array(
            'paginatedPost' => $posts,
        ));
    }

    function updateAction($id) {

        $this->postService()->editPost($id, array(
           'status' => $this->getPostParam('status'),
        ));

        $this->redirect(static::HOME_URL);
    }

    private function postService() {
        return App::postApplicationService();
    }
}
