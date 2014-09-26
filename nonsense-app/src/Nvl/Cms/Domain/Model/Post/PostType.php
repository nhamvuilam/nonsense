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

    const IMAGE = "image"; // image url, upload, draw
    const VIDEO = "video"; // Youtube Url

    private $name;

    public static function IMAGE() {
        return new PostType(PostType::IMAGE);
    }

    public static function VIDEO() {
        return new PostType(PostType::VIDEO);
    }

    public function __construct($name) {
        $this->name = $name;
    }
}