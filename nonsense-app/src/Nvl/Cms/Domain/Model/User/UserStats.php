<?php
//
// UserStats.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Oct 3, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\User;

/**
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 */
class UserStats {

    private $publishedPostCount = 0;
    private $postCount = 0;
    private $likeCount = 0;

    public function toArray() {
        return array(
        	'published_post_count' => $this->publishedPostCount,
            'post_count'           => $this->postCount,
            'like_count'           => $this->likeCount,
        );
    }
}
