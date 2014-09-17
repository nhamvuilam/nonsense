<?php

class Core_Utils_Date {
    public static $formatSQLDateTime = 'y-MM-dd HH:mm:ss';
    public static $formatSQLDate = 'y-MM-dd';

    public static function getCurrentDateSQL() {
        return date('Y-m-d H:i:s');
    }

    public static function convertUnixToSqlDate($unixtime, $format = 'y-MM-dd HH:mm:ss') {
        if (empty($unixtime) || is_numeric($unixtime) == false)
            return '';
        $date = new Zend_Date($unixtime);
        return $date->toString($format);
    }

    public static function displaySQLDate($sDate, $toFormat = 'dd/MM/y HH:mm:ss') {
        $date = new Zend_Date($sDate, 'y-MM-dd HH:mm:ss');
        return $date->toString($toFormat);
    }

    /**
     * parseDateFormat1
     * @param String Date Format (/Date(-2209014000000)/)
     * @return json
     */
    public static function parseDateFormat1($s_date) {
        $num = Core_Utils_Number::parseNumber($s_date);
        if ($num <= 0)
            return null;
        return Core_Utils_Date::convertUnixToSqlDate($num / 1000);
    }
    
    public static function convertToSQLDate($sDate, $format = 'dd/MM/y HH:mm:ss') {
        if(empty($sDate)) {
            return '';
        }
        $date = new Zend_Date($sDate, $format);
        return $date->toString('y-MM-dd HH:mm:ss');
    }
    
    public static function displayDate($sDate, $format = 'dd/MM/y',$formatDisplay='dd/MM/y') {
        if(empty($sDate)) {
            $date = new Zend_Date('01/01/1990','dd/MM/y');
        } else {
            $date = new Zend_Date($sDate, $format);
            if($date->toString('y') < 1900) {
                $date = new Zend_Date('01/01/1990','dd/MM/y');
            }
        }
        return $date->toString($formatDisplay);
    }
    
    public static function getDate($date,$format = 'dd/MM/y') {
        if (strlen($date) < 7) {
            return false;
        }
        if(Zend_Date::isDate($date, $format) == false) {
            return false;
        }
        $date = new Zend_Date($date, $format);
        if($date->get('y') >= 1900 && $date->get('y') <= 2014) {
            return $date->toString('dd/MM/y');
        } else {
            return false;
        }
    }

}
