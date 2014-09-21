<?php
//
// PhalconDi.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 21, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms;

use Nvl\Di\Di;

/**
 * Phalcon dependency injection implementation
 */
class PhalconDi implements Di {

    /**
     * @var \Phalcon\DI|\Phalcon\DiInterface
     */
    private $di;

    /**
     * Constructor
     */
    public function __construct($di) {
        if (!isset($di)) {
            throw new \InvalidArgumentException('An instance of Phalcon\DiInterface must be specified');
        }
        $this->di = $di;
    }

	/* (non-PHPdoc)
     * @see \Nvl\Di\Di::get()
     */
    public function get($service) {
        return $this->di->get($service);
    }

	/* (non-PHPdoc)
     * @see \Nvl\Di\Di::set()
     */
    public function set($name, $service, $singleton = true) {
        return $this->di->set($name, $service, $singleton);
    }

}
