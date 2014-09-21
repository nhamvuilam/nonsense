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
namespace Nvl\Cms\Domain\Model;

use Nvl\Stdlib\ArrayObject;
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
class Post extends ArrayObject {

    const STATUS_PENDING_REVIEW = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_DELETED = -1;

    public function __construct($data) {
        parent::__construct($data);

        // default value for new post
        $this->setData('created_date', date('Y-m-d H:i:s'));
        $this->setData('modified_date', $this->getData('created_date'));
    }

    /**
     * Approve this post
     */
    public function approve() {
        $this->setData('status', static::STATUS_PUBLISHED);
        $this->updateModifyDate();
    }

    /**
     * Promote this post
     */
    public function promote() {
        $this->setData('sticky', true);
        $this->updateModifyDate();
    }

    private function updateModifyDate() {
        $this->setData('modified_date', date('Y-m-d H:i:s'));
    }
}
