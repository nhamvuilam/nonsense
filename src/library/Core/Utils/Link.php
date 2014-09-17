<?php
class Core_Utils_Link
{	
	public static function getFullURL() {
		return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	}
	public static function genProductUrl($product) {
		if($product['line_id'] == CAT_THECAODIENTHOAI) {
			return '/card/'.$product['url'].'_'.$product['product_id'].'.html';
		} else {
			return '/product/'.$product['url'].'_'.$product['product_id'].'.html';
		}
	}
	public static function genProductCardUrl($product) {
		return '/card/'.$product['url'].'_'.$product['product_id'].'.html';
	}
	
	public static function getURI() {
		return isset($_SERVER["REQUEST_URI"])?$_SERVER["REQUEST_URI"]:'';
	}
        public static function getRefererURL() {
            return isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
	}
}