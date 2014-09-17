<?php
class ErrorController extends Zend_Controller_Action
{
	public function errorAction()
    {  
		if( empty($_GET['debug_page'])){			
			//ob_clean();
			//header('HTTP/1.1 301 Moved Permanently');
			//header('Location: /');
			//exit;
		}	
		//$this->_helper->layout->disableLayout();		
		//Grab the error object from the request
        $errors = $this->_getParam('error_handler'); 

        //$errors will be an object set as a parameter of the request object     
        switch ($errors->type) 
        { 
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER: 
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION: 
                //404 error
                $this->getResponse()->setHttpResponseCode(404); 
                $this->view->message = 'Page not found'; 
                break; 
            default: 
                //Application error
                $this->view->message = $errors->exception->getMessage(); 
                break; 
        } 
		
        // pass the environment to the view script so we can conditionally         
        $this->view->env = APPLICATION_ENV;
            
        // pass the actual exception object to the view
        $exception = $errors->exception; 
        $this->view->exception = $exception; 
        
        // pass the request to the view
        $this->view->request   = $errors->request;  
        $BrowserHeader = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '0';
    }


}

