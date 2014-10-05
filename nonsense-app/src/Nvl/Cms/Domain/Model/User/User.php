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
    private $loginInfo;
    private $contact;
    private $confirmed = false;
    private $status;

    private $stats;

    private $lastLogin;
    private $createdDate;
    private $modifiedDate;

    /**
     * Initiate new user
     *
     * @param Login       $loginInfo
     * @param ContactInfo $contact
     */
    public function __construct(Login $loginInfo, ContactInfo $contact) {

        $this->loginInfo = $loginInfo;
        $this->contact = $contact;
        $this->stats = new UserStats();

        $this->status = static::STATUS_INACTIVE;
        $this->createdDate = time();
        $this->modifiedDate = time();
    }

    public function activate() {
        $this->status = static::STATUS_ACTIVE;
    }

    public function authenticate() {
        $args = func_get_args();
        return call_user_func_array(array($this->loginInfo, 'authenticate'), $args);
    }

    public function toArray() {
        return array(
        	'id'            => $this->id,
            'contact'       => $this->contact->toArray(),
            'status'        => $this->status,
            'stats'         => $this->stats->toArray(),
            'last_login'    => $this->lastLogin,
            'created_date'  => $this->createdDate,
            'modified_date' => $this->modifiedDate,
        );
    }
}
