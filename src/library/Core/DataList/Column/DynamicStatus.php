<?php
class Core_DataList_Column_DynamicStatus extends Core_DataList_Column_Status {
    public $statusMapping = array();

	public function renderDataCellContent($row, $data){
		if($this->value!==null)
			$value=$this->evaluateExpression($this->value, array('data'=>$data, 'row'=>$row));
		else if($this->name!==null)
			$value=$this->value($data, $this->name);

		$options = $this->linkOptions;

		if(empty($options['class'])){
			$options['class'] = 'jgrid';
		}else{
			$options['class'] .= ' jgrid';
		}

		if(!empty($this->url)){
			$this->updateUrl = $this->evaluateExpression($this->url, array('data'=>$data, 'row'=>$row));
		}

		if(!empty($data[$this->primary]) && !empty($this->updateUrl)){
			$options['onClick'] = "jQuery.fn.DataList.post('{$this->grid->id}', {url: '{$this->updateUrl}',data: {'type':'status', 'data':{$data[$this->primary]}}});";
		}

		$lable = '';
		if (!empty($this->statusMapping) && isset($this->statusMapping[$value])) {
		    $lable = '<span class="state ' . $this->statusMapping[$value] . '"></span>';
		} else {
    		if(1 == $value){
    			$lable = '<span class="state publish"></span>';
    		}else if(2 == $value){
    			$lable = '<span class="state trash"></span>';
    			unset($options['onClick']);
    		}else if(empty($value)){
    			$lable = '<span class="state unpublish"></span>';
    		}
		}

		if(!empty($lable))
			echo Core_DataList_Html::link($lable, 'javascript:void(0);', $options);
	}
}