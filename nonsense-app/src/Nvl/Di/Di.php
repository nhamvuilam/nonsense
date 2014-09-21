<?php
//
// Di.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 21, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Di;

/**
 * Dependency Injection interface
 */
interface Di {
    /**
     * @param string $service The service name to get
     * @return The service
     */
    public function get($service);

    /**
     * Set a service
     *
     * @param string $name      The name of service (must be unique)
     * @param mixed  $service   The service to set (may be an object, variable, constant or closure)
     * @param bool   $singleton Is set service singleton. Default TRUE
     */
    public function set($name, $service);
}