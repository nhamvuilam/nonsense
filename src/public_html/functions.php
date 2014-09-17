<?php
function hasValue($array,$element) {
	if(!isset($array[$element])) return false;
	if(empty($array[$element])) return false;
	return true;
}
function getValue($array,$element) {
	if(!isset($array[$element])) return '';
	return $array[$element];
}
function clean_data($data) {
	return htmlspecialchars($data);
}
function debug($data,$exit=true) {
    echo '<pre>';
    print_r($data);
    if($exit) {
        die;
    }
}