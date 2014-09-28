<?php
//
// ConfigLoader.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 28, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Config;

/**
 * Config loader interface
 *
 * Implementation should supports extended scheme when loading config file.
 *
 * E.g. ConfigLoader will contain an array of config locations, when loading a config
 * file, the loader will looks at those locations to find matched config files.
 * If multiple config file exists in different location, the first config file will
 * be overridden by the latter.
 */
interface ConfigLoader {

    /**
     * @param string $name Config filename
     * @return array Array of config value
     */
    public function loadConfigFilename($name);
}