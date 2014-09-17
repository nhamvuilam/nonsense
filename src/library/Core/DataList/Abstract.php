<?php
abstract class Core_DataList_Abstract implements Core_DataList_Abstract_Interface
{	
	public $id;	
	
	public $template="main";
	
	public $emptyText;
	
	public $dataProvider;
	
	public $enableSorting=true;
	
	public $enablePagination=true;
	
	public $blankDisplay='&nbsp;';
	
	public $pager=array('class'=>'Core_DataList_Pagination_LinkPager');
	
	private static $_viewPaths = array();
	
	//Client JavaScript
	
	public $ajaxForm;
	
	public $ajaxRemove;
	
	public $ajaxUpdate;
	
	public $tableClass = 'grid-view';
	
	public $pagerCssClass = 'pager';    
	
	public $beforeAjaxUpdate;
	
	public $afterAjaxUpdate;
	
	public $baseUrl;
	
	public $rowHighlight;
	
	public function init(){
		if($this->dataProvider===null)
			throw new Zend_Exception('The "dataProvider" property cannot be empty.');
		
		if($this->template===null)
			throw new Zend_Exception('The "template" property cannot be empty.');	
	}
	
	public function run(){		
		$this->renderContent();		
		$this->registerClientScript();	
	}
	
	public function renderContent(){
		if(($viewFile=$this->getViewFile($this->template))!==false)
			$this->renderFile($viewFile);
		else
			throw new Zend_Exception(sprintf('%s cannot find the view "%s".', get_class($this), $this->template));
	}
	
	public function registerClientScript()
	{
		if($id=$this->id){
			$ajaxUpdate=preg_split('[,]',trim($this->ajaxUpdate.','.$id, ', '));
				
			$options=array(
				'ajaxUpdate'=>$ajaxUpdate,
				'ajaxForm'=>$this->ajaxForm,
				'ajaxRemove'=>$this->ajaxRemove,
				'tableClass'=>$this->tableClass,			
				'pagerClass'=>$this->pagerCssClass				
			);
			
			if($this->beforeAjaxUpdate!==null)
				$options['beforeAjaxUpdate']=(strpos($this->beforeAjaxUpdate,'js:')!==0 ? 'js:' : '').$this->beforeAjaxUpdate;
			if($this->afterAjaxUpdate!==null)
				$options['afterAjaxUpdate']=(strpos($this->afterAjaxUpdate,'js:')!==0 ? 'js:' : '').$this->afterAjaxUpdate;
				
			$options=Core_DataList_JavaScript::encode($options);			
			$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
			
			if($this->baseUrl !== false){
// 				$viewRenderer->view->headScript()->appendFile($this->baseUrl.'/js/datalist.js');
				$viewRenderer->view->headScript()->appendFile($this->baseUrl.'/js/jquery.blockUI.js');
// 				$viewRenderer->view->headLink()->appendStylesheet($this->baseUrl.'/css/datalist.css');	
			}
				
// 			$viewRenderer->view->headScript()->appendScript("
// 				jQuery(document).ready(function(){
// 					jQuery('#$id').DataList($options);
// 				});"
// 			);

			$viewRenderer->view->headScript()->appendScript("
				jQuery(document).ready(function(){
					jQuery('.page, .next, .last, .previous, .first').click(function(){
			            var p = $(this).attr('val');
			            $('#form_filter #page').val(p);
			            $('#form_filter').submit();
                    });
			        jQuery('#form_filter').submit(function() {
			            $('input:text[value=\"\"]').remove();
		            });
			        jQuery('input[type=submit]').click(function(){
                        $('#page').val('1');
		            });
				});"
			);
		}
	}	
	
	public function getEmptyText(){
		return $this->emptyText===null ? 'No results found.' : $this->emptyText;
	}	
	
	private function getViewFile($view){
		$className=get_class($this);
		if(isset(self::$_viewPaths[$className]))
			return self::$_viewPaths[$className];			

		$class=new ReflectionClass($className);
		return self::$_viewPaths[$className]=dirname($class->getFileName()).DIRECTORY_SEPARATOR.'DataList'.DIRECTORY_SEPARATOR.'Template'.DIRECTORY_SEPARATOR.$view.'.php';
	}	
	
	private function renderFile($_viewFile_, $_data_=null, $_return_=false){
		if(is_array($_data_))
			extract($_data_,EXTR_PREFIX_SAME,'data');
		else
			$data=$_data_;
		if($_return_){
			ob_start();
			ob_implicit_flush(false);
			require($_viewFile_);
			return ob_get_clean();
		}else
			require($_viewFile_);
	}
	
	public function widget($className, $properties=array()){
		$widget=new $className();
		foreach($properties as $name=>$value)
			$widget->$name=$value;
		
		$widget->init();			
		$widget->run();
		return $widget;	
	}
	
	public function createColumn($text){		
		$column=new Core_DataList_Column_Text($this);
		$column->name=$text;
		return $column;
	}
	
	public function createComponent($config, $grid){
		if(isset($config['class'])){
			$type="Core_DataList_Column_{$config['class']}";
			unset($config['class']);
		}
		else
			throw new Zend_Exception('Object configuration must be an array containing a "class" element.');
		if(($n=func_num_args())>1){
			$args=func_get_args();
			if($n===2)
				$object=new $type($args[1]);
			else if($n===3)
				$object=new $type($args[1],$args[2]);
			else if($n===4)
				$object=new $type($args[1],$args[2],$args[3]);
			else{
				unset($args[0]);
				$class=new ReflectionClass($type);
				$object=call_user_func_array(array($class,'newInstance'),$args);
			}
		}
		else
			$object=new $type;

		foreach($config as $key=>$value)
			$object->$key=$value;

		return $object;
	}
}