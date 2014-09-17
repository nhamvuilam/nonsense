<?php
class Core_Widget{
	private static $_viewPaths;	
	
	public function init(){}

	public function run(){}
	
	public function getView(){
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
		return $viewRenderer->view;
	}
	
	public function getRequest(){
		return Core_Request::getInstance();
	}
	
	public function appendScript($script){
		$this->getView()->headScript()->appendScript($script);
	}
	
	public function appendScriptFile($file){
		$this->getView()->headScript()->appendFile($file);
	}
	
	public function appendStylesheet($style){		
		$this->getView()->headLink()->appendStylesheet($style);
	}
	
	public function forward($url){
		ob_clean();
		header ('HTTP/1.1 301 Moved Permanently');
		header('Location: '.$url);
        exit;
	}
			
	public function render($view, $data=null, $return=false){
		if(($viewFile=$this->getViewFile($view))!==false){
			return $this->renderFile($viewFile, $data, $return);
		}else
			throw new Zend_Exception(sprintf('%s cannot find the view "%s".', get_class($this), $view));
	}
	
	public function renderHtml($_viewContent_, $_data_=null, $_return_=false){
		if(is_array($_data_))
			extract($_data_,EXTR_PREFIX_SAME,'data');
		else
			$data=$_data_;
			
		if($_return_){
			ob_start();
			ob_implicit_flush(false);			
			eval(' ?>'.$_viewContent_.'<?php ');
			return ob_get_clean();
		}else
			eval(' ?>'.$_viewContent_.'<?php ');		
		
	}
		
	public function widget($className,$properties=array(), $_return_=false){
		if(!preg_match('/^Core\_/', $className)){
			$className = "Widget_{$className}";	
		}
		
		$__start__ = microtime(true);		
        $widget=new $className();
		foreach($properties as $name=>$value)
			$widget->$name=$value;

		$widget->init();		
		if($_return_){
			ob_start();
			ob_implicit_flush(false);
			$widget->run();
			return ob_get_clean();
		}else
			$widget->run();
		
		$__end__ = microtime(true);	
		
		if(!preg_match('/^Core\_/', $className)){
			Core_Debug::getInstance()->add($className, ($__end__-$__start__)*1000, $properties);	
		}		
    }	
		
	private function getViewFile($viewName){		
		return $this->getViewPath().DIRECTORY_SEPARATOR.$viewName.'.php';
	}
	
	private function getViewPath(){
		$className=get_class($this);
		if(isset(self::$_viewPaths[$className]))
			return self::$_viewPaths[$className];			

		$class=new ReflectionClass($className);
		return self::$_viewPaths[$className]=dirname($class->getFileName()).DIRECTORY_SEPARATOR.'views';
	}	
	
	private function renderFile($_viewFile_, $_data_=null, $_return_=false){
		if(is_array($_data_))
			extract($_data_,EXTR_PREFIX_SAME,'data');
		else
			$data=$_data_;
		if($_return_){
			ob_start();
			ob_implicit_flush(false);
			
			if(is_file($_viewFile_) && file_exists($_viewFile_)){
				require($_viewFile_);
			}else{
				throw new Zend_Exception(strtr(Core_Global::getMessage()->public_error405,array(
					'{path}'=>$_viewFile_
				)));				
			}			
			return ob_get_clean();
		}else{
			if(is_file($_viewFile_) && file_exists($_viewFile_)){
				require($_viewFile_);
			}else{
				throw new Zend_Exception(strtr(Core_Global::getMessage()->public_error405,array(
					'{path}'=>$_viewFile_
				)));				
			}
		}	
	}
}
?>