<?php
class Core_DataList_Provider
{		
	private $data;
	
	public $sort;
	
	public $pagination;
	
	public function __construct($data, $config=array()){
		$this->data=$data;
		
		foreach($config as $key=>$value)
			$this->$key=$value;
	}
	
	public function getItemCount(){		
		if($this->getPagination()!==false){
			return $this->getPagination()->getItemCount();			
		}
		return count($this->data);
	}
	
	public function getData(){		
		return $this->data;	
	}
	
	public function getPagination(){
		if($this->pagination===null){
			$this->pagination=new Core_DataList_Pagination();
		}else if(is_array($this->pagination)){
			$value = $this->pagination;			
			$this->pagination=new Core_DataList_Pagination();
			
			foreach($value as $k=>$v)
				$this->pagination->$k=$v;	
		}
		return $this->pagination;
	}
	
	public function getSort(){
		if($this->sort===null){
			$this->sort=new Core_DataList_Sort();
		}else if(is_array($this->sort)){
			$value = $this->sort;			
			$this->sort=new Core_DataList_Sort();
			
			foreach($value as $k=>$v)
				$this->sort->$k=$v;	
		}
		return $this->sort;
	}
}