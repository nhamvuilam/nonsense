<?php
//
// Post.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 21, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\Post;

/**
 * A cms post object
 *
 * Properties
 * <pre>
 * $_id;
 * $title;
 * $displayContent;
 * $originalContent;
 * $author;
 * $createdDate;
 * $modifiedDate;
 * $tags = array();
 * $status = 0;
 * $commentCount = 0;
 * likeCount = 0;
 * $sticky = false;
 * </pre>
 */
class Post {

    const STATUS_PENDING_REVIEW = "pending_review";
    const STATUS_PUBLISHED = "published";
    const STATUS_DELETED = "deleted";

    private $id;
    private $title;
    private $type;
    private $postContent; // class
    private $author;
    private $createdDate;
    private $modifiedDate;
    private $tags = array();
    private $status = 0;
    private $commentCount = 0;
    private $likeCount = 0;
    private $sticky = false;

    public function __construct($title, $type, $content, $author, $tags) {
        $this->title = $title;
        $this->type = $type;
        $this->originalContent = $content;
        $this->author = $author;
        $this->tags = $tags;

        // default value for new post
        $this->createdDate = time();
        $this->modifiedDate = $this->createdDate;
    }

    /**
     * Approve this post
     */
    public function approve() {
        $this->status = static::STATUS_PUBLISHED;
        $this->updateModifyDate();
    }

    /**
     * Promote this post
     */
    public function promote() {
        $this->sticky = true;
        $this->updateModifyDate();
    }

    private function updateModifyDate() {
        $this->modifiedDate = time();
    }
}
