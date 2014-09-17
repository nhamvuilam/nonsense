<?php
class Core_DataList extends Core_DataList_Abstract
{
	public $columns=array();
	
	public $summaryText;
	
	public $summaryCssClass;
	
	public function init(){
		parent::init();
		$this->initColumns();
	}
	
	protected function initColumns(){		
		foreach($this->columns as $i=>$column){
			if(is_string($column))
				$column=$this->createColumn($column);
			else{
				if(!isset($column['class']))
					$column['class']='Text';
				$column=$this->createComponent($column, $this);
			}
			if(!$column->visible){
				unset($this->columns[$i]);
				continue;
			}			
			$this->columns[$i]=$column;
		}

		foreach($this->columns as $column)
			$column->init();
	}
	
	public function renderSummary()
	{
		$count = count($this->dataProvider->getData());
		
		if($this->enablePagination)
		{
			if($count == 0){
				echo "";
			}
			else {
				if(($summaryText=$this->summaryText)===null)
					$summaryText='Displaying {start}-{end} of {count} result(s).';
					
				$pagination=$this->dataProvider->getPagination();
				//$count=count($this->dataProvider->getData());
				$total=$pagination->getItemCount();			
				$start=($pagination->getCurrentPage()-1)*$pagination->getPageSize()+1;
				$end=$start+$count-1;
				
				if(empty($count)){
					$end=0;
					$start=0;	
				}
				else if($end>$total){
					$end=$total;
					$start=$end-$count+1;
				}
				echo strtr($summaryText,array(
					'{start}'=>$start,
					'{end}'=>$end,
					'{count}'=>$total,
					'{page}'=>$pagination->getCurrentPage()+1,
					'{pages}'=>$pagination->getPageCount(),
				));
			}
			
		}
		else{
			if(($summaryText=$this->summaryText)===null)
				$summaryText='Total {count} result(s).';
				
			echo strtr($summaryText,array(
				'{count}'=>$count,
				'{start}'=>1,
				'{end}'=>$count,
				'{page}'=>1,
				'{pages}'=>1,
			));
		}		
	}
	
	public function renderPager(){
		if(!$this->enablePagination)
			return;

		$pager=array();
		$class='Core_DataList_Pagination_LinkPager';
		if(is_string($this->pager))
			$class=$this->pager;
			
		else if(is_array($this->pager)){
			$pager=$this->pager;
			if(isset($pager['class'])){
				$class=$pager['class'];
				unset($pager['class']);
			}
		}
		
		$pager['pages']=$this->dataProvider->getPagination();		
		
		if(false !== $pager['pages']){
			if($pager['pages']->getPageCount()>1){
				$this->widget($class, $pager);			
			}
			else
				$this->widget($class, $pager);
		}		
	}
}
