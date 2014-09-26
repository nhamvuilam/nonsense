<?php
//
// SocialLogin.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 25, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\User;

/**
 * Social network login info
 */
class SocialLogin {

    private $id;
    private $type;

    public function __construct($type, $id) {
        $this->type = $type;
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function getType() {
        return $this->type;
    }
}