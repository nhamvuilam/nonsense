<?php 
class Zend_View_Helper_Widget extends Zend_View_Helper_Abstract
{
    public function widget($className,$properties=array()){
		if(!preg_match('/^Core\_/', $className)){
			$className = "Widget_{$className}";
		}
		
        $widget=new $className();
		foreach($properties as $name=>$value)
			$widget->$name=$value;
			
		$widget->init();
		$widget->run();
		return $widget;
    }
}
?>