<?php
class Core_DataList_Column_Medium extends Core_DataList_Column_Abstract
{
	public $template;
	
	public function renderDataCellContent($row, $data, $total=0){
		if(!empty($this->template)){
			$this->renderHtml($this->template, array('row'=>$row, 'data'=>$data, 'total'=>$total));	
		}
	}
}
