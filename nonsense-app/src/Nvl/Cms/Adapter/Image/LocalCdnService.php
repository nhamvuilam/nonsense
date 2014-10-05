<?php

namespace Nvl\Cms\Adapter\Image;

use Nvl\Cms\Domain\Model\Post\CdnService;

/**
 *
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 *
 */
class LocalCdnService implements CdnService {

    private $photosDir;
    private $cdnUrl;

    public function __construct($photosDir, $cdnUrl) {
        $this->photosDir = $photosDir;
        $this->cdnUrl = $cdnUrl;
    }

    /**
     * @see \Nvl\Cms\Domain\Model\Post\CdnService::put()
     */
    public function put($file) {

        if (!file_exists($this->photosDir)) {
            mkdir($this->photosDir, 0755);
        }

        $filename = basename($file);
        copy($file, $this->photosDir.'/'.$filename);
        return $this->cdnUrl.'/'.$filename;
    }
}
