<?php
//
// UserRepository.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 21, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\User;

/**
 * User repository
 */
interface UserRepository {

    /**
     * @param int $id User id to find
     * @return \Nvl\Cms\Domain\Model\User\User
     */
    public function find($id);

    /**
     * @param string $username Username to find
     * @return User
     */
    public function findByUsername($username);

    public function findBySocialNetwork($type, $id);

    /**
     * Add user
     *
     * @param \Nvl\Cms\Domain\Model\User\User $user
     */
    public function add(User $user);

    /**
     * Update given user
     *
     * @param \Nvl\Cms\Domain\Model\User\User $user
     */
    public function save(User $user);

}