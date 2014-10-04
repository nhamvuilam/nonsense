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
use Nvl\Cms\Domain\Model\ValidateException;
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
        /*
        $queryBuilder = $this->dm()->createQueryBuilder('\Nvl\Cms\Domain\Model\User\User');

        $queryBuilder->field('loginInfo.username')->equals($username);

        $cursor = $queryBuilder->getQuery()->execute();
        if ($cursor->count() > 1) {
            throw new \Exception('Duplicate username detected');
        }

        var_dump($cursor);

        return $cursor->first();
        */

        $user = $this->dm()->getRepository('\Nvl\Cms\Domain\Model\User\User')
                           ->findOneBy(array('loginInfo.username' => $username));

        return $user;
    }

	/**
     * @see \Nvl\Cms\Domain\Model\User\UserRepository::add()
     */
    public function add(User $user) {
        try {
            $this->dm()->persist($user);
            $this->dm()->getSchemaManager()->ensureIndexes();
            $this->dm()->flush(null, array('safe' => true));
        } catch (\MongoDuplicateKeyException $e) {
            throw new ValidateException(App::message('new_user.rule.username_existed'));
        }
    }

	/**
     * @see \Nvl\Cms\Domain\Model\User\UserRepository::save()
     */
    public function save(User $user) {
        $this->dm()->persist($user);
        $this->dm()->flush();

    }

    /**
     * @return DocumentManager
     */
    public function dm() {
        return $this->_dm;
    }


}