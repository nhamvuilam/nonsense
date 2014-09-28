<?php
//
// ImagePost.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 26, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\Post;

/**
 * Image post
 *
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 */
class ImagePost extends PostContent {

    private $images = array();

    public function __construct($caption, $images) {
        parent::__construct($caption);
        $this->images = $images;
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
    public function html() {
        // TODO
    }

    /**
     * @see \Nvl\Cms\Domain\Model\Post\PostContent::toArray()
     */
    public function toArray() {
        // TODO
    }


}
