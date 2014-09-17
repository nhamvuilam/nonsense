<?php
class Core_DataList_Sort
{	
	public $direction;
	
	public $attribute;
	
	public function getDirection(){		
		return (empty($this->direction) || !in_array($this->direction, array('desc', 'asc'))) ? 'desc' : $this->direction;
	}
	
	public function link($attribute, $label=null, $htmlOptions=array()){
		$linkOptions = array();
		$linkOptions['class'] = 'sort';		
		$linkOptions['href']  = 'javascript:void(0);';		
		$linkOptions['val']   = $attribute;
		$linkOptions['dir']   = 'desc';
				
		if($this->attribute === $attribute){			
			$linkOptions['class'] .= ' '.$this->getDirection();
			$linkOptions['dir']    = ($this->getDirection() === 'asc') ? 'desc' : 'asc';						
		}
		
		return Core_DataList_Html::tag('a', $linkOptions, $label);
	}
}