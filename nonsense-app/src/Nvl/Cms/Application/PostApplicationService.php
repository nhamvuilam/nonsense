<?php
//
// PostApplicationService.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 21, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Application;

use Nvl\Cms\Domain\Model\Post;

/**
 * Post Application Service
 */
class PostApplicationService {

    private $postRepository;

    public function __construct($postRepository) {
        $this->postRepository = $postRepository;
    }

    /**
     * Create new post
     *
     * @param string $title    Title
     * @param string $type     Post type
     * @param string $content  Post content
     * @param int    $author   User id
     */
    public function newPost($title, $type, $content, $author, $tags) {

        // Make new post
        $post = new Post(array(
            'title' => $title,
            'original_content' => $content,
            'author' => $author,
            'tags' => $tags
        ));

        // Approve post by default
        $post->approve();

        // Add new post to repository
        $this->postRepository()->add($post);
    }

    public function latestOfTag($tag, $limit, $page) {
        return $this->postRepository()->latestOfTag($tag);
    }

    /**
     * @return \Nvl\Cms\Domain\Model\PostRepository
     */
    private function postRepository() {
        return $this->postRepository;
    }
}