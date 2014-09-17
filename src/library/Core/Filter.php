<?php
class Core_Filter{
			
	public $data = array();
	
    public static function getInstance(){
		static $_instance = null;	
        if(empty($_instance)){			
            $_instance = new self;
        }
        return $_instance;
    }
	
	public function load(){
		//$this->data = Model_SearchHotel::getInstance()->dataFilter($params);		
		return $this;
	}
	
	public function find($params){
		return Model_SearchHotel::getInstance()->dataFilter($params);		
	}
	
	public function findDataInSolr($dataFilter){
		return $dataFilter;
	}
}
?>