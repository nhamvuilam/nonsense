<?php
//
// ConnectController.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Oct 6, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Adapter\Http\Controllers;

use Nvl\Cms\App;
use Nvl\OAuth\OAuthFactory;

/**
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 */
class ConnectController extends BaseController {

    function indexAction($type) {
        if ($type) {

            $config = App::config();
            $authFactory = new OAuthFactory($config['oauth']);
            $auth = $authFactory->getOAuth($type);

            if ($auth == null) {
                throw new \Exception('Sorry we have not supported this feature yet');
            }

            // authenticate user or redirect to social network login page
            $auth->process();

            $returnedUser = $auth->getUserInfo();
            if (!isset($returnedUser)) { throw new \Exception('Cannot get user info'); }

            // Dont allow user login if he/she do not have email account
            if (empty($returnedUser['email'])) {
                throw new \Exception('User do not have any email account');
            }

            App::userApplicationService()->connectSocialAccount($type, $returnedUser);

        }

        $this->redirect('/');
    }
}
