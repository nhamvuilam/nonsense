<?php
class Core_Cache_Data
{	
	private $config;
	private $caching;
	/**
	 * Class constructor.
	 */
	public static function getInstance(){
		static $_instance = null;
		if(is_null($_instance)){
			$_instance = new self;		
			$_instance->init();	
		}
		return $_instance;
	}
	
	public function init(){
		$this->caching = Core_Global::getCaching();
	}
	
	//Master Data
	//-------------------Continent----------------------------
	public function runContinentAll(){
		$name = Core_Global::getKeyPrefixCaching('master_data_continent');
		$continent = Core_Api_Service::getInstance()->loadMasterData('CONTINENT','0');
		echo '<pre>';
		echo $name.'<br>';
		print_r($continent); exit;
		//$this->caching->save($continent,$name);
	}	
	public function runContinent(){
		$continent = Core_Api_Service::getInstance()->loadMasterData('CONTINENT','0');
		foreach($continent as $row){
			$name = Core_Global::getKeyPrefixCaching('master_data_continent_key').$row['continent_id'];
			echo '<Pre>';
			echo $name.'<br>';
			print_r($row);
		}
		exit;		
		//$this->caching->save($continent,$name);
	}
	//-----------------------------------------------------------
	
	//-------------------Country----------------------------
	public function runCountryAll(){
		$name = Core_Global::getKeyPrefixCaching('master_data_country');
		$country = Core_Api_Service::getInstance()->loadMasterData('COUNTRY','0');
		/*echo '<pre>';
		echo $name.'<br>';
		print_r($country);
		exit;*/
		$this->caching->save($country,$name);		
	}
	public function runCountryByContinent(){
		$continent = Core_Api_Service::getInstance()->loadMasterData('CONTINENT','0');
		foreach($continent as $row){
			$name = Core_Global::getKeyPrefixCaching('master_data_country_continent_key').$row['continent_id'];
			$country = Core_Api_Service::getInstance()->loadMasterData('COUNTRY',$row['continent_id']);
			echo '<pre>';
			echo $name.'<br>';
			print_r($country);
			//$this->caching->save($country,$name);	
		}
		exit;
	}	
	public function runCountry(){
		$country = Core_Api_Service::getInstance()->loadMasterData('COUNTRY','0');
		foreach($country as $row){
			$name = Core_Global::getKeyPrefixCaching('master_data_country_key').$row['country_id'];
			echo '<pre>';
			echo $name.'<br>';
			print_r($row);
			//$this->caching->save($row,$name);
		}
		exit;
	}
	//-----------------------------------------------------------
	
	//-------------------City----------------------------	
	/*public function runCityAll(){
		$city = Core_Api_Service::getInstance()->loadMasterData('CITY',0);
		$name = Core_Global::getKeyPrefixCaching('master_data_city');
		echo '<pre>';
		echo $name;
		print_r($city);
		//$this->caching->save($city,$name);
		exit;
	}*/
	public function runCityByCountry(){
		$country = Core_Api_Service::getInstance()->loadMasterData('COUNTRY',0);
		foreach($country as $row){
			$name = Core_Global::getKeyPrefixCaching('master_data_city_country_key').$row['country_id'];
			$city = Core_Api_Service::getInstance()->loadMasterData('CITY',$row['country_id']);
			/*echo '<pre>';
			echo $name.'<br>';
			print_r($city);	*/
			$this->caching->save($city,$name);		
		}
		exit;
	}
	public function runCity(){
		$city = Core_Api_Service::getInstance()->loadMasterData('CITY','0');
		foreach($city as $row){
			$name = Core_Global::getKeyPrefixCaching('master_data_city_key').$row['city_id'];
			echo '<pre>';
			echo $name.'<br>';
			print_r($row);
			//$this->caching->save($row,$name);
		}
		exit;
	}	
	//-----------------------------------------------------------	
	
	//-------------------Area----------------------------		
	/*public function runAreaAll(){
		$area = Core_Api_Service::getInstance()->loadMasterData('AREAS',0);
		$name = Core_Global::getKeyPrefixCaching('master_data_area');
		echo '<pre>';
		echo $name;
		print_r($area);
		//$this->caching->save($area,$name);
		exit;
	}*/
	public function runAreaByCity(){
		$city = Core_Api_Service::getInstance()->loadMasterData('CITY','0');
		$cnt = 0;
		foreach($city as $row){
			if($cnt == 10) break;
			$name = Core_Global::getKeyPrefixCaching('master_data_area_city_key').$row['city_id'];
			$area = Core_Api_Service::getInstance()->loadMasterData('AREAS',$row['city_id']);
			echo '<pre>';
			echo $name.'<br>';
			print_r($area);
			$cnt++;
			//$this->caching->save($row,$name);
		}
		exit;
	}
	public function runArea(){
		$area = Core_Api_Service::getInstance()->loadMasterData('AREAS','0');
		foreach($area as $row){
			$name = ore_Global::getKeyPrefixCaching('master_data_area_key').$row['area_id'];
			echo '<pre>';
			echo $name.'<br>';
			print_r($row);
			//$this->caching->save($row,$name);
		}
		exit;
	}
	
	public function runAttractivePlace(){
		$caching = Core_Global::getCaching();
		$attractive_place = Core_Api_Service::getInstance()->loadMasterData('ATTRACTIVE_PLACE','0');
		$name = Core_Global::getKeyPrefixCaching('master_data_attractiveplace');
		$caching->save($attractive_place,$name);
	}	
	
	public function runSeasonPlace(){
		$caching = Core_Global::getCaching();
		$season = '';
		if(date('m') <= 3)
			$season = 'SPRING';
		else if(date('m')>3 && date('m')<=6)
			$season = 'SUMMER';
		else if(date('m')>6 && date('m')<=9)
			$season = 'AUTUMN';
		else
			$season = 'WINTER';
		
		$season_place = Core_Api_Service::getInstance()->loadMasterData('SEASON_PLACE',$season);
		$name = Core_Global::getKeyPrefixCaching('master_data_seasonplace');		
		$caching->save($season_place,$name);
	}
	
	public function runAllHotel(){
		$caching = Core_Global::getCaching();
		$data = Core_Api_Service::getInstance()->getAllHotel();
		foreach($data as $row){
			$name = Core_Global::getKeyPrefixCaching('hotel_detail_key').$row['hotel_id'];
			$caching->save($row,$name);
		}
	}	
	//-----------------------------------------------------------		
}

















