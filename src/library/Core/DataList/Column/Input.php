<?php
class Core_DataList_Column_Input extends Core_DataList_Column_Abstract
{
	public $name;

	public $value;
	
	public $primary;
	
	public $updateUrl;
	
	public $linkHtmlOptions = array('class'=>'saveorder');
	
	public $inputHtmlOptions = array('class'=>'text-area-order', 'size'=>5);
	
	public $prefix = 'sort';

	public $selector = 'input.text-area-order';
	
	public function init(){
		parent::init();
		if($this->name===null)
			$this->sortable=false;
	}
	
	public function renderHeaderCellContent(){
		$out = parent::renderHeaderCellContent();		
		if($this->grid->dataProvider->getItemCount()>0 && !empty($this->primary) && !empty($this->updateUrl)){		
			$this->linkHtmlOptions['onClick'] = "jQuery.fn.DataList.post('{$this->grid->id}', {url: '{$this->updateUrl}',data: jQuery('#{$this->grid->id} {$this->selector}').serialize()});";
			$out .= Core_DataList_Html::link('', 'javascript:void(0);', $this->linkHtmlOptions);	
		}
			
		return $out;
	}

	public function renderDataCellContent($row, $data){
		if($this->value!==null)
			$value=$this->evaluateExpression($this->value, array('data'=>$data, 'row'=>$row));
		else if($this->name!==null)
			$value=$this->value($data, $this->name);
		
		$options=$this->inputHtmlOptions;
		unset($options['name']);		
		$options['id']=$this->grid->id.'_input_'.$row;
		
		if(!empty($this->primary) && !empty($data[$this->primary])){
			$name = "{$this->prefix}[{$data[$this->primary]}]";
			echo Core_DataList_Html::inputField('text', $name, $this->escape($value), $options);	
		}
	}
}
?>