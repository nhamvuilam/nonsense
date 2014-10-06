<?php
//
// PostMeta.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 28, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\Post;

/**
 * Post meta data
 *
 * @author Nguyen Minh Quyet <minhquyet@gmail.com>
 */
class PostMeta {

    private $commentCount = 0;
    private $data;
    private $likeCount = 0;
    private $tags = array();
    private $sticky = false;

    public function __construct() {
    }

    public function incrCommentCount() {
        $this->commentCount++;
    }

    public function decrCommentCount() {
        $this->commentCount--;
    }

    public function incrLikeCount() {
        $this->likeCount++;
    }

    public function decrLikeCount() {
        $this->likeCount--;
    }

    public function addTag($tags) {
        $this->tags = array_unique(array_merge($this->tags, (array) $tags));
    }

    public function setData($data = array()) {
        $this->data = $data;
    }

    public function metadata() {
        return $this->data;
    }

    public function tagArray() {
        return $this->tags;
    }

    public function toArray() {
        return array(
        	'tags' => $this->tags,
            'comment_count' => $this->commentCount,
            'like_count' => $this->likeCount,
            'sticky' => $this->sticky,
            'additional_data' => $this->data,
        );
    }

}