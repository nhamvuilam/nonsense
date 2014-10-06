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
use Nvl\Cms\App;

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
            $tmpFiles = array();

            foreach ($images as $index => $path) {
                if (strpos($path, 'http') === 0) {
                    $tmpFile = file_get_contents($path);
                    $tmpFilename = $this->tmpPath.'/dl_'.sha1(uniqid(microtime(true)));
                    file_put_contents($tmpFilename, $tmpFile);
                    $images[$index] = $tmpFilename;
                    $tmpFiles[] = $tmpFilename;
                }
            }

            $imagick = new \Imagick($images);
        } catch (\ImagickException $e) {
            throw new ValidateException(App::message('upload.resize.original_image_not_found'));
        }

        $imagick->setCompression(\Imagick::COMPRESSION_JPEG);
        $imagick->setCompressionQuality(100);

        $result = array();

        // Loop through each image and resize
        foreach ($imagick as $image) {

            // Generate various image sizes for current image
            foreach ($sizes as $name => $maxWidth) {
                $originalWidth = $image->getimagewidth();

                if (!$originalWidth) {
                    throw new \Exception('Not supported image');
                }

                // Only resize if original width larger than max width
                if ($maxWidth <= $originalWidth) {

                    // Resize image
                    $image->resizeImage($maxWidth, 0, \Imagick::FILTER_LANCZOS, 0.9);
                    // $image->thumbnailimage($width, 0);

                }

                // Save image to a temporary directory
                $outputPath = $this->filenameFor($name, $image);
                $image->writeimage($outputPath);

                $imageSet[$name] = array(
                    'path'   => $outputPath,
                    'width'  => $image->getimagewidth(),
                    'height' => $image->getimageheight(),
                );
            }

            /*
            if (empty($imageSet)) {
                $image->writeimage($this->filenameFor('regular', $image));
                $imageSet['regular'] = array(
                    'path'   => $image->getimagefilename(),
                    'width'  => $image->getimagewidth(),
                    'height' => $image->getimageheight(),
                );
            }
            */

            $result[] = $imageSet;
        }

        // Delete temporary file
        foreach ($tmpFiles as $tmp) {
            unlink($tmp);
        }

        $imagick->destroy();
        return $result;
    }

    private function filenameFor($sizeName, $image) {
        return $this->tmpPath.'/'.$sizeName.'_'.$image->getimagewidth().'_'.md5(uniqid(gethostname())).'.jpg';
    }

}
