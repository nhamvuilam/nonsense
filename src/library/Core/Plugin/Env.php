<?php

class Core_Plugin_Env extends Zend_Controller_Plugin_Abstract {

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
        //Set parent params
        Zend_Registry::set(PARENT_PARAMS_CONFIG, $request->getParams());

        $app = Core_Global::getApplicationIni();
        $front = Zend_Controller_Front::getInstance();
        $front->setControllerDirectory(APPLICATION_PATH . '/modules/' . MODULE . '/controllers');

        //Layout setup
        $layoutInstance = Zend_Layout::startMvc(
                        array(
                            'layout' => 'main',
                            'viewSuffix' => 'php',
                            'layoutPath' => APPLICATION_PATH . '/modules/' . MODULE . '/views/layouts',
                        )
        );
        $front = Zend_Controller_Front::getInstance();
        $front->setDefaultModule(MODULE);

        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        if (null === $viewRenderer->view) {
            $viewRenderer->initView();
        }

        $viewRenderer->setViewSuffix('php');

        //Get current view
        $viewInstance = $layoutInstance->getView();
        $viewInstance->addBasePath(APPLICATION_PATH . '/modules/' . MODULE . '/views');
        $viewInstance->addHelperPath(APPLICATION_PATH . '/modules/' . MODULE . '/views/helpers');

        //Register language and default configuration
        $viewInstance->app = $app->app;

        $loaders[MODULE] = new Zend_Application_Module_Autoloader(array(
            'namespace' => NULL,
            'basePath' => APPLICATION_PATH . '/modules/' . MODULE,
        ));

        $loaders[MODULE]->addResourceTypes(array(
            'Form' => array(
                'namespace' => 'Form',
                'path' => '/forms',
            ),
            'Filter' => array(
                'namespace' => 'Form_Filter',
                'path' => '/forms/filters',
            ),
            'Model' => array(
                'namespace' => 'Model',
                'path' => '/models',
            )
        ));


        //Cleanup data
        unset($layoutInstance, $viewInstance);
    }

    public function dispatchLoopShutdown() {
        Core_Global::closeAllDb();
    }

}
