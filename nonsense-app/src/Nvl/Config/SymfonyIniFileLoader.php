<?php
//
// SymfonyIniFileLoader.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 28, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Config;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\FileLocator;

/**
 * Symfony based INI file loader
 */
class SymfonyIniFileLoader extends FileLoader implements ConfigLoader {

    private $delegatingLoader;

    public function  __construct($configPaths) {
        parent::__construct(new FileLocator((array) $configPaths));

        $loaderResolver = new LoaderResolver(array($this));
        $this->delegatingLoader = new DelegatingLoader($loaderResolver);
    }

    public function loadConfigFilename($name) {
        return $this->delegatingLoader->load($name);
    }

	/* (non-PHPdoc)
     * @see \Symfony\Component\Config\Loader\LoaderInterface::load()
     */
    public function load($resource, $type = null) {
        $filePaths = $this->locator->locate($resource, null, false);

        $ini = array();
        $count = 0;
        foreach ($filePaths as $path) {
            $count++;
            $config = parse_ini_file($path, true);

            if ($count == 1) {
                $ini = $config;
                continue;
            }

            $ini = $this->extendArray($ini, $config);
            $count++;
        }

        return $ini;
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

    private function extendArray($base, $extended) {
        foreach ($base as $k => $v) {
            if (is_array($base[$k])) {
                if (isset($extended[$k])) {
                    if (is_array($extended[$k])) {
                        $base[$k] = $this->extendArray($base[$k], $extended[$k]);
                    } else {
                        $base[$k] = $extended[$k];
                    }
                }
            } else if (isset($extended[$k])) {
                $base[$k] = $extended[$k];
            }
        }
        return $base;
    }

}