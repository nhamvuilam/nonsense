<?php
class Core_DataList_Column_Match extends Core_DataList_Column_Abstract
{
	public $name;

	public $value;
	
	public $index=0;
	
	public $pattern;
	
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
		
		if(!empty($this->pattern) && !empty($value)){
			if(preg_match($this->pattern, $value, $matches)){
				return isset($matches[$this->index+1])?$this->escape($matches[$this->index+1]):$this->grid->blankDisplay;
			}
		}
		return $this->grid->blankDisplay;
	}
}
