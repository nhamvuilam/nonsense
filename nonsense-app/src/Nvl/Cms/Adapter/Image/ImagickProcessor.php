<?php
//
// ImagickProcessor.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 29, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Adapter\Image;

use Nvl\Cms\Domain\Model\Post\ImageProcessor;
use Nvl\Cms\Domain\Model\ValidateException;

/**
 * ImageMagick processor
 *
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 */
class ImagickProcessor implements ImageProcessor {

    private $tmpPath = '/tmp';

    public function __construct($tmpPath) {
        if (isset($tmpPath)) {
            $this->tmpPath = $tmpPath;
        }
    }

	/**
     * @see \Nvl\Cms\Domain\Model\Post\ImageProcessor::resize()
     */
    public function resize($image, $sizes) {

        try {
            $images = (array) $image;
            $imagick = new \Imagick((array) $images);
        } catch (\ImagickException $e) {
            throw new ValidateException('Hình ảnh không tồn tại');
        }

        $imagick->setCompression(\Imagick::COMPRESSION_JPEG);
        $imagick->setCompressionQuality(100);

        $result = array();

        // Loop through each image and resize
        foreach ($imagick as $image) {

            // Generate various image sizes for current image
            foreach ($sizes as $name => $maxWidth) {
                $originalWidth = $image->getimagewidth();

                // Only resize if original width larger than max width
                if ($maxWidth <= $originalWidth) {

                    // Resize image
                    $image->resizeImage($maxWidth, 0, \Imagick::FILTER_LANCZOS, 0.9);
                    // $image->thumbnailimage($width, 0);

                    // Save image to a temporary directory
                    $outputPath = $this->filenameFor($name, $image);
                    $image->writeimage($outputPath);
                    $imageSet[] = array(
                        'path'   => $outputPath,
                        'width'  => $image->getimagewidth(),
                        'height' => $image->getimageheight(),
                    );
                }
            }

            if (empty($imageSet)) {
                $image->writeimage($this->filenameFor('regular', $image));
                $imageSet[] = array(
                    'path'   => $image->getimagefilename(),
                    'width'  => $image->getimagewidth(),
                    'height' => $image->getimageheight(),
                );
            }

            $result[] = $imageSet;
        }

        $imagick->destroy();
        return $result;
    }

    private function filenameFor($sizeName, $image) {
        return $this->tmpPath.'/'.$sizeName.'_'.$image->getimagewidth().'_'.md5(uniqid(gethostname())).'.jpg';
    }

}
