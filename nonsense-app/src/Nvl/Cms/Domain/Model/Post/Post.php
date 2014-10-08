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
use Nvl\Stdlib\InvalidArgumentException;

/**
 * A cms post object
 *
 * @author Nguyen Minh Quyet <minhquyet@gmail.com>
 */
class Post {

    const STATUS_PENDING_REVIEW = "pending_review";
    const STATUS_PUBLISHED = "published";
    const STATUS_DELETED = "deleted";

    private static $ALLOWED_STATUS = array(
    	self::STATUS_PENDING_REVIEW,
        self::STATUS_PUBLISHED,
        self::STATUS_DELETED,
    );

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

    private $status = self::STATUS_PENDING_REVIEW;

    private $createdDate;

    private $modifiedDate;

    private $publishedDate;

    /**
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
     * Publish this post
     */
    public function publish() {
        if ($this->status == static::STATUS_PUBLISHED) {
            throw new \Exception('Post has already been published');
        }

        $this->status = static::STATUS_PUBLISHED;
        $this->refreshModifiedDate();
    }

    public function setStatus($status) {

        if (!in_array($status, static::$ALLOWED_STATUS)) {
            throw new InvalidArgumentException('Post status is not valid');
        }

        if ($status === static::STATUS_PUBLISHED) {
            $this->publishedDate = time();
        }

        $this->status = $status;
        $this->refreshModifiedDate();
    }

    /**
     * Promote this post
     */
    public function promote() {
        // TODO
        $this->refreshModifiedDate();
    }

    public function html($attribs = array()) {
        return $this->content->html($attribs);
    }

    private function refreshModifiedDate() {
        $this->modifiedDate = time();
    }

    public function toArray() {
        $postArray = array(
            'id'        => $this->id,
            'type'      => $this->content->type(),
            'post_url'  => '/nham/'.$this->id,
            'timestamp' => $this->createdDate,
            'metas'     => $this->meta->toArray(),
            'content'   => $this->content->toArray(),
            'author'    => $this->author->toArray(),
            'status'    => $this->status,
        );

        return $postArray;
    }

}
