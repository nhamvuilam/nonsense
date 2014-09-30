<?php
//
// VideoPost.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 26, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\Post;

/**
 * Video post
 *
 * @author Nguyen Minh Quyet <minhquyet@gmail.com>
 */
class VideoPost extends PostContent {

    private $embedded;

    public function __construct($caption, $embedded) {
        parent::__construct($caption);
        $this->embedded = $embedded;
    }

	/**
     * @see \Nvl\Cms\Domain\Model\Post\PostContent::excerptHtml()
     */
    public function excerptHtml() {
        // TODO Auto-generated method stub
    }

	/**
     * @see \Nvl\Cms\Domain\Model\Post\PostContent::html()
     */
    public function html($attribs) {
        // TODO Auto-generated method stub
        return "";
    }

    /**
     * @see \Nvl\Cms\Domain\Model\Post\PostContent::toArray()
     */
    public function toArray() {
    }

    public function type() {
        return 'video';
    }
}
