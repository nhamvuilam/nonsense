<?php
//
// ApplicationLifeCycle.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Oct 10, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms\Application;

use Nvl\Cms\App;
/**
 * @author Quyet. Nguyen Minh <minhquyet@gmail.com>
 */
class ApplicationLifeCycle {
    public static function begin() {

    }

    public static function success() {
        App::documentManager()->flush();
    }
}