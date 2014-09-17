<?php
class Core_Utils_String
{	
	public static function toUnUnicode($string) {
		$pattern = array("a" => "á|à|ạ|ả|ã|Á|À|Ạ|Ả|Ã|ă|ắ|ằ|ặ|ẳ|ẵ|Ă|Ắ|Ằ|Ặ|Ẳ|Ẵ|â|ấ|ầ|ậ|ẩ|ẫ|Â|Ấ|Ầ|Ậ|Ẩ|Ẫ", "o" => "ó|ò|ọ|ỏ|õ|Ó|Ò|Ọ|Ỏ|Õ|ô|ố|ồ|ộ|ổ|ỗ|Ô|Ố|Ồ|Ộ|Ổ|Ỗ|ơ|ớ|ờ|ợ|ở|ỡ|Ơ|Ớ|Ờ|Ợ|Ở|Ỡ", "e" =>
				"é|è|ẹ|ẻ|ẽ|É|È|Ẹ|Ẻ|Ẽ|ê|ế|ề|ệ|ể|ễ|Ê|Ế|Ề|Ệ|Ể|Ễ", "u" => "ú|ù|ụ|ủ|ũ|Ú|Ù|Ụ|Ủ|Ũ|ư|ứ|ừ|ự|ử|ữ|Ư|Ứ|Ừ|Ự|Ử|Ữ", "i" => "í|ì|ị|ỉ|ĩ|Í|Ì|Ị|Ỉ|Ĩ", "y" => "ý|ỳ|ỵ|ỷ|ỹ|Ý|Ỳ|Ỵ|Ỷ|Ỹ", "d" => "đ|Đ", "c" => "ç", );
		$i = 0;
		while ((list($key, $value) = each($pattern)) != null)
		{
			$i++;
			if($i>=5000) break;
			$string = preg_replace('/' . $value . '/i', $key, $string);
		}
		return $string;
	}
	public static function getSlug($string)
	{
		$seperator = '-';
		$allowANSIOnly = true;
		$pattern = array("a" => "á|à|ạ|ả|ã|Á|À|Ạ|Ả|Ã|ă|ắ|ằ|ặ|ẳ|ẵ|Ă|Ắ|Ằ|Ặ|Ẳ|Ẵ|â|ấ|ầ|ậ|ẩ|ẫ|Â|Ấ|Ầ|Ậ|Ẩ|Ẫ", "o" => "ó|ò|ọ|ỏ|õ|Ó|Ò|Ọ|Ỏ|Õ|ô|ố|ồ|ộ|ổ|ỗ|Ô|Ố|Ồ|Ộ|Ổ|Ỗ|ơ|ớ|ờ|ợ|ở|ỡ|Ơ|Ớ|Ờ|Ợ|Ở|Ỡ", "e" =>
				"é|è|ẹ|ẻ|ẽ|É|È|Ẹ|Ẻ|Ẽ|ê|ế|ề|ệ|ể|ễ|Ê|Ế|Ề|Ệ|Ể|Ễ", "u" => "ú|ù|ụ|ủ|ũ|Ú|Ù|Ụ|Ủ|Ũ|ư|ứ|ừ|ự|ử|ữ|Ư|Ứ|Ừ|Ự|Ử|Ữ", "i" => "í|ì|ị|ỉ|ĩ|Í|Ì|Ị|Ỉ|Ĩ", "y" => "ý|ỳ|ỵ|ỷ|ỹ|Ý|Ỳ|Ỵ|Ỷ|Ỹ", "d" => "đ|Đ", "c" => "ç", );
		while ((list($key, $value) = each($pattern)) != null)
		{
			$string = preg_replace('/' . $value . '/i', $key, $string);
		}
		if ($allowANSIOnly)
		{
			$string = strtolower($string);
			$string = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', $seperator, ''), $string);
		}
		return $string;
	}
	
	public static function getMatches($string,$words_list) {
		//$words_list = array('company', 'executive', 'files', 'resource');
		//$string = 'Executives are running the compa ny.';
		foreach ($words_list as &$word) $word = preg_quote($word, '/');
		return preg_match_all('/('.join('|', $words_list).')/i', $string, $matches);
	}
	public static function trim($str,$length = 50) {
		if(mb_strlen($str,'utf-8') <= $length)
			return $str;
		$str = mb_substr($str, 0, $length,'utf-8').'...';
		return $str;
	}
	public static function contains($string,$char) {
		if (strpos($string,$char) !== false) {
	    	return true;
		}
		return false;
	}
}