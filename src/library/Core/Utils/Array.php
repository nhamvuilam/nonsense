<?php
class Core_Utils_Array
{
	public static function in_array_field($needle, $needle_field, $haystack, $stdClass = false) {
		$isArray = false;
		if(is_array($needle)) {
			$isArray = true;
		}
	    if ($stdClass) {
	        foreach ($haystack as $item)
	            if (isset($item->$needle_field)) {
	            	if($isArray) {
	            		if(in_array($item->$needle_field, $needle))
	            			return $item;
	            	} else {
	            		if($item->$needle_field == $needle)
	            			return $item;
	            	}
	            }
	                
	    }
	    else {
	        foreach ($haystack as $item)
	            if (isset($item[$needle_field])) {
	            	if($isArray) {
	            		if(in_array($item[$needle_field], $needle))
	            			return $item;
	            	} else {
	            		if($item[$needle_field] == $needle)
	            			return $item;
	            	}
	            }
	    }
	    return null;
	}
	public static function array_trim(&$arr,$len_trim) {
		$len = count($arr);
		while($len>$len_trim) {
			unset($arr[$len-1]);
			$len --;
		}
	}
	private static function cmp($a,$b) {
		$field = Zend_Registry::get('field');
		$stdClass = Zend_Registry::get('stdClass');
		$order = Zend_Registry::get('order');
		if($stdClass) {
			if(  $a->$field ==  $b->$field ){ return 0 ; } 
			if($order == 'asc')
  				return ($a->$field < $b->$field) ? -1 : 1;
  			else
  				return ($a->$field > $b->$field) ? -1 : 1;
		} else {
			if(  $a[$field] ==  $b[$field] ){ return 0 ; } 
			if($order == 'asc')
  				return ($a[$field] < $b[$field]) ? -1 : 1;
  			else 
  				return ($a[$field] > $b[$field]) ? -1 : 1;
		}
	}
	
	public static function sort(&$array,$field,$order = 'asc',$stdClass = false) {
		Zend_Registry::set('field', $field);
		Zend_Registry::set('stdClass', $stdClass);
		Zend_Registry::set('order', $order);
		usort($array, 'Core_Utils_Array::cmp');
	}
	public static function findMax($array) {
		$result = array();
		foreach($array as $key => $value) {
			
		}
		$len = count($array);
		$i = 0;
		for ($i = 0; $i < $len ;$i ++) {
			for ($j = $i + 1;$j < $len; $j ++) {
				if(($array[$i] > $array[$j]) == $desc) {
					$tmp = $array[$i];
					$array[$i] = $array[$j];
					$array[$j] = $tmp;
				}
			}
		}
		return $array;
	}
	public static function childs($parent,$keys, $stdClass = false) {
		$array = array();
		foreach($keys as $key) {
			if($stdClass==true)
				$array[$key] = $parent->$key;
			else 
				$array[$key] = $parent[$key];
		}
		return $array;
	}
	public static function array_merge($array1,$array2) {
		foreach ($array2 as $key=>$value)
			$array1[$key] = $value;
		return $array1;
	}
	public static function array_result($data,$type) {
		return array(
			'rs' => $type==1?'OK':'ERROR',
			'data' => $data
		);
	}
	public static function arrayToObject($array) {
		return json_decode(json_encode($array), FALSE);
	}
	public static function objectToArray($object) {
		return (array)$object;
	}
	public static function removeKeys($array) {
		$result = array();
		foreach($array as $data) $result[] = $data;
		return $result;
	}
	
}
?>