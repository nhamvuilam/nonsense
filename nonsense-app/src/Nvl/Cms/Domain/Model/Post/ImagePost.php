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
    }

	/**
     * @see \Nvl\Cms\Domain\Model\Post\PostContent::html()
     */
    public function html($attribs = array()) {
        return '<img src="'.$this->images[0]['url'].$this->buildHtmlAttribs($attribs).'" />';
    }

    /**
     * @see \Nvl\Cms\Domain\Model\Post\PostContent::toArray()
     */
    public function toArray() {
        return array(
           'type' => 'image',
    	   'caption' => $this->captionText(),
           'images'  => $this->images,
        );
    }

    public function type() {
        return 'image';
    }

}
