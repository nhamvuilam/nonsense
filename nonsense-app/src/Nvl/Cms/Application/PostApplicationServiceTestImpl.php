<?php
//
// PostApplicationServiceTestImpl.php
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Application;


use Nvl\Cms\Domain\Model\Post\Post;
/**
 * Post Application Service
 */
class PostApplicationServiceTestImpl implements PostApplicationService {

    private $postRepository;

    public function __construct($postRepository) {
        $this->postRepository = $postRepository;
    }

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
     *   'data',
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
     *
     */
    public function newPost($type, $tags, $date, $postContent) {
    	return true;
    }

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
     *          array('url' => 'Image url', 'width' => width, 'height' => height),
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
    public function queryPosts($authors = array(), $type = '', $tags = array(), $limit, $offset = 1) {
    	$arrayData = array(
			'total' => 2,
			'current' => 1,
			'previous' => 1,
			'next' => 2,
			'posts' => array(
				array(
					'id' => 1,
					'type' => 'image',
					'post_url' => 'http://img-9gag-lol.9cache.com/photo/aAVP4Go_460sa_v1.gif',
					'timestamp' => '1411808560',
					'tags' => '',
					'image' => array(
						'caption' => 'image 1',
						'sizes' => array(
							array('url' => 'http://img-9gag-lol.9cache.com/photo/aAVP4Go_460sa_v1.gif', 'width' => '362', 'height' => '415')
						)
					)
				),
				array(
					'id' => 2,
					'type' => 'image',
					'post_url' => 'http://img-9gag-lol.9cache.com/photo/awbVLDW_460s.jpg',
					'timestamp' => '1411808560',
					'tags' => '',
					'image' => array(
						'caption' => 'image 2',
						'sizes' => array(
							array('url' => 'http://img-9gag-lol.9cache.com/photo/awbVLDW_460s.jpg', 'width' => '460', 'height' => '380')
						)
					)
				),
			)
		);
		return 	$arrayData;
    }

    /**
     * Edit a post
     *
     * @param number $id         Post id to edit
     * @param array  $editFields Fields to edit
     */
    public function editPost($id, $editFields) {
    	return true;
    }
}