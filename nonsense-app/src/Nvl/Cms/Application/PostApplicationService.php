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
     *   'caption' => Title,
     *   'link'    => Video URL of supported sites
     * )
     * </pre>
     * @param array $meta [OPTIONAL] Additional meta data
     * @return array Newly created post
     *
     */
    public function newPost($type, $tags, $date, $postContent, $metas = array());

    /**
     * @param string $author  Limit to author id
     * @param string $type    Limit to this post type
     * @param string $status  Limit to this status
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
    public function queryPosts($author = '',
                               $type = '',
                               $status = '',
                               $tags = array(),
                               $limit, $offset = 1);

    public function pendingPosts($limit = 10, $offset = 0);
    public function latestPosts($limit = 10, $offset = 0);
    public function latestPostsWithTags($tag, $limit = 10, $offset = 0);
    public function latestPostsOfAuthor($authorId, $limit = 10, $offset = 0);

    /**
     * @param string $id The post id to find
     * @return Array of post's info or NULL if post id is not found
     */
    public function postInfo($id);

    /**
     * Publish a post with given id
     * @param string $id Post id to be published
     */
    public function publish($id);

    /**
     * Increase post's comment count
     *
     * @param string $postId Post id
     * @return number New comment count
     */
    public function incrCommentCount($postId);

    /**
     * Decrease post's comment count
     *
     * @param string $postId Post id
     * @return number New comment count
     */
    public function decrCommentCount($postId);

    /**
     * Increase post's like count
     *
     * @param string $postId Post id
     * @return number New like count
     */
    public function incrLikeCount($postId);

    /**
     * Decrease post's like count
     *
     * @param string $postId Post id
     * @return number New like count
     */
    public function decrLikeCount($postId);

    /**
     * Edit a post
     *
     * @param number $id         Post id to edit
     * @param array  $editFields Fields to edit
     */
    public function editPost($id, $editFields);

}