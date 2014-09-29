<?php
//
// ImageProcessor.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 29, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\Post;

/**
 * Image Storage service which generates different sizes for given image(s), stores and
 * returns location of generated images.
 *
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 */
interface ImageProcessor {

    /**
     * Generate various sizes for given image(s)
     *
     * @param string|array $image Image URL or array of uploaded image info
     * <p><em>Array format</em>
     * <pre>
     * array(
     *   array(
     *     'name' => '(string) Image name from $_FILES['name']',
     *     'type' => '(string) File type from $_FILES['type'],
     *     'uploaded_path' => '(string) Temporary image location from $_FILES['tmp_name']',
     *   ),
     *   ...
     * )
     * </pre>
     *
     * @param array $size Array of image sizes
     * <p><em>Size array format</em>
     * <pre>
     * array(
     *   'size_name' => '(number) image width',
     *   'another_size' => '',
     *   ...
     * )
     * </pre>
     *
     * @return array Generated images and its URL
     * <p>Each element will contain following keys:
     * <ul>
     * <li><b><code>url&nbsp;&nbsp;&nbsp;</code></b> - The image url
     * <li><b><code>width&nbsp;</code></b> - The image width
     * <li><b><code>height</code></b> - The image height
     * </ul>
     */
    public function resize($image, $sizes);
}