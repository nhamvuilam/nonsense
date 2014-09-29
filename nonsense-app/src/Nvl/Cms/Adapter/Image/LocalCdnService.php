<?php

namespace Nvl\Cms\Adapter\Image;

use Nvl\Cms\Domain\Model\Post\CdnService;

/**
 *
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 *
 */
class LocalCdnService implements CdnService {

    /**
     * (non-PHPdoc)
     *
     * @see \Nvl\Cms\Domain\Model\Post\CdnService::put()
     *
     */
    public function put($file) {
        $dest = '/home/php/project/nonsense/nonsense-app/public/photos';

        if (!file_exists($dest)) {
            mkdir($dest, 0755);
        }

        $filename = basename($file);
        copy($file, $dest.'/'.$filename);
        return 'http://local.nhamvl.com/photos/'.$filename;
    }
}
