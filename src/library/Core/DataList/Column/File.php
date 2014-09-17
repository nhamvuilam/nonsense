<?php
class Core_DataList_Column_File extends Core_DataList_Column_Abstract
{
	public $name;
	
	public $fileHtmlOptions;
	
	public function init(){
		parent::init();
		if($this->name===null)
			$this->sortable=false;
	}
	
	public function renderDataCellContent($row, $data){
		$name = $this->name;
		if($name!==null)
			$name=$this->evaluateExpression($name, array('data'=>$data, 'row'=>$row));
		
		$options=$this->fileHtmlOptions;
		unset($options['name']);		
		$options['id']=$this->grid->id.'_input_'.$row;
		
		echo Core_DataList_Html::inputField('file', $name, '', $options);	
	}
}
?>