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

use Nvl\Cms\Adapter\Persistence\Mongo\MongoPostRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\YamlDriver;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Nvl\Cms\Application\PostApplicationServiceImpl;
use Nvl\Config\SymfonyIniFileLoader;

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

            $di->set('post_repository', function() use ($di) {
            	return new MongoPostRepository(App::documentManager());
            });

            $di->set('post_application_service', function() use ($di) {
                return new PostApplicationServiceImpl($di->get('post_repository'));
            });

            $di->set('document_manager', function() {
                $mongoClient = new \MongoClient('mongodb://127.0.0.1:27017/nonsense_cms');
                $mongoClient->selectDB('nonsense_cms');

            	$connection = new Connection($mongoClient);

            	$mappingDriver = new YamlDriver(APP_DIR . '/configs/doctrine/', '.yml');

                $config = new Configuration();
                $config->setProxyDir(APP_DIR . '/caches/doctrine/proxies');
                $config->setProxyNamespace('Proxies');
                $config->setHydratorDir(APP_DIR . '/caches/doctrine/hydrators');
                $config->setHydratorNamespace('Hydrators');
                $config->setDefaultDB('nonsense_cms');
                $config->setMetadataDriverImpl($mappingDriver);

                return DocumentManager::create($connection, $config);

            });

            // Config file loader
            $di->set('config_loader', function() {
                $paths = array(
                    APP_DIR . '/configs',
                    APP_DIR . '/configs/local',
                );
                return new SymfonyIniFileLoader($paths);
            });

            // Cms Config
            $di->set('cms_config', function() {
                return App::configLoader()->loadConfigFilename('cms.ini');
            });
        }

        return $di;
    }

    /**
     * @return DocumentManager
     */
    public static function documentManager() {
        return static::di()->get('document_manager');
    }

    /**
     * @return array
     */
    public static function config() {
        return static::di()->get('cms_config');
    }

    /**
     * @return \Nvl\Config\ConfigLoader
     */
    public static function configLoader() {
        return static::di()->get('config_loader');
    }

    /**
     * @return \Nvl\Cms\Application\PostApplicationService
     */
    public static function postApplicationService() {
        return static::di()->get('post_application_service');
    }
}
