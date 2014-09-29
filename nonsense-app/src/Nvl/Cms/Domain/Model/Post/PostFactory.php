<?php
//
// PostFactory.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 28, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\Post;

use Nvl\Cms\Domain\Model\ValidateException;

/**
 * Post factory which is responsible for creating a new post
 *
 * @author Nguyen Minh Quyet <minhquyet@gmail.com>
 */
class PostFactory {

    const IMAGE = 1;
    const VIDEO = 2;

    public static $CODES = array(
        self::IMAGE => 'image', // image url, upload, draw
        self::VIDEO => 'video', // Youtube Url
    );

    private $_cdnService;

    public function __construct(CdnService $cdnService) {
        $this->_cdnService = $cdnService;
    }

    /**
     * Factory method to create a new post
     *
     * @param string $type
     * @param array  $contentArray
     * @param string $author
     * @param long   $date
     * @param array  $tags
     * @throws ValidateException
     * @return \Nvl\Cms\Domain\Model\Post\Post The new post object
     */
    public function newPost($type, $contentArray, $author, $date, $tags) {

        if (!$this->isValidType($type)) {
            throw new ValidateException('Invalid post type ['.$type.']');
        }

        $meta = new PostMeta();
        if (!empty($tags)) {
            $meta->addTag($tags);
        }

        $post = new Post($this->postContentOf($type, $contentArray), $meta, $author, $date);

        return $post;
    }

    // ========================================================================================
    // HELPER METHODS
    // ========================================================================================

    /**
     * Whether a given string is a valid post type
     *
     * @param string $typeString Post type string
     * @return boolean <code>true</code> if given string is valid
     */
    private function isValidType($typeString) {
        if (!in_array($typeString, static::$CODES)) {
            return false;
        }
        return true;
    }

    /**
     * @param string $type         Post type
     * @param array  $contentArray Post content array
     * @return \Nvl\Cms\Domain\Model\Post\PostContent
     */
    private function postContentOf($type, $contentArray) {

        switch ($type) {
        	case 'image':
        	    $postContent = new ImagePost($contentArray['caption'],
        	                                 $this->cdn()->thumb($contentArray['link']));
        	    break;
        	case 'video':
        	    $postContent = new VideoPost($contentArray['caption'], $contentArray['embedded']);
        	    break;
        }

        return $postContent;
    }

    private function cdn() {
        return $this->_cdnService;
    }
}