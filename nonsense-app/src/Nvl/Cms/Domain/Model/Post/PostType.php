<?php
//
// PostType.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 24, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\Post;

/**
 * A post type
 */
class PostType {
    const IMAGE_LINK = "image_link";
    const VIDEO_LINK = "video_link";

    private $name;

    public static function IMAGE_LINK() {
        return new PostType(PostType::IMAGE_LINK);
    }

    public static function VIDEO_LINK() {
        return new PostType(PostType::VIDEO_LINK);
    }

    public function __construct($name) {
        $this->name = $name;
    }
}