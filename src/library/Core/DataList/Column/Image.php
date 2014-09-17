<?php
class Core_DataList_Column_Image extends Core_DataList_Column_Abstract
{
	public $name;

	public $value;
	
	public $basicUrl;
	
	public $imageHtmlOptions;
	
	public $linkHtmlOptions;
	
	public $alt;
	
	public $url;

	public function init(){
		parent::init();
		if($this->name===null)
			$this->sortable=false;
	}

	public function renderDataCellContent($row, $data){
		if($this->value!==null)
			$value=$this->evaluateExpression($this->value, array('data'=>$data, 'row'=>$row));
		else if($this->name!==null)
			$value=$this->value($data, $this->name);
		
		$url = $this->evaluateExpression($this->url, array('data'=>$data, 'row'=>$row));
			
		echo empty($value) ? $this->grid->blankDisplay : Core_DataList_Html::link(Core_DataList_Html::image($this->basicUrl."/".$value, $this->alt, $this->imageHtmlOptions), $url, $this->linkHtmlOptions);
	}
}
