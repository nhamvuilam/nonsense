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
use Nvl\Cms\Domain\Model\User\AuthenticationException;
use Nvl\Cms\App;
use Nvl\Stdlib\ValidateException;

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

        $this->login($user);

        return $user;

    }

    /**
     * Connect with an OAuth account
     *
     * @param string $type     OAuth type string
     * @param array  $userInfo User info returned by OAuth Provider
     * @return \Nvl\Cms\Domain\Model\User\User
     */
    public function connectSocialAccount($type, $userInfo) {

        // Create OAuth account if not exists, otherwise verify return it
        $user = $this->userRepository()->findBySocialNetwork($type, $userInfo['id']);
        if (empty($user)) {
            $user = $this->registerSocial($userInfo['id'],
                                          $type,
                                          $userInfo['name'],
                                          $userInfo['email'],
                                          $userInfo['mobile']);

        }

        // Save user info to current session
        if (!empty($user)) {
            $this->login($user);
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

        ApplicationLifeCycle::success();

        return $user;
    }

    /**
     * Register social network account
     *
     * @param string $socialId
     * @param string $socialNetwork
     * @param string $name
     * @param string $email
     * @param string $mobile
     * @return \Nvl\Cms\Domain\Model\User\User
     */
    public function registerSocial($socialId, $socialNetwork, $name, $email, $mobile) {

        $loginInfo = new SocialLogin($email, $socialNetwork, $socialId);

        $contact = new ContactInfo($name, $email, $mobile);

        $user = new User($loginInfo, $contact);

        $this->userRepository()->add($user);

        ApplicationLifeCycle::success();

        return $user;
    }

    /**
     * Log current user out
     */
    public function logout() {
        unset($_SESSION['user']);
    }

    /**
     * @return boolean Flag indicates user is logged in or not
     */
    public function isLoggedIn() {
        return !empty($_SESSION['user']);
    }

    public function login(User $user) {
        $_SESSION['user'] = $user->toArray();
    }

    /**
     * @return User Current logged in user, return NULL if user is not logged in
     */
    public function user() {
        return $_SESSION['user'];
    }

    private function userRepository() {
        return $this->_userRepository;
    }
}
