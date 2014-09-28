<?php
//
// PostType.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 28, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\Post;

/**
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 */
class PostType {

    const IMAGE = 1;
    const VIDEO = 2;

    public static $CODES = array(
        self::IMAGE => 'image', // image url, upload, draw
        self::VIDEO => 'video', // Youtube Url
    );

    /**
     * @param string $type         Post type
     * @param array  $contentArray Post content array
     * @return \Nvl\Cms\Domain\Model\Post\PostContent
     */
    public static function postContentOf($type, $contentArray) {

        switch ($type) {
        	case 'image':
        	    $postContent = new ImagePost($contentArray['caption'], $contentArray['link']);
        	    break;
        	case 'video':
        	    $postContent = new VideoPost($contentArray['caption'], $contentArray['embedded']);
        	    break;
        }

        return $postContent;
    }

}
