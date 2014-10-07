<?php
namespace Nvl\Cms;

use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface {

	/**
     * @see \Phalcon\Mvc\ModuleDefinitionInterface::registerAutoloaders()
     */
    public function registerAutoloaders() {
        // TODO Auto-generated method stub
    }

	/**
     * @see \Phalcon\Mvc\ModuleDefinitionInterface::registerServices()
     */
    public function registerServices($di) {
        $di->set('dispatcher', function() {
            $dispatcher = new \Phalcon\Mvc\Dispatcher();
            $dispatcher->setDefaultNamespace('Nvl\Cms\Adapter\Http\Controllers\\');
            return $dispatcher;
        });

        // Setup the view component
        $di->set('view', function(){
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir('./app/views/');

            $view->registerEngines(array(
                ".php" => 'Phalcon\Mvc\View\Engine\Php'
            ));

            return $view;
        });
    }

}