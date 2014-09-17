<?php
class Core_DataList_Column_LinkFrame extends Core_DataList_Column_Abstract
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
		$linkOption = $this->linkOptions;
		$linkOption['source'] = $url; 		
		echo Core_DataList_Html::openTag('td', $this->htmlOptions); 
		echo $value===null ? $this->grid->blankDisplay : Core_DataList_Html::link($this->escape($value), '#target', $linkOption);
		echo '</td>';
	}
}
