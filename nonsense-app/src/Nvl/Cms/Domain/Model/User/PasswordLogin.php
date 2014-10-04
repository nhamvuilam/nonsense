<?php
//
// PasswordLogin.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 25, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\User;

use Nvl\Cms\Domain\Model\ValidateException;
use Nvl\Cms\App;
/**
 * Username, password login info
 */
class PasswordLogin extends Login {

    private $salt;
    private $password;

    public function __construct($username, $plainPassword) {
        parent::__construct($username);

        if (empty($plainPassword)) {
            throw new ValidateException(App::message('new_user.rule.password_empty'));
        }
        if (($length = strlen($plainPassword)) < 6 || $length > 32) {
            throw new ValidateException(
                    sprintf(App::message('new_user.rule.password_invalid_length')), 6, 32);
        }

        $this->salt = sha1(uniqid());
        $this->password = sha1($plainPassword.$this->salt);
    }

    public function authenticate($password) {

        if (sha1($password.$this->salt) === $this->password) {
            return true;
        }

        return false;
    }

}