<?php
//
// PostApplicationServiceImpl.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 21, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Application;

use Nvl\Cms\Domain\Model\Post\PostFactory;
use Nvl\Cms\Domain\Model\Post\PostRepository;

/**
 * Post Application Service Implementation
 *
 * @author Nguyen Minh Quyet <minhquyet@gmail.com>
 */
class PostApplicationServiceImpl implements PostApplicationService {

    private $_postRepository;
    private $_postFactory;

    public function __construct(PostRepository $postRepository, PostFactory $postFactory) {
        $this->_postRepository = $postRepository;
        $this->_postFactory = $postFactory;
    }

    // =============================================================================================
    // POST APPLICATION SERVICE IMPLEMENTATION
    // =============================================================================================

	/**
     * @see \Nvl\Cms\Application\PostApplicationService::queryPosts()
     */
    public function queryPosts($authors = array(), $type = '', $tags = array(), $limit = 10, $offset = 0) {
        $paginatedResult = $this->postRepository()->findBy(array(
        	'tags'    => $tags,
            'authors' => $authors,
            'type'    => $type,
            'limit'   => $limit,
            'offset'  => $offset,
        ));

        $posts = array();
        foreach ($paginatedResult->data() as $post) {
            /* @var $post \Nvl\Cms\Domain\Model\Post\Post */
            $posts[] = $post->toArray();
        }

        return array(
    	    'total' => $paginatedResult->total(),
            'current' => (int) $offset,
            'next' => $paginatedResult->next(),
            'previous' => $paginatedResult->previous(),
            'posts' => $posts,
        );
    }

	/**
     * @see \Nvl\Cms\Application\PostApplicationService::editPost()
     */
    public function editPost($id, $editFields) {
        // TODO Auto-generated method stub
    }

	/**
     * @see \Nvl\Cms\Application\PostApplicationService::newPost()
     */
    public function newPost($type, $tags, $date, $postContent) {
        // Dummy author
        $author = 'nmquyet';

        // Create new post
        $post = $this->postFactory()->newPost($type, $postContent, $author, $date, $tags);

        // Save created post
        $this->postRepository()->add($post);
        return $post;
    }

    // =============================================================================================
    // HELPER METHODS
    // =============================================================================================

    /**
     * @return PostRepository
     */
    private function postRepository() {
        return $this->_postRepository;
    }

    /**
     * @return PostFactory
     */
    private function postFactory() {
        return $this->_postFactory;
    }

}