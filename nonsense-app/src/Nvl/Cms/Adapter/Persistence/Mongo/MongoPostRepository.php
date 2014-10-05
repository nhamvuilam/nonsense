<?php
//
// PostRepository.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 21, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Adapter\Persistence\Mongo;

use Doctrine\ODM\MongoDB\DocumentManager;
use Nvl\Cms\Domain\Model\Post\PostRepository;
use Nvl\Cms\Domain\Model\Post\Post;
use Nvl\Cms\Domain\Model\PaginatedResult;

/**
 * Mongo Db Post Repository implementation
 */
class MongoPostRepository implements PostRepository {

    private $_dm;

    public function __construct(DocumentManager $dm) {
        $this->_dm = $dm;
    }

	/**
     * @see \Nvl\Cms\Domain\Model\PostRepository::find()
     */
    public function find($id) {
        return $this->dm()->find('\Nvl\Cms\Domain\Model\Post\Post', $id);
    }

    /**
     * @see \Nvl\Cms\Domain\Model\Post\PostRepository::add()
     */
    public function add(Post $post) {
        $this->dm()->persist($post);
        $this->dm()->flush();
    }

    /**
     * @see \Nvl\Cms\Domain\Model\Post\PostRepository::save()
     */
    public function save(Post $post) {
        $this->dm()->persist($post);
        $this->dm()->flush();
    }

	/**
     * @see \Nvl\Cms\Domain\Model\Post\PostRepository::findBy()
     */
    public function findBy($query) {
        $queryBuilder = $this->dm()->createQueryBuilder('\Nvl\Cms\Domain\Model\Post\Post');

        if (!empty($query['tags'])) {
            $queryBuilder->field('meta.tags')->in($query['tags']);
        }
        if (!empty($query['authors'])) {
            $queryBuilder->field('author')->in((array) $query['authors']);
        }
        if (!empty($query['type'])) {
            $queryBuilder->field('content.type')->equals($query['type']);
        }
        if (!empty($query['status'])) {
            $queryBuilder->field('status')->equals($query['status']);
        }
        if (!empty($query['limit'])) {
            $queryBuilder->limit($query['limit']);
        }
        if (!empty($query['offset'])) {
            $queryBuilder->skip($query['offset']);
        }

        $queryBuilder->sort(array('createdDate' => 'desc'));

        return new PaginatedResult(
                $query['limit'],
                $query['offset'],
                $queryBuilder->getQuery()->count(),
                $queryBuilder->getQuery()->execute());
    }

    /**
     * @see \Nvl\Cms\Domain\Model\Post\PostRepository::latestOfTag()
     */
    public function latestOfTag($tag, $limit = 10) {
        return $this->dm()->createQueryBuilder('\Nvl\Cms\Domain\Model\Post\Post')
                          ->select()
                          ->sort(array('createdDate' => -1))
                          ->limit($limit)
                          ->getQuery()
                          ->execute();
    }

    /**
     * @return DocumentManager
     */
    public function dm() {
        return $this->_dm;
    }

	/* (non-PHPdoc)
     * @see \Nvl\Cms\Adapter\Persistence\Mongo\MongoRepository::collectionName()
     */
    public function collectionName() {
        return 'posts';
    }


}
