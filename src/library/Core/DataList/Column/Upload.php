<?php
class Core_DataList_Column_Upload extends Core_DataList_Column_Abstract
{
	public $name;

	public $value;	
	
	public $alt;
	
	public $site;
	
	public $thumb;

	public $imageHtmlOptions=array('width'=>32, 'height'=>32);
	
	public $linkHtmlOptions=array('class'=>'fancybox');
	
	public function init(){
		parent::init();
		if($this->name===null)
			$this->sortable=false;
		
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
		$viewRenderer->view->headScript()->appendScript("
			jQuery(document).ready(function(){
				jQuery('a.fancybox').fancybox();				
			});"
		);	
	}

	public function renderDataCellContent($row, $data){
		if($this->value!==null)
			$value=$this->evaluateExpression($this->value, array('data'=>$data, 'row'=>$row));
		else if($this->name!==null)
			$value=$this->value($data, $this->name);
			
		echo $value===null ? $this->grid->blankDisplay : Core_DataList_Html::link(
																					Core_DataList_Html::image(Core_Image::path($value, $this->site, $this->thumb), $this->alt, $this->imageHtmlOptions), 
																					Core_Image::path($value, $this->site), $this->linkHtmlOptions);
	}
}
?>