<?php
class Core_DataList_Column_Text extends Core_DataList_Column_Abstract
{
	public $name;

	public $value;
	
	public $options;

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
		
		if(!empty($this->options)){
			echo empty($this->options[$value])?$this->grid->blankDisplay:$this->escape($this->options[$value]);
		}else
			echo $value===null ? $this->grid->blankDisplay : $this->escape($value);
	}
}
