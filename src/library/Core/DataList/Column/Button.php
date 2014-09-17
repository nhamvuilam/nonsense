<?php
class Core_DataList_Column_Button extends Core_DataList_Column_Abstract
{
	public $template='{view} {update} {delete}';

	public $viewButtonLabel;

	public $viewButtonImageUrl;

	public $viewButtonUrl;

	public $viewButtonOptions=array('class'=>'view');

	public $updateButtonLabel;

	public $updateButtonImageUrl;

	public $updateButtonUrl;

	public $updateButtonOptions=array('class'=>'update');

	public $deleteButtonLabel;

	public $deleteButtonImageUrl;

	public $deleteButtonUrl;

	public $deleteButtonOptions=array('class'=>'delete');

	public $deleteConfirmation;

	public $afterDelete;

	public $buttons=array();	
	
	public function init(){
		parent::init();		
		$this->sortable=false;
		
		$this->initDefaultButtons();
		
		foreach($this->buttons as $id=>$button)
		{
			if(strpos($this->template,'{'.$id.'}')===false)
				unset($this->buttons[$id]);
			else if(isset($button['click']))
			{
				if(!isset($button['options']['class']))
					$this->buttons[$id]['options']['class']=$id;
				if(strpos($button['click'],'js:')!==0)
					$this->buttons[$id]['click']='js:'.$button['click'];
			}
		}

		
		$this->registerClientScript();
	}
	
	protected function initDefaultButtons()
	{
		if($this->viewButtonLabel===null)
			$this->viewButtonLabel='View';
		if($this->updateButtonLabel===null)
			$this->updateButtonLabel='Update';
		if($this->deleteButtonLabel===null)
			$this->deleteButtonLabel='Delete';
		if($this->viewButtonImageUrl===null)
			$this->viewButtonImageUrl=$this->grid->baseUrl.'/images/view.png';
		if($this->updateButtonImageUrl===null)
			$this->updateButtonImageUrl=$this->grid->baseUrl.'/images/update.png';
		if($this->deleteButtonImageUrl===null)
			$this->deleteButtonImageUrl=$this->grid->baseUrl.'/images/delete.png';
		if($this->deleteConfirmation===null)
			$this->deleteConfirmation='Are you sure you want to delete this item?';

		foreach(array('view','update','delete') as $id){
			$button=array(
				'label'=>$this->{$id.'ButtonLabel'},
				'url'=>$this->{$id.'ButtonUrl'},
				'imageUrl'=>$this->{$id.'ButtonImageUrl'},
				'options'=>$this->{$id.'ButtonOptions'},
			);
			if(isset($this->buttons[$id]))
				$this->buttons[$id]=array_merge($button,$this->buttons[$id]);
			else
				$this->buttons[$id]=$button;
		}

		if(!isset($this->buttons['delete']['click']))
		{
			if(is_string($this->deleteConfirmation))
				$confirmation="if(!confirm(".Core_DataList_JavaScript::encode($this->deleteConfirmation).")) return false;";
			else
				$confirmation='';			

			if($this->afterDelete===null)
				$this->afterDelete='function(){}';

			$this->buttons['delete']['click']=<<<EOD
function() {
	$confirmation
	var th=this;
	var afterDelete=$this->afterDelete;
	$.fn.DataList.update('{$this->grid->id}', {
		type:'POST',
		url:$(this).attr('href'),
		success:function(data) {
			$.fn.DataList.update('{$this->grid->id}');
			afterDelete(th,true,data);
		},
		error:function(XHR) {
			return afterDelete(th,false,XHR);
		}
	});
	return false;
}
EOD;
		}
	}
	
	protected function registerClientScript()
	{
		$js=array();
		foreach($this->buttons as $id=>$button)
		{
			if(isset($button['click']))
			{
				$function=Core_DataList_JavaScript::encode($button['click']);
				$class=preg_replace('/\s+/','.',$button['options']['class']);
				$js[]="jQuery('#{$this->grid->id} a.{$class}').live('click',$function);";
				
				unset($button['click']);
			}			
		}

		if($js!==array()){
			$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
			$viewRenderer->view->headScript()->appendScript("
				jQuery(document).ready(function(){
					".implode("\n",$js)."
				});"
			);
		}		
	}

	public function renderDataCellContent($row, $data){
		$tr=array();
		ob_start();
		foreach($this->buttons as $id=>$button)
		{
			$this->renderButton($id,$button,$row,$data);
			$tr['{'.$id.'}']=ob_get_contents();
			ob_clean();
		}
		ob_end_clean();
		echo strtr($this->template,$tr);
	}
	
	protected function renderButton($id,$button,$row,$data)
	{
		if (isset($button['visible']) && !$this->evaluateExpression($button['visible'],array('row'=>$row,'data'=>$data)))
  			return;
		$label=isset($button['label']) ? $button['label'] : $id;
		$url=isset($button['url']) ? $this->evaluateExpression($button['url'],array('data'=>$data,'row'=>$row)) : 'javascript:void(0);';
		$options=isset($button['options']) ? $button['options'] : array();
		if(!isset($options['title']))
			$options['title']=$label;
		if(isset($button['imageUrl']) && is_string($button['imageUrl']))
			echo Core_DataList_Html::link(Core_DataList_Html::image($button['imageUrl'],$label),$url,$options);
		else
			echo Core_DataList_Html::link($label,$url,$options);
	}
}
