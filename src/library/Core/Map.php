<?php

class Core_Map {

    public static function mergeArray($a, $b) {
        if (!empty($b)) {
            foreach ($b as $k => $v) {
                if (is_integer($k))
                    isset($a[$k]) ? $a[] = $v : $a[$k] = $v;
                else if (is_array($v) && isset($a[$k]) && is_array($a[$k]))
                    $a[$k] = self::mergeArray($a[$k], $v);
                else
                    $a[$k] = $v;
            }
        }
        return $a;
    }

    public static function in_array($needle, $haystack) {
        if (is_array($needle)) {
            foreach ($needle as $v) {
                if (in_array($v, $haystack))
                    return true;
            }
        }else {
            return in_array($needle, $haystack);
        }
        return false;
    }

    public static function parseIni($string) {
        $group = NULL;
        $array = array();
        $lines = preg_split("[\n]", $string);

        foreach ($lines as $line) {
            $statement = preg_match("/^(?!;)(?P<key>[^\=]+?)\s*=\s*(?P<value>.+?)\s*$/", $line, $match);
            if ($statement) {
                $key = $match['key'];
                $value = $match['value'];

                if (preg_match("/^\".*\"$/", $value) || preg_match("/^'.*'$/", $value)) {
                    $value = mb_substr($value, 1, mb_strlen($value) - 2);
                }

                if (!empty($group))
                    $array[$group][$key] = $value;
                else
                    $array[$key] = $value;
            }else if (preg_match("/^\[\s*(\w+)\s*\]\s*$/", $line, $match)) {
                $group = $match[1];
            }
        }
        return $array;
    }

    public static function removeAccents($string, $bank = '-') {
        $trans = array('à' => 'a', 'á' => 'a', 'ả' => 'a', 'ã' => 'a', 'ạ' => 'a',
            'ă' => 'a', 'ằ' => 'a', 'ắ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a', 'ặ' => 'a',
            'â' => 'a', 'ầ' => 'a', 'ấ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a', 'ậ' => 'a',
            'À' => 'a', 'Á' => 'a', 'Ả' => 'a', 'Ã' => 'a', 'Ạ' => 'a',
            'Ă' => 'a', 'Ằ' => 'a', 'Ắ' => 'a', 'Ẳ' => 'a', 'Ẵ' => 'a', 'Ặ' => 'a',
            'Â' => 'a', 'Ầ' => 'a', 'Ấ' => 'a', 'Ẩ' => 'a', 'Ẫ' => 'a', 'Ậ' => 'a',
            'đ' => 'd', 'Đ' => 'd',
            'è' => 'e', 'é' => 'e', 'ẻ' => 'e', 'ẽ' => 'e', 'ẹ' => 'e',
            'ê' => 'e', 'ề' => 'e', 'ế' => 'e', 'ể' => 'e', 'ễ' => 'e', 'ệ' => 'e',
            'È' => 'e', 'É' => 'e', 'Ẻ' => 'e', 'Ẽ' => 'e', 'Ẹ' => 'e',
            'Ê' => 'e', 'Ề' => 'e', 'Ế' => 'e', 'Ể' => 'e', 'Ễ' => 'e', 'Ệ' => 'e',
            'ì' => 'i', 'í' => 'i', 'ỉ' => 'i', 'ĩ' => 'i', 'ị' => 'i',
            'Ì' => 'i', 'Í' => 'i', 'Ỉ' => 'i', 'Ĩ' => 'i', 'Ị' => 'i',
            'ò' => 'o', 'ó' => 'o', 'ỏ' => 'o', 'õ' => 'o', 'ọ' => 'o',
            'ô' => 'o', 'ồ' => 'o', 'ố' => 'o', 'ổ' => 'o', 'ỗ' => 'o', 'ộ' => 'o',
            'ơ' => 'o', 'ờ' => 'o', 'ớ' => 'o', 'ở' => 'o', 'ỡ' => 'o', 'ợ' => 'o',
            'Ò' => 'o', 'Ó' => 'o', 'Ỏ' => 'o', 'Õ' => 'o', 'Ọ' => 'o',
            'Ô' => 'o', 'Ồ' => 'o', 'Ố' => 'o', 'Ổ' => 'o', 'Ỗ' => 'o', 'Ộ' => 'o',
            'Ơ' => 'o', 'Ờ' => 'o', 'Ớ' => 'o', 'Ở' => 'o', 'Ỡ' => 'o', 'Ợ' => 'o',
            'ù' => 'u', 'ú' => 'u', 'ủ' => 'u', 'ũ' => 'u', 'ụ' => 'u',
            'ư' => 'u', 'ừ' => 'u', 'ứ' => 'u', 'ử' => 'u', 'ữ' => 'u', 'ự' => 'u',
            'Ù' => 'u', 'Ú' => 'u', 'Ủ' => 'u', 'Ũ' => 'u', 'Ụ' => 'u',
            'Ư' => 'u', 'Ừ' => 'u', 'Ứ' => 'u', 'Ử' => 'u', 'Ữ' => 'u', 'Ự' => 'u',
            'ỳ' => 'y', 'ý' => 'y', 'ỷ' => 'y', 'ỹ' => 'y', 'ỵ' => 'y',
            'Y' => 'y', 'Ỳ' => 'y', 'Ý' => 'y', 'Ỷ' => 'y', 'Ỹ' => 'y', 'Ỵ' => 'y', ' ' => $bank, '/' => $bank, '.' => $bank, '\'' => '');
        return strtr($string, $trans);
    }

