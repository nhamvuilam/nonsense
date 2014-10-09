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
use Nvl\Stdlib\InvalidArgumentException;
use Nvl\Stdlib\ValidateException;

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
        $pagedResult = $this->postRepository()->pendingPosts($limit, $offset);
        return $this->toArray($pagedResult, $limit, $offset);
    }

    // Latest published posts
    public function latestPosts($limit = 10, $offset = 0) {
        $pagedResult = $this->postRepository()->latestPosts($limit, $offset);
        return $this->toArray($pagedResult, $limit, $offset);
    }

    // Latest posts tagged with given tag
    public function latestPostsWithTags($tags, $limit = 10, $offset = 0) {
        $pagedResult = $this->postRepository()->latestPostsWithTags($tags, $limit, $offset);
        return $this->toArray($pagedResult, $limit, $offset);
    }

    // Latest posts posted by given author id
    public function latestPostsOfAuthor($authorId, $limit = 10, $offset = 0) {
        $pagedResult = $this->postRepository()->latestPostsOfAuthor($authorId, $limit, $offset);
        return $this->toArray($pagedResult, $limit, $offset);
    }

    public function queryPosts($author = '', $type = '', $status = '',
                               $tags = array(), $sort = array(), $limit = 10, $offset = 0) {
        $paginatedResult = $this->postRepository()->findBy(array(
        	'tags'    => $tags,
            'author'  => $author,
            'type'    => $type,
            'status'  => $status,
            'limit'   => $limit,
            'offset'  => $offset,
            'sort'    => $sort,
        ));

        return $this->toArray($paginatedResult, $limit, $offset);

    }

    public function postInfo($id) {
        $post = $this->postRepository()->find($id);

        if (empty($post)) {
            return null;
        }

        return $post->toArray();
    }

    public function editPost($id, $editFields) {
        $post = $this->findPostWithLock($id);

        if (!empty($editFields['status'])) {
            $post->setStatus($editFields['status']);
        }

        if (!empty($editFields['tags'])) {
            $post->meta()->setTags($editFields['tags']);
        }

        $this->postRepository()->save($post);
    }

    public function publish($id) {
        if (empty($id)) {
            throw new InvalidArgumentException('Post Id cannot be empty');
        }

        $post = $this->postRepository()->find($id);
        $post->publish();

        $this->postRepository()->save($post);
    }

    public function incrCommentCount($postId) {
        $post = $this->findPostWithLock($postId);
        $count = $post->meta()->incrCommentCount();
        $this->postRepository()->save($post);
        return $count;
    }

    public function incrLikeCount($postId) {
        $post = $this->findPostWithLock($postId);
        $count = $post->meta()->incrLikeCount();
        $this->postRepository()->save($post);
        return $count;

    }

    public function decrCommentCount($postId) {
        $post = $this->findPostWithLock($postId);
        $count = $post->meta()->decrCommentCount();
        $this->postRepository()->save($post);
        return $count;
    }

    public function decrLikeCount($postId) {
        $post = $this->findPostWithLock($postId);
        $count = $post->meta()->decrLikeCount();
        $this->postRepository()->save($post);
        return $count;
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
        return $post->toArray();
    }

    // =============================================================================================
    // HELPER METHODS
    // =============================================================================================

    private function toArray($paginatedResult, $limit, $offset) {
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

    private function findPostWithLock($id) {
        $post = $this->postRepository()->find($id, true);
        if (empty($post)) {
            throw new ValidateException('Post not found');
        }
        return $post;

    }

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
