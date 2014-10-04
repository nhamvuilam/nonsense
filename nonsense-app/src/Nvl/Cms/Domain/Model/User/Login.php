<?php
//
// Login.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Oct 3, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\User;

use Nvl\Cms\Domain\Model\ValidateException;
use Nvl\Cms\App;
/**
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 */
abstract class Login {

    private $username;

    public function __construct($username) {

        if (empty($username)) {
            throw new ValidateException(App::message('new_user.rule.username_empty'));
        }
        if (($length = strlen($username)) < 6 || $length > 100) {
            throw new ValidateException(
                    sprintf(App::message('new_user.rule.username_invalid_length'), 6, 100));
        }

        $this->username = $username;
    }

    public function username() {
        return $this->username;
    }
    // public abstract function authenticate();
}