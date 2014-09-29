<?php
//
// LocalCdnService.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 29, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Adapter\Image;

use Nvl\Cms\Domain\Model\Post\CdnService;

/**
 * Local CDN Service
 *
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 */
class LocalCdnService implements CdnService {

	/**
     * @see \Nvl\Cms\Domain\Model\Post\CdnService::thumb()
     */
    public function thumb($imageUrl) {
        return array(
        	array(
        	   'url' => $imageUrl,
        	   'width' => 100,
        	   'height' => 100,
            ),
        	array(
        	   'url' => $imageUrl,
        	   'width' => 300,
        	   'height' => 300,
            ),
        	array(
        	   'url' => $imageUrl,
        	   'width' => 400,
        	   'height' => 400,
            ),
        );
    }

}
