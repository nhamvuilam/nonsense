<?php
//
// UserApplicationService.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Oct 3, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Application;

use Nvl\Cms\Domain\Model\User\SocialLogin;
use Nvl\Cms\Domain\Model\User\ContactInfo;
use Nvl\Cms\Domain\Model\User\User;
use Nvl\Cms\Domain\Model\User\UserRepository;
use Nvl\Cms\Domain\Model\User\PasswordLogin;
use Nvl\Cms\Domain\Model\ValidateException;
use Nvl\Cms\Domain\Model\User\AuthenticationException;
use Nvl\Cms\App;

/**
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 */
class UserApplicationService {

    private $_userRepository;

    public function __construct(UserRepository $postRepository) {
        $this->_userRepository = $postRepository;
    }

    public function authenticate($username, $password) {

        /* @var $user \Nvl\Cms\Domain\Model\User\User */
        $user = $this->userRepository()->findByUsername($username);

        if (empty($user)) {
            throw new AuthenticationException(App::message('auth.invalid_username'));
        }

        $ok = $user->authenticate($password);

        if (!$ok) {
            throw new AuthenticationException(App::message('auth.invalid_password'));
        }

        return $user;

    }

    /**
     * Register new user
     *
     * @param string $username
     * @param string $password
     * @param string $name
     * @param string $email
     * @param string $mobile
     * @return \Nvl\Cms\Domain\Model\User\User
     */
    public function register($username, $password, $name, $email, $mobile) {

        if (empty($username)) {
            throw new ValidateException('Username cannot be empty');
        }

        $loginInfo = new PasswordLogin($username, $password);

        $contact = new ContactInfo($name, $email, $mobile);

        $user = new User($loginInfo, $contact);

        $this->userRepository()->add($user);

        return $user;
    }

    public function registerSocial($socialId, $socialNetwork, $name, $email, $mobile) {

        $loginInfo = new SocialLogin($email, $socialNetwork, $socialId);

        $contact = new ContactInfo($name, $email, $mobile);

        $user = new User($loginInfo, $contact);

        $this->userRepository()->add($user);

        return $user;
    }

    private function userRepository() {
        return $this->_userRepository;
    }
}
