<?php
//
// AuthenticationService.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 25, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\User;

/**
 * Authentication service
 */
interface AuthenticationService {
    public function authenticate($loginInfo);
}