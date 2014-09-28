<?php
//
// IniFileLoader.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 28, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\ConfigLoader;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

/**
 * Yaml resource loader
 */
class IniFileLoader extends FileLoader {

	/* (non-PHPdoc)
     * @see \Symfony\Component\Config\Loader\LoaderInterface::load()
     */
    public function load($resource, $type = null) {
        $filePaths = $this->locator->locate($resource, null, false);

        foreach ($filePaths as $path) {
            parse_ini_file($path, true);
        }

    }

	/* (non-PHPdoc)
     * @see \Symfony\Component\Config\Loader\LoaderInterface::supports()
     */
    public function supports($resource, $type = null) {
        return is_string($resource) && 'ini' === pathinfo(
                $resource,
                PATHINFO_EXTENSION
        );
    }


}