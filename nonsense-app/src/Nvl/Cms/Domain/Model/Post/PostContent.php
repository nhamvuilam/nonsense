<?php
//
// PostContent.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 28, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\Post;

/**
 * Post content
 *
 * @author Nguyen Minh Quyet <minhquyet@gmail.com>
 */
abstract class PostContent {

    private $caption;

    public function __construct($caption) {
        $this->caption = $caption;
    }

    /**
     * @return string The post title text
     */
    public function captionText() {
        return $this->caption;
    }

    /**
     * @return string The sanitized excerpt html string
     */
    public abstract function excerptHtml();

    /**
     * @return string The sanitized full post html string
     */
    public abstract function html();

    /**
     * @return array Post content as an array
     */
    public abstract function toArray();
}