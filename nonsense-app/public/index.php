<?php

try {

	error_reporting(E_ERROR);

    define("APP_DIR", realpath(__DIR__ . '/../app'));
    define("STATIC_PATH", '/nhamvl');

    // Composer autoload
    $loader = require_once '../vendor/autoload.php';

    // Create a DI
    $di = new Phalcon\DI\FactoryDefault();

    $di->set('dispatcher', function() {
        $dispatcher = new Phalcon\Mvc\Dispatcher();
        $dispatcher->setDefaultNamespace('Nvl\Cms\Adapter\Http\Controllers\\');
        return $dispatcher;
    });

    // Setup the view component
    $di->set('view', function(){
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');

        $view->registerEngines(array(
            ".php" => 'Phalcon\Mvc\View\Engine\Php'
        ));

        return $view;
    });

    // Setup a base URI so that all generated URIs include the "tutorial" folder
    $di->set('url', function(){
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri('/');
        return $url;
    });
	
	//Specify routes for modules
	$di->set('router', function () {
		$router = new \Phalcon\Mvc\Router();		        		
		// This route only will be matched if the HTTP method is GET
		$router->addGet("/nham/{id}", "Detail::index");				
	    return $router;
	});

    // Handle the request
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch(\Phalcon\Exception $e) {
     echo "PhalconException: ", $e->getMessage();
}
