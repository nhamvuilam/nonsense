<?php
class Core_DataList_Column_LinkPlus extends Core_DataList_Column_Abstract
{
	public $name;

	public $value;
	
	public $lable;
	
	public $url;
	
	public $linkOptions;

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
		else if($this->lable!==null){
			$value=$this->lable;
		}
		
		$url = $this->evaluateExpression($this->url, array('data'=>$data, 'row'=>$row));
		if($value===null || $value == 0){
			echo Core_DataList_Html::link('Retry', $url, $this->linkOptions);
		}else{
			echo '<span>Success</span>';	
		}		
	}
}
