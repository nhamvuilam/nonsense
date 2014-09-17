<?php
class Core_DataList_Column_Td extends Core_DataList_Column_Abstract
{
	public $name;

	public $value;
	
	public $options;

	public function init(){
		parent::init();
		if($this->name===null)
			$this->sortable=false;
	}

	public function renderDataCellContent($row, $data, $total=0){
		if($this->value!==null)
			$value=$this->evaluateExpression($this->value, array('data'=>$data, 'row'=>$row, 'total'=>$total));
		else if($this->name!==null)
			$value=$this->value($data, $this->name);
		
		echo '<td>';
		if(!empty($this->options)){
			echo empty($this->options[$value])?$this->grid->blankDisplay:$this->escape($this->options[$value]);
		}else
			echo $value===null ? $this->grid->blankDisplay : $this->escape($value);
		echo '</td>';
	}
}
