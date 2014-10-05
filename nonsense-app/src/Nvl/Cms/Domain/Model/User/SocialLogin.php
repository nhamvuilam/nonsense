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
class SocialLogin extends Login {

    private $socialId;
    private $socialNetwork;

    public function __construct($email, $socialNetwork, $socialId) {
        parent::__construct($socialNetwork.$socialId);
        $this->socialNetwork = $socialNetwork;
        $this->socialId = $socialId;
    }

    public function socialId() {
        return $this->socialId;
    }

    public function socialNetwork() {
        return $this->socialNetwork;
    }

    public function authenticate() {
        return true;
    }
}