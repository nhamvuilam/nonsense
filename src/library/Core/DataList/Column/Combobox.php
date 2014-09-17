<?php
class Core_DataList_Column_Combobox extends Core_DataList_Column_Abstract
{
	public $name;

	public $value;
	
	public $linkOptions = array();
	
	public $primary;
	
	public $multioption;
	
	public $updateUrl;
	
	public $cbx;

	public function init(){
		parent::init();
		if($this->name===null)
			$this->sortable=false;
	}
	
	public function renderHeaderCellContent(){		
		$out = parent::renderHeaderCellContent();
				
		if($this->grid->dataProvider->getItemCount()>0 && !empty($this->primary) && !empty($this->updateUrl)){		
			$this->linkHtmlOptions['onChange'] = "jQuery.fn.DataList.post('{$this->grid->id}', {url: '{$this->updateUrl}',data: jQuery('#{$this->grid->id} input.text-area-order').serialize()});";
			$out .= Core_DataList_Html::link('', 'javascript:void(0);', $this->linkHtmlOptions);	
		}			
		return $out;
	}

	public function renderDataCellContent($row, $data){		
		if($this->value!==null)
			$value=$this->evaluateExpression($this->value, array('data'=>$data, 'row'=>$row));
		else if($this->name!==null)
			$value=$this->value($data, $this->name);
		
		$options = $this->linkOptions;		
						
		if(!empty($this->updateUrl)){		
			$options = "jQuery.fn.DataList.post('{$this->grid->id}', 
							{
								url: '{$this->updateUrl}',
								data: {
									'type':'status',
									'data':{$data[$this->primary]},
									'value':$('select#status option:selected').attr('value')
								}
							}
						);";
		}					
		$lable = '';
		$this->cbx = '';
		$this->cbx.='<select id="status" onChange="'.$options.'">';
		foreach($this->multioption as $key=>$value)
		{			
			$this->cbx.='<option value='.$key.'>'.$value.'</option>';			
		}
		$this->cbx.='</select>';
		echo $this->cbx;
		//echo Core_DataList_Html::inputField('select', $this->name, $this->escape($value), $options);	
	}
}