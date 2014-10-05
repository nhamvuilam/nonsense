<?php
//
// ContactInfo.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 25, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\User;

/**
 * User's contact info
 */
class ContactInfo {

    private $name;
    private $email;
    private $mobile;

    public function __construct($name, $email, $mobile) {
        $this->name = $name;
        $this->email = $email;
        $this->mobile = $mobile;
    }

    public function toArray() {
        return array(
        	'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
        );
    }
}
