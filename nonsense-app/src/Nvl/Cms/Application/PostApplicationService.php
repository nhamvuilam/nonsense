<?php
//
// PostApplicationService.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 26, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Application;

use Nvl\Cms\Domain\Model\Post\Post;

/**
 * Post application service provides interface for manipulate post objects
 *
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 */
interface PostApplicationService {

    /**
     * Create new post
     *
     * @param string $type Currently supports <code>image, video</code>
     * @param array  $tags
     * @param number $date Unix timestamp
     * @param array  $postContent
     *
     * <p>Type <code>image</code>
     * <pre>
     * array(
     *   'link',
     *   'data' => array(
     *     array(
     *       'uploaded_path' => /tmp
     *       'name'          => upload_test.jpg
     *       'type'          => image/jpeg
     *     ),
     *     [...]
     *   ),
     *   'caption'
     * )
     * </pre>
     *
     * <p>Type <code>video</code>
     * <pre>
     * array(
     *   'caption' => 'caption string',
     *   'embeded' => 'videos's <embeded/> tag'
     * )
     * </pre>
     * @return Post Newly created post
     *
     */
    public function newPost($type, $tags, $date, $postContent);

    /**
     * @param array  $authors Limit to these authors
     * @param string $type    Limit to this post type
     * @param array  $tags    Limit to these tags
     * @param array  $limit   Limit number of result
     * @param number $offset  Result offset
     * @return array Found posts
     * <pre>
     * array(
     *   'total' => total number of found posts,
     *   'current' => current page offset
     *   'previous' => previous page offset
     *   'next' => next page offset,
     *   'posts' => array(
     *      id        => The post's unique ID
     *      type      => The type of post
     *      post_url  => The location of the post
     *      timestamp => The time of the post, in seconds since the epoch
     *      tags      => Tags applied to the post
     *
     *      // If type is image
     *      'image' => array(
     *        'caption' => 'Image caption',
     *        'sizes' => array(
     *          array('url' => 'Image URL', 'width' => width, 'height' => height),
     *          ...
     *        ),
     *      ),
     *
     *      // If type is video
     *      'video' => array(
     *        'caption' => 'Video caption',
     *        'player' => array(
     *          array(
     *            'width' => embeded player width, 'player' => 'embeded HTML code'
     *          ),
     *          ...
     *        ),
     *      ),
     *   ),
     * )
     * </pre>
     */
    public function queryPosts($authors = array(), $type = '', $tags = array(), $limit, $offset = 1);

    /**
     * Edit a post
     *
     * @param number $id         Post id to edit
     * @param array  $editFields Fields to edit
     */
    public function editPost($id, $editFields);

}