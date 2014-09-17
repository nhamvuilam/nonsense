<?php
class Core_DataList_Column_Icon extends Core_DataList_Column_Abstract
{
	public $name;

	public $value;
	
	public $basicUrl;
	
	public $imageHtmlOptions;
	
	public $linkOptions = array();
	
	public $icon = array();
	
	public $primary;
	
	public $updateUrl;
	
	public $url;
	
	public $post;
	
	public function init(){
		parent::init();
		if($this->name===null)
			$this->sortable=false;
	}

	public function renderDataCellContent($row, $data){
		$options = $this->linkOptions;
		
		if($this->value!==null)
			$value=$this->evaluateExpression($this->value, array('data'=>$data, 'row'=>$row));
		else if($this->name!==null)
			$value=$this->value($data, $this->name);
			
		$value = (empty($this->icon[$value])?NULL:$this->icon[$value]);
		
		if(!empty($this->url)){
			$this->updateUrl = $this->evaluateExpression($this->url, array('data'=>$data, 'row'=>$row));	
		}
		
		if(!empty($data[$this->primary]) && !empty($this->updateUrl) && !empty($this->post)){					
			$options['onClick'] = "jQuery.fn.DataList.post('{$this->grid->id}', {url: '{$this->updateUrl}',data: {'type':'{$this->post}', 'data':{$data[$this->primary]}}});";
		}			
			
		echo $value===null ? $this->grid->blankDisplay : Core_DataList_Html::link(Core_DataList_Html::image($this->basicUrl.DIRECTORY_SEPARATOR.$value, NULL, $this->imageHtmlOptions), 'javascript:void(0);', $options);
	}
}
