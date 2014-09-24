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
    const TYPE_IMAGE_LINK = "image_link";
    const TYPE_VIDEO_LINK = "video_link";

    private $name;

    public function __construct($name) {
        $this->name = $name;
    }
}