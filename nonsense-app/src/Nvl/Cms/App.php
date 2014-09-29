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
use Nvl\Cms\Domain\Model\Post\PostFactory;
use Nvl\Cms\Domain\Model\Post\PostRepository;
use Nvl\Di\PhalconDi;
use Nvl\Cms\Adapter\Image\LocalCdnService;

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

            // POST services
            $di->set('post_repository', function() use ($di) {
            	return new MongoPostRepository(App::documentManager());
            });
            $di->set('cdn_service', function() {
        	    return new LocalCdnService();
            });
            $di->set('post_factory', function() {
            	return new PostFactory(App::cdnService());
            });
            $di->set('post_application_service', function() {
                return new PostApplicationServiceImpl(App::postRepository(), App::postFactory());
            });

            $di->set('document_manager', function() {
                $config = App::config();
                $mongoClient = new \MongoClient(
                        'mongodb://'.$config['db']['mongo.host']
                        .':'.$config['db']['mongo.port']
                        .'/'.$config['db']['mongo.dbname']);
                $mongoClient->selectDB($config['db']['mongo.dbname']);

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

    public static function cdnService() {
        return static::di()->get('cdn_service');
    }

    /**
     * @return PostFactory
     */
    public static function postFactory() {
        return static::di()->get('post_factory');
    }

    /**
     * @return PostRepository
     */
    public static function postRepository() {
        return static::di()->get('post_repository');
    }

    /**
     * @return \Nvl\Cms\Application\PostApplicationService
     */
    public static function postApplicationService() {
        return static::di()->get('post_application_service');
    }
}