    public static function formatString($string) {
        return preg_replace('/[\-]{2,}/i', '-', trim(preg_replace('/[^a-z0-9\-]/i', '', strtolower(Core_Map::removeAccents($string, '-'))), '-'));
    }

    public static function getIp() {
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        if (isset($_SERVER["HTTP_X_FORWARDED"])) {
            return $_SERVER["HTTP_X_FORWARDED"];
        }
        if (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }
        if (isset($_SERVER["HTTP_FORWARDED"])) {
            return $_SERVER["HTTP_FORWARDED"];
        }
        return $_SERVER["REMOTE_ADDR"];
    }

    public static function listData($array, $key, $value) {
        $result = array();
        foreach ($array as $k => $row) {
            if (isset($array[$k][$key]) && isset($array[$k][$value])) {
                $result[$row[$key]] = $row[$value];
            }
        }
        return $result;
    }

    public static function checkRequire($array_1, $array_2, $data) {
        //array_1: array mother
        //array_2: array son
        foreach ($array_2 as $row) {
            if (!in_array($row, $array_1) || (in_array($row, $array_1) && empty($data[$row]))) {
                return false;
            }
        }
        return true;
    }

    public function redirect($url = NULL) {
        $_redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
        $_redirector->gotoUrl($url);
    }

    public static function getParam($id) {
        return Zend_Controller_Front::getInstance()->getRequest()->getParam($id);
    }

    public static function getQuery() {
        return Zend_Controller_Front::getInstance()->getRequest()->getQuery();
    }

    public static function truncate($text = '', $length = 100, $suffix = '...', $encode = 'UTF-8') {
        if (mb_strlen($text, $encode) > $length) {
            $last = mb_strrpos(mb_substr($text, 0, $length, $encode), ' ', 0, $encode);
            $output = mb_substr($text, 0, empty($last) ? $length : $last, $encode) . $suffix;
            return $output;
        }
        return $text;
    }

    public static function debug($data, $exit = true) {
        if (isset($_GET['print']) && $_GET['print'] == 1) {
            echo '<Pre>';
            echo 'debuging....<br>';
            print_r($data);
            if ($exit)
                exit;
        }
    }
    
    /*
     * input date: dd/mm/yy
     */
    public static function checkValidDate($string = NULL){
        $exp = explode('/', $string);
        if($exp && isset($exp[0]) && !empty($exp[0]) && isset($exp[1]) && !empty($exp[1]) 
           && isset($exp[2]) && !empty($exp[2]) && checkdate($exp[1], $exp[0],$exp[2])
           && $string >= date('d/m/Y')
           ){
             return true;
         }
         return false;
    }
    
    public static function formatNumber($number = NULL, $decimals = 0, $dec_point = '.', $thousands_sep = ','){        
        if(!empty($number)){
            return number_format($number, $decimals, $dec_point, $thousands_sep);
        }else if($number === 0){
            return 0;
        }
        return NULL;
    }
    
    /*Convert date to type
     * Input: date: d/m/Y, type default: Y-m-d
     */
    public static function formatDate($date = NULL, $type = 'Y-m-d'){
        if(!empty($date))
            return date($type, strtotime(preg_replace('/\//', '-', $date)));
        return NULL;
    }
    
    public static function formatTime($time = NULL){
        if(!empty($time)){
            return substr_replace($time,":",2,0);
        }
        return NULL;
    }

}

?>