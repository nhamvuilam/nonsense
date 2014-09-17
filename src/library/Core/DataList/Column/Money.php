<?php
class Core_DataList_Column_Money extends Core_DataList_Column_Abstract
{
	public $name;

	public $value;

	public $numOfDecimals= 0;
	public $decimalSeparator = ',';
	public $thousandSeparator = '.';

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
		echo $value===null ? $this->grid->blankDisplay : number_format($value + 0, $this->numOfDecimals, $this->decimalSeparator, $this->thousandSeparator) . ' đ';
	}
}
