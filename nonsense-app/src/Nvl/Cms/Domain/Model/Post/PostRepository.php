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
namespace Nvl\Cms\Domain\Model\Post;

use Nvl\Cms\Domain\Model\PaginatedResult;
/**
 * Post repository
 */
interface PostRepository {

    /**
     * @param string $id Post id to find
     * @return \Nvl\Cms\Domain\Model\Post\Post The post object
     */
    public function find($id);

    /**
     * Add new post
     *
     * @param \Nvl\Cms\Domain\Model\Post\Post $post The post object to save
     */
    public function add(Post $post);

    /**
     * Save a post
     *
     * @param \Nvl\Cms\Domain\Model\Post $post The post object to save
     */
    public function save(Post $post);

    /**
     * Find posts filtered by given query
     *
     * @param array $query
     * @return PaginatedResult
     */
    public function findBy($query);

    // Latest pending posts
    public function pendingPosts($limit = 10, $offset = 0);

    // Latest published posts
    public function latestPosts($limit = 10, $offset = 0);

    // Latest posts tagged with given tag
    public function latestPostsWithTags(array $tags = array(), $limit = 10, $offset = 0);

    // Latest posts posted by given author id
    public function latestPostsOfAuthor($authorId, $limit = 10, $offset = 0);

    /**
     * @return int - The next post id
     */
    // public function nextId();

}