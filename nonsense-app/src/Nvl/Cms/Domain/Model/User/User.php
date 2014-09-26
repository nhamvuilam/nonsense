<?php
//
// User.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 24, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\User;

/**
 * User
 */
class User {

    const STATUS_INACTIVE = "inactive";
    const STATUS_ACTIVE   = "active";
    const STATUS_BANNED   = "banned";

    private $id;
    private $passwordLogin;
    private $socialLogin;
    private $contact;
    private $status;

    private $postCount = 0;
    private $likeCount = 0;
    private $isConfirmed;
    private $lastLogin;
    private $createdDate;
    private $modifiedDate;

    /**
     * Initiate new user
     *
     * @param PasswordLogin $passwordLogin
     * @param SocialLogin   $socialLogin
     * @param ContactInfo   $contact
     */
    public function __construct(PasswordLogin $passwordLogin,
                                SocialLogin $socialLogin,
                                ContactInfo $contact) {

        $this->passwordLogin = $passwordLogin;
        $this->socialLogin = $socialLogin;
        $this->contact = $contact;

        $this->status = USER::STATUS_ACTIVE;
        $this->createdDate = time();
        $this->modifiedDate = time();
    }
}
