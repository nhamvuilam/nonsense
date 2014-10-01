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

    public function __construct($caption, $link) {
        parent::__construct($caption);
        $this->link = $link;
        var_dump($link);
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
        return $this->embeddedCode($attribs);
    }

    /**
     * @see \Nvl\Cms\Domain\Model\Post\PostContent::toArray()
     */
    public function toArray() {
        return array(
        	'link'          => $this->link,
            'embedded_code' => $this->embeddedCode(),
            'caption'       => $this->captionText(),
        );
    }

    /**
     * @see \Nvl\Cms\Domain\Model\Post\PostContent::type()
     */
    public function type() {
        return 'video';
    }

    private function embeddedCode($attribs) {
        return '<iframe width="640" height="360"
                        src="'.$this->embeddedUrl().'?rel=0&amp;showinfo=0"
                        frameborder="0"
                        allowfullscreen></iframe>';
    }

    private function embeddedUrl() {
        $url = '//www.youtube.com/embed/';

        $isMatch = preg_match('/(?<=v\=)[^&]+/', $this->link, $matches);

        if ($isMatch > 0) {
            $url .= $matches[0];
        } else {
            throw new ValidateException('Đường dẫn video không được hỗ trợ');
        }

        return $url;
    }
}