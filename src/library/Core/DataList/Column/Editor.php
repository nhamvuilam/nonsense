<?php
class Core_DataList_Column_Editor extends Core_DataList_Column_Abstract
{
	public $name;

	public $value;	
	
	public $alt;
	
	public $site;
	
	public $thumb;

	public $imageHtmlOptions=array('width'=>32, 'height'=>32);
	
	public $linkHtmlOptions=array('class'=>'fancybox');
	
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
			
		$this->linkHtmlOptions['onClick'] = 'CKEditorReturn(this.href);return false;';
			
		echo $value===null ? $this->grid->blankDisplay : Core_DataList_Html::link(
																					Core_DataList_Html::image(Core_Image::path($value, $this->site, $this->thumb), $this->alt, $this->imageHtmlOptions), 
																					Core_Image::path($value, $this->site), $this->linkHtmlOptions);
	}
}
?>