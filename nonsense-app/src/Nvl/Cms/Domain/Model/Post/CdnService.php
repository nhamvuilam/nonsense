<?php
//
// CdnService.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 29, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\Post;

/**
 * Content Delivery Network serivce
 *
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 */
interface CdnService {

    /**
     * Thumb given image url
     *
     * @param string $imageUrl
     * @return array An array of images in various sizes
     * <p>Each element will contain following keys:
     * <ul>
     * <li><b><code>url&nbsp;&nbsp;&nbsp;</code></b> - The image url
     * <li><b><code>width&nbsp;</code></b> - The image width
     * <li><b><code>height</code></b> - The image height
     * </ul>
     */
    public function thumb($imageUrl);
}