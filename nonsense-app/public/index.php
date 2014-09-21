<?php
require '../vendor/autoload.php';

try {

    //Register an autoloader
    $loader = new \Phalcon\Loader();
    $loader->registerNamespaces(array(
        'Nvl' => '../src/Nvl/',

    ))->register();

    //Create a DI
    $di = new Phalcon\DI\FactoryDefault();

    $di->set('dispatcher', function() {
        $dispatcher = new Phalcon\Mvc\Dispatcher();
        $dispatcher->setDefaultNamespace('\Nvl\Content\Adapter\Http\Controllers');
        return $dispatcher;
    });

    //Setup the view component
    $di->set('view', function(){
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');
        return $view;
    });

    //Setup a base URI so that all generated URIs include the "tutorial" folder
    $di->set('url', function(){
        $url = new \Phalcon\Mvc\Url();
        $url->setBaseUri('/');
        return $url;
    });

    //Handle the request
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch(\Phalcon\Exception $e) {
     echo "PhalconException: ", $e->getMessage();
}
