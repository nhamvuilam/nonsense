<?php
//
// MongoUserRepository.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Oct 3, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Adapter\Persistence\Mongo;

use Nvl\Cms\Domain\Model\User\UserRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Nvl\Cms\Domain\Model\User\User;
use Nvl\Stdlib\ValidateException;
use Nvl\Cms\App;

/**
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 */
class MongoUserRepository implements UserRepository {

    private $_dm;

    public function __construct(DocumentManager $dm) {
        $this->_dm = $dm;
    }

	/**
     * @see \Nvl\Cms\Domain\Model\User\UserRepository::find()
     */
    public function find($id) {
        return $this->dm()->find('\Nvl\Cms\Domain\Model\User\User', $id);
    }

	/**
     * @see \Nvl\Cms\Domain\Model\User\UserRepository::findByUsername()
     */
    public function findByUsername($username) {

        $user = $this->dm()->getRepository('\Nvl\Cms\Domain\Model\User\User')
                           ->findOneBy(array('loginInfo.username' => $username));

        return $user;
    }

    /**
     * @see \Nvl\Cms\Domain\Model\User\UserRepository::findBySocialNetwork()
     */
    public function findBySocialNetwork($type, $id) {

        $user = $this->dm()->getRepository('\Nvl\Cms\Domain\Model\User\User')
                           ->findOneBy(array(
                               'loginInfo.socialNetwork' => $type,
                               'loginInfo.socialId' => $id
                           ));

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function add(User $user) {
        try {
            $this->dm()->persist($user);
            $this->dm()->getSchemaManager()->ensureIndexes();
        } catch (\MongoDuplicateKeyException $e) {
            throw new ValidateException(App::message('new_user.rule.username_existed'));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function save(User $user) {
        $this->dm()->persist($user);
    }

    /**
     * @return DocumentManager
     */
    public function dm() {
        return $this->_dm;
    }


}