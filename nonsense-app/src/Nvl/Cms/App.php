<?php
//
// App.php
//
// Created by Quyet. Nguyen Minh <minhquyet@gmail.com> on Sep 21, 2014.
// Do not copy or use this source code without owner permission
//
// Copyright (c) Nvl 2014. All rights reserved.
//
//
namespace Nvl\Cms;

use Nvl\Cms\Application\PostApplicationService;
use Nvl\Cms\Adapter\Persistence\Mongo\MongoPostRepository;
/**
 * Application registry which return services needed by application
 * @author qunguyen
 */
class App {

    /**
     * @return \Nvl\Di\Di The dependency injection implementation
     */
    public static function di() {
        static $di;

        if (!isset($di)) {
            $di = new PhalconDi(\Phalcon\DI::getDefault());

            $di->set('db', function() {
                $mongoClient = new \MongoClient('mongodb://127.0.0.1:27017/nonsense_cms');
                return $mongoClient->selectDB('nonsense_cms');
            });

            $di->set('post_repository', function() use ($di) {
            	return new MongoPostRepository(array(
            	    'db' => $di->get('db')
            	));
            });

            $di->set('post_application_service', function() use ($di) {
                return new PostApplicationService($di->get('post_repository'));
            });
        }

        return $di;
    }

    /**
     * @return MongoDb
     */
    public static function db() {
        return static::di()->get('db');
    }

    /**
     * @return \Nvl\Cms\Application\PostApplicationService
     */
    public static function postApplicationService() {
        return static::di()->get('post_application_service');
    }
}
