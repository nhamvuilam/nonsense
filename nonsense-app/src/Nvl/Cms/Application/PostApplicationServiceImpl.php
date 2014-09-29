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

	/* (non-PHPdoc)
     * @see \Nvl\Cms\Application\PostApplicationService::queryPosts()
     */
    public function queryPosts($authors = array(), $type = '', $tags = array(), $limit, $offset = 1) {
        // TODO Auto-generated method stub
    }

	/* (non-PHPdoc)
     * @see \Nvl\Cms\Application\PostApplicationService::editPost()
     */
    public function editPost($id, $editFields) {
        // TODO Auto-generated method stub
    }

	/* (non-PHPdoc)
     * @see \Nvl\Cms\Application\PostApplicationService::newPost()
     */
    public function newPost($type, $tags, $date, $postContent) {
        $author = 'nmquyet';
        $post = $this->postFactory()->newPost($type, $postContent, $author, $date, $tags);

        $this->postRepository()->add($post);

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
     * @return PostFactory
     */
    private function postFactory() {
        return $this->_postFactory;
    }

}