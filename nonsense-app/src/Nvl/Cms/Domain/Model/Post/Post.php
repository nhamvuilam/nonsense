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

use Nvl\Cms\Domain\Model\ValidateException;

/**
 * A cms post object
 *
 * @author Nguyen Minh Quyet <minhquyet@gmail.com>
 */
class Post {

    const STATUS_PENDING_REVIEW = "pending_review";
    const STATUS_PUBLISHED = "published";
    const STATUS_DELETED = "deleted";

    private $id;

    /**
     * @var unknown
     */
    private $author;

    /**
     * @var PostMeta
     */
    private $meta;

    /**
     * @var PostContent
     */
    private $content; // class

    private $status = 0;

    private $createdDate;
    private $modifiedDate;

    /**
     *
     * @param PostContent $content
     * @param PostMeta    $meta
     * @param string      $author
     * @param long        $date    Post time
     * @throws ValidateException
     */
    public function __construct(PostContent $content,
                                PostMeta $meta,
                                $author,
                                $date) {

        if (empty($content)) {
            throw new ValidateException("PostContent cannot be empty");
        }
        if (empty($author)) {
            throw new ValidateException("Author cannot be empty");
        }

        $this->content = $content;
        $this->meta = $meta;
        $this->author = $author;

        // default value for new post
        $this->createdDate = empty($date) ? time() : $date;
        $this->modifiedDate = $this->createdDate;
    }

    /**
     * Approve this post
     */
    public function approve() {
        $this->status = static::STATUS_PUBLISHED;
        $this->refreshModifiedDate();
    }

    /**
     * Promote this post
     */
    public function promote() {
        // TODO
        $this->refreshModifiedDate();
    }

    private function refreshModifiedDate() {
        $this->modifiedDate = time();
    }
}
