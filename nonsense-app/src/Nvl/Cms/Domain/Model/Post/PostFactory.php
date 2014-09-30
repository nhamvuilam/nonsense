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

    private $_imageProcessor;
    private $_cdnService;
    private $_imageSizes;

    public function __construct(ImageProcessor $imageProcessor,
                                CdnService $cdnService, $imageSizes) {
        $this->_imageProcessor = $imageProcessor;
        $this->_cdnService = $cdnService;
        $this->_imageSizes = $imageSizes;
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

        // Validate input
        if (!$this->isValidType($type)) {
            throw new ValidateException('Invalid post type ['.$type.']');
        }

        // Create post meta
        $meta = new PostMeta();
        if (!empty($tags)) {
            $meta->addTag($tags);
        }

        // Create new post instance
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

            // Create image post
        	case 'image':
                return $this->newImagePost($contentArray);

        	// Create video post
        	case 'video':
        	    return $this->newVideoPost($contentArray);

        	default:
        	    throw new \Exception('Invalid post type detected');
        }

    }

    /**
     * Create new image post
     *
     * @param array $contentArray
     * @return \Nvl\Cms\Domain\Model\Post\ImagePost
     */
    private function newImagePost($contentArray) {
        $image = !empty($contentArray['link']) ? $contentArray['link']
                                               : $contentArray['data'][0]['uploaded_path'];

        // Resize image
        $resizedImages = $this->imageProcessor()->resize($image, $this->_imageSizes);
        $storedImages = null;

        // Upload resized images to a CDN
        // XXX: At this phase, only allow upload one image
        foreach ($resizedImages[0] as $resizedImage) {
            $url = $this->cdnService()->put($resizedImage['path']);
            unlink($resizedImage['path']);
            $storedImages[] = array(
            	'url' => $url,
                'width' => $resizedImage['width'],
                'height' => $resizedImage['height'],
            );
        }

        // Create image post with the cdn location
        return new ImagePost($contentArray['caption'], $storedImages);
    }

    private function newVideoPost($contentArray) {
        return new VideoPost($contentArray['caption'], $contentArray['embedded']);
    }

    private function imageProcessor() {
        return $this->_imageProcessor;
    }

    private function cdnService() {
        return $this->_cdnService;
    }

    private function imageSizes() {
        return $this->_imageSizes;
    }
}