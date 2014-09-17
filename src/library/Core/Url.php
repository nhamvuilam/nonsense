<?php
class Core_Url{
	
	public static function event($name, $id){
		return "/event/{$name}_{$id}.html"; 
	}
	
	public static function category($title, $id, $page=NULL){
		if(!empty($_COOKIE['123-shop-themes-vesion']) && in_array($_COOKIE['123-shop-themes-vesion'], array('v3'))){
			if($url = Model_Category::getInstance()->url($id)){				
				return "/{$url}-I{$id}/";	
			}
		}
		
		if(empty($page)){
			return "/danh-muc/{$title}_{$id}.html";
		}
		else{
			return "/danh-muc/{$title}_{$id}_{$page}.html";
		}			
	}
		
	public static function product($title, $id, $param = array(), $category_id=NULL){
		$base = "/{$title}_{$id}.html";
				
		if(!empty($_COOKIE['123-shop-themes-vesion']) && in_array($_COOKIE['123-shop-themes-vesion'], array('v3'))){
			if(!empty($category_id) && ($url = Model_Category::getInstance()->url($category_id))){
				$base = "/{$url}/{$title}-I{$id}.html";	
			}
		}
		
		if(!empty($param)){
			return sprintf('%s?%s', $base, preg_replace('/\%5B\d+\%5D/', '%5B%5D', http_build_query($param)));
		}
		
		return $base;
	}
	
	public static function brand($title, $category=NULL, $categoryId=NULL){
		if(!empty($_COOKIE['123-shop-themes-vesion']) && in_array($_COOKIE['123-shop-themes-vesion'], array('v3'))){
			return "/thuong-hieu/{$title}";	
		}
		
		if(empty($category) && empty($categoryId))
			return "/{$title}";
		else
			return "/{$title}/{$category}_{$categoryId}.html";	
	}
	
	public static function quickView($title, $id){
		return "/quick-view/{$title}_{$id}.html";
	}
	
	public static function quickViewPoint($title, $id){
		return "/quick-view-point/{$title}_{$id}.html";
	} 	
	
	public static function makeUrl($param=array()){		
		$current = array();		
		if($query = $_SERVER['QUERY_STRING']){
			parse_str($query, $current); 
		}
		
		$param = Core_Map::mergeArray($current, $param);
		
		if(preg_match("/^([^\?]+)/", $_SERVER['REQUEST_URI'], $match)){
			if($query = http_build_query($param)){
				$query = preg_replace('/\%5B\d+\%5D/', '%5B%5D', $query);
				return sprintf('%s?%s', $match[1], $query);
			}else 
				return $match[1];
		}
		
		return NULL;	
	}
	
	public static function source_book($name, $id,$type = 1){ 
	   $url = ''; 
       if($type == 1) $url = "/tac-gia/{$name}_{$id}.html";
       else if($type == 2) $url = "/nha-xuat-ban/{$name}_{$id}.html";
       else if($type == 3) $url = "/dich-gia/{$name}_{$id}.html";
	   else if($type == 4) $url = "/nha-phat-hanh/{$name}_{$id}.html";
       return $url;		
	}
    
	public static function category_book($name, $id){
		if(!empty($_COOKIE['123-shop-themes-vesion']) && in_array($_COOKIE['123-shop-themes-vesion'], array('v3'))){
			if($url = Model_Category::getInstance()->url($id)){
				return "/{$url}-I{$id}/";	
			}
		}
		
		return "/sach/{$name}_{$id}.html"; 
	}
	public static function quick_view_book($name, $id){
		return "/quick-view-book/{$name}_{$id}.html"; 
	}	
}
?>