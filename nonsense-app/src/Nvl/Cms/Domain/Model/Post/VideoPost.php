<?php
//
// VideoPost.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 26, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Domain\Model\Post;

use Nvl\Cms\Domain\Model\ValidateException;
/**
 * Video post
 *
 * @author Nguyen Minh Quyet <minhquyet@gmail.com>
 */
class VideoPost extends PostContent {

    private $link;
    private $embeddedCode;
    private $imageUrl;

    public function __construct($caption, $link) {
        parent::__construct($caption);
        $this->link = $link;
        $this->parseVideo();
    }

	/**
     * @see \Nvl\Cms\Domain\Model\Post\PostContent::excerptHtml()
     */
    public function excerptHtml() {
        // TODO Auto-generated method stub
    }

	/**
     * @see \Nvl\Cms\Domain\Model\Post\PostContent::html()
     */
    public function html($attribs) {
        return $this->embeddedCode;
    }

    /**
     * @see \Nvl\Cms\Domain\Model\Post\PostContent::toArray()
     */
    public function toArray() {
        return array(
        	'link'          => $this->link,
            'image_url'     => $this->imageUrl,
            'embedded_code' => $this->embeddedCode,
            'caption'       => $this->captionText(),
        );
    }

    /**
     * @see \Nvl\Cms\Domain\Model\Post\PostContent::type()
     */
    public function type() {
        return 'video';
    }

    private function parseVideo($attribs) {
        $video = $this->parseVideoInfo();

        $this->imageUrl = $video['image_url'];
        $this->embeddedCode = '<iframe width="640" height="360"
                                       src="'.$video['embedded_url'].'?rel=0&amp;showinfo=0"
                                       frameborder="0" allowfullscreen></iframe>';
    }

    private function parseVideoInfo() {
        $embeddedUrl = '//www.youtube.com/embed/';
        $imageUrl = null;

        $isMatch = preg_match('/(?<=v\=)[^&]+/', $this->link, $matches);

        if ($isMatch > 0) {
            $embeddedUrl .= $matches[0];
            $imageUrl = 'http://i.ytimg.com/vi/'.$matches[0].'/sddefault.jpg';
        } else {
            throw new ValidateException('Đường dẫn video không được hỗ trợ');
        }

        return array(
        	'embedded_url' => $embeddedUrl,
            'image_url'    => $imageUrl,
        );
    }
}