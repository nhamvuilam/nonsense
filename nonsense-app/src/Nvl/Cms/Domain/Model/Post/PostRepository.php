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
     * @return \Nvl\Cms\Domain\Model\Post The post object
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

    /**
     * @param string $tag   Tag to query
     * @param number $limit Number of post to return
     * @return array Array of latest post
     */
    public function latestOfTag($tag, $limit = 10);

    /**
     * @return int - The next post id
     */
    // public function nextId();

}