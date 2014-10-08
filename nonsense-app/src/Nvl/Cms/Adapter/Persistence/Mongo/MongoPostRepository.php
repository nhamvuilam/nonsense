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
use Nvl\Stdlib\PaginatedResult;
use Doctrine\ODM\MongoDB\Query\Builder;

/**
 * Mongo Db Post Repository implementation
 */
class MongoPostRepository implements PostRepository {

    private $_dm;

    public function __construct(DocumentManager $dm) {
        $this->_dm = $dm;
    }

    public function find($id) {
        return $this->dm()->find('\Nvl\Cms\Domain\Model\Post\Post', $id);
    }

    public function add(Post $post) {
        $this->dm()->persist($post);
        $this->dm()->flush();
    }

    public function save(Post $post) {
        $this->dm()->persist($post);
        $this->dm()->flush();
    }

    public function findBy($query) {

        $qb = $this->queryBuilder($query['limit'], $query['offset']);

        $this->filterByTags($qb, $query['tags']);
        $this->filterByAuthor($qb, $query['author']);
        $this->filterByStatus($qb, $query['status']);

        $qb->sort('createdDate', 'desc');

        return new PaginatedResult(
                $query['limit'],
                $query['offset'],
                $qb->getQuery()->count(),
                $qb->getQuery()->execute());
    }

    // Latest pending posts
    public function pendingPosts($limit = 10, $offset = 0) {
        $qb = $this->queryBuilder($limit, $offset);
        $this->filterByStatus($qb, Post::STATUS_PENDING_REVIEW);

        return new PaginatedResult(
                $limit,
                $offset,
                $qb->getQuery()->count(),
                $qb->getQuery()->execute());

    }

    // Latest published posts
    public function latestPosts($limit = 10, $offset = 0) {
        $qb = $this->queryBuilder($limit, $offset);
        $this->filterByStatus($qb, Post::STATUS_PUBLISHED);

        return new PaginatedResult(
                $limit,
                $offset,
                $qb->getQuery()->count(),
                $qb->getQuery()->execute());
    }

    // Latest posts tagged with given tag
    public function latestPostsWithTags(array $tags = array(), $limit = 10, $offset = 0) {
        $qb = $this->queryBuilder($limit, $offset);
        $this->filterByStatus($qb, Post::STATUS_PUBLISHED);
        $this->filterByTags($qb, $tags);

        return new PaginatedResult(
                $limit,
                $offset,
                $qb->getQuery()->count(),
                $qb->getQuery()->execute());
    }

    // Latest posts posted by given author id
    public function latestPostsOfAuthor($authorId, $limit = 10, $offset = 0) {
        $qb = $this->queryBuilder($limit, $offset);
        $this->filterByStatus($qb, Post::STATUS_PUBLISHED);
        $this->filterByAuthor($qb, $authorId);

        return new PaginatedResult(
                $limit,
                $offset,
                $qb->getQuery()->count(),
                $qb->getQuery()->execute());

    }

    /**
     * @return DocumentManager
     */
    public function dm() {
        return $this->_dm;
    }

    public function collectionName() {
        return 'posts';
    }

    // ==========================================================================
    // QUERY HELPER
    // ==========================================================================

    private function queryBuilder($limit = 10, $offset = 0) {
        return $this->dm()->createQueryBuilder('\Nvl\Cms\Domain\Model\Post\Post')
                          ->eagerCursor(true)
                          ->limit($limit)
                          ->skip($offset);
    }

    private function filterByAuthor(Builder $qb, $authorId) {
        if (!empty($authorId)) {
            $qb->field('author.$id')->equals(new \MongoId($authorId));
        }
        return $this;
    }

    private function filterByTags(Builder $qb, array $tags = array()) {
        if (!empty($tags)) {
            $qb->field('meta.tags')->in($tags);
        }
        return $this;
    }

    private function filterByStatus(Builder $qb, $status) {
        if (!empty($status)) {
            $qb->field('status')->equals($status);
        }

        return $this;
    }

}
