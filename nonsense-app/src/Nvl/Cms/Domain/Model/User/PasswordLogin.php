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

/**
 * Username, password login info
 */
class PasswordLogin {

    private $username;
    private $salt;
    private $password;

    public function __construct($username, $plainPassword) {
        $this->username = $username;
        $this->password = $plainPassword;
    }

    public function getUsername() {
        return $this->username;
    }
}