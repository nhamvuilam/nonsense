<?php

try {


    session_start();
    chdir('../');

    define("APP_DIR", realpath(__DIR__ . '/../app'));
    define("STATIC_PATH", '/nhamvl');

    // Composer autoload
    $loader = require_once 'vendor/autoload.php';

    // Create a DI
    $di = new Phalcon\DI\FactoryDefault();

    // Setup a base URI so that all generated URIs include the "tutorial" folder
    /*
    $di->set('url', function(){
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri('/');
        return $url;
    });
    */

	//Specify routes for modules
	$di->set('router', function () {
		$router = new \Phalcon\Mvc\Router();
		$router->setDefaultModule('frontend');

		$router->addGet('/nghiemtuc/post', 'admin::post::index');
		$router->addPost('/nghiemtuc/post/{id}', 'admin::post::update');

		// This route only will be matched if the HTTP method is GET
		$router->addGet("/nham/{id}", "Detail::index");
		$router->addGet("/connect/{type}", "Connect::index");
		$router->addGet("/logout", "User::logout");

	    return $router;
	});

    // Handle the request
    $application = new \Phalcon\Mvc\Application($di);
    $application->registerModules(array(
    	'frontend' => array(
    	    'className' => 'Nvl\Cms\Module',
    	    'path'      => getcwd().'/src/Nvl/Cms/Module.php',
        ),
    	'admin' => array(
    	    'className' => 'Nvl\CmsAdmin\Module',
    	    'path'      => getcwd().'/src/Nvl/CmsAdmin/Module.php',
        ),
    ));

    echo $application->handle()->getContent();

} catch(\Phalcon\Exception $e) {
     echo "PhalconException: ", $e->getMessage();
}
