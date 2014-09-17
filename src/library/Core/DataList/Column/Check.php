<?php
class Core_DataList_Column_Check extends Core_DataList_Column_Abstract
{
	public $name;

	public $value;
	
	public $checked;
	
	public $updateUrl;
	
	public $radioHtmlOptions=array();

	public function init(){
		parent::init();					
	}

	
	public function renderDataCellContent($row, $data){
		if($this->value!==null)
			$value=$this->evaluateExpression($this->value, array('data'=>$data, 'row'=>$row));
		else if($this->name!==null)
			$value=$this->value($data, $this->name);
		
		$checked = false;
		if($this->checked!==null)
			$checked=$this->evaluateExpression($this->checked,array('data'=>$data,'row'=>$row));

		$options=$this->radioHtmlOptions;		
		
		if(isset($options['name'])){
			$name=$options['name'];
			unset($options['name']);
		}else{
			$name=$this->grid->id.'_radio';
		}
		
		$options['value']=($value===null) ? $this->grid->blankDisplay : $this->escape($value);
		$options['id']=$this->grid->id.'_radio_'.$row;
		
		if(!empty($this->updateUrl)){		
			$options['onClick'] = "jQuery.fn.DataList.post('{$this->grid->id}', {url: '{$this->updateUrl}',data: {'data':{$value}}});";
		}	
		
		echo Core_DataList_Html::checkBox($name, $checked, $options);		
	}
}
?>