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
use Nvl\Cms\Domain\Model\User\UserRepository;
use Nvl\Cms\App;
use Nvl\Cms\Domain\Model\Post\Post;
use Nvl\Stdlib\InvalidArgumentException;

/**
 * Post Application Service Implementation
 *
 * @author Nguyen Minh Quyet <minhquyet@gmail.com>
 */
class PostApplicationServiceImpl implements PostApplicationService {

    private $_postRepository;
    private $_userRepository;
    private $_postFactory;

    public function __construct(PostRepository $postRepository,
                                PostFactory $postFactory,
                                UserRepository $userRepo) {
        $this->_postRepository = $postRepository;
        $this->_userRepository = $userRepo;
        $this->_postFactory = $postFactory;
    }

    // =============================================================================================
    // POST APPLICATION SERVICE IMPLEMENTATION
    // =============================================================================================

    // Latest pending posts
    public function pendingPosts($limit = 10, $offset = 0) {
        return $this->queryPosts(
                '', '', Post::STATUS_PENDING_REVIEW, array(), $limit, $offset);
    }

    // Latest published posts
    public function latestPosts($limit = 10, $offset = 0) {
        return $this->queryPosts(
                '', '', Post::STATUS_PENDING_REVIEW, array(), $limit, $offset);
    }

    // Latest posts tagged with given tag
    public function latestPostsWithTag($tag, $limit = 10, $offset = 0) {
        if (!is_string($tag)) {
            throw new InvalidArgumentException('Tag is not a valid string');
        }

        return $this->queryPosts(
                '', '', Post::STATUS_PENDING_REVIEW, array($tag), $limit, $offset);
    }

    // Latest posts posted by given author id
    public function latestPostsOfAuthor($authorId, $limit = 10, $offset = 0) {

        if (!is_string($authorId)) {
            throw new InvalidArgumentException('Author id is not a valid id');
        }

        return $this->queryPosts(
                $authorId, '', Post::STATUS_PENDING_REVIEW, array(), $limit, $offset);
    }

    public function queryPosts($author = '', $type = '', $status = '',
                               $tags = array(), $limit = 10, $offset = 0) {
        $paginatedResult = $this->postRepository()->findBy(array(
        	'tags'    => $tags,
            'author'  => $author,
            'type'    => $type,
            'status'  => $status,
            'limit'   => $limit,
            'offset'  => $offset,
        ));

        $posts = array();
        foreach ($paginatedResult->data() as $post) {
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

    public function postInfo($id) {
        $post = $this->postRepository()->find($id);

        if (empty($post)) {
            return null;
        }

        return $post->toArray();
    }

    public function editPost($id, $editFields) {
        // TODO Auto-generated method stub
    }

    public function publish($id) {
        if (empty($id)) {
            throw new InvalidArgumentException('Post Id cannot be empty');
        }

        $post = $this->postRepository()->find($id);
        $post->publish();

        $this->postRepository()->save($post);
    }

    public function newPost($type, $tags, $date, $postContent, $metas = array()) {
        // Dummy author
        $author = 'nmquyet';
        $user = App::userApplicationService()->user();
        $author = $this->userRepository()->find($user['id']);
        if (empty($author)) {
            throw new \Exception('User not found');
        }

        // Create new post
        $post = $this->postFactory()->newPost($type, $postContent, $author, $date, $tags, $metas);

        // Save created post
        $this->postRepository()->add($post);
        return $post;
    }

    // =============================================================================================
    // HELPER METHODS
    // =============================================================================================

    private function postRepository() {
        return $this->_postRepository;
    }

    private function userRepository() {
        return $this->_userRepository;
    }

    private function postFactory() {
        return $this->_postFactory;
    }

}
