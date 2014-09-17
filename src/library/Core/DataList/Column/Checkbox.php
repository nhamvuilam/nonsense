<?php
class Core_DataList_Column_Checkbox extends Core_DataList_Column_Abstract
{
	public $name;

	public $value;
	
	public $checked;
	
	public $checkBoxHtmlOptions=array();

	public function init(){
		parent::init();
		$this->registerClientScript();				
	}

	
	public function renderHeaderCellContent(){
		echo Core_DataList_Html::checkBox("{$this->grid->id}_all", false);
	}	
	
	public function renderDataCellContent($row, $data){
		if($this->value!==null)
			$value=$this->evaluateExpression($this->value, array('data'=>$data, 'row'=>$row));
		else if($this->name!==null)
			$value=$this->value($data, $this->name);
		
		$checked = false;
		if($this->checked!==null)
			$checked=$this->evaluateExpression($this->checked,array('data'=>$data,'row'=>$row));

		$options=$this->checkBoxHtmlOptions;
		$name=$options['name'];
		unset($options['name']);
		$options['value']=($value===null) ? $this->grid->blankDisplay : $this->escape($value);
		$options['id']=$this->grid->id.'_checkbox_'.$row;
		
		echo Core_DataList_Html::checkBox($name, $checked, $options);		
	}
	
	public function registerClientScript(){		
		if($this->grid->id){
			if(isset($this->checkBoxHtmlOptions['name']))
				$name=$this->checkBoxHtmlOptions['name'];
			else
			{
				$name=$this->grid->id;
				if(substr($name,-2)!=='[]')
					$name.='[]';
				$this->checkBoxHtmlOptions['name']=$name;
			}
			$name=strtr($name,array('['=>"\\[",']'=>"\\]"));
		
			$cball=<<<CBALL
$('#{$this->grid->id}_all').live('click',function(){
	var checked=this.checked;
	$("input[name='$name']").each(function() {this.checked=checked;});
});

CBALL;
			$cbcode="$('#{$this->grid->id}_all').attr('checked', $(\"input[name='$name']\").length==$(\"input[name='$name']:checked\").length);";

			$js=$cball;
			$js.=<<<EOD
$("input[name='$name']").live('click', function() {
	$cbcode
});
EOD;
			$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
			$viewRenderer->view->headScript()->appendScript("
				jQuery(document).ready(function(){
					$js
				});"
			);
		}
	}
}
?>