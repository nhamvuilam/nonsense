<?php
//
// UserController.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Oct 6, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Adapter\Http\Controllers;

use Nvl\Cms\App;
/**
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 */
class UserController extends BaseController {
    function logoutAction() {
        App::userApplicationService()->logout();
        $this->redirect($this->getReferer() ?: '/');
    }
}
