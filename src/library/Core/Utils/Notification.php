<?php
class Core_Utils_Notification
{	
	public static function addNotification($flag,$num=1) {
		$caching = Core_Global::getCaching();
		$name = Core_Utils_Tools::getCachePrefix().'notifications';
		if(($result = $caching->load($name)) == false) $result = array();
		if($num != 1) {
			$result[$flag] = $num;
		} else {
			$result[$flag] = isset($result[$flag])?($result[$flag] + 1):1;
		}
		$caching->save($result, $name);
	}
	
	public static function getNotification() {
		$caching = Core_Global::getCaching();
		$name = Core_Utils_Tools::getCachePrefix().'notifications';
		if(($result = $caching->load($name)) == false) $result = array();
		return $result;
	}
	
	public static function resetNotification() {
		$caching = Core_Global::getCaching();
		$name = Core_Utils_Tools::getCachePrefix().'notifications';
		$caching->remove($name);
	}
	
	public static function addAlertInfo($key,$data,$type='info') {
		try {
			$caching = Core_Global::getCaching();
			$name = Core_Utils_Tools::getCachePrefix().'alert_info';
			if(($array = $caching->load($name)) == false) {
				$array = array(
						'info' => array(),
						'warning' => array(),
						'error' => array(),
						'sms' => array()
				);
			}
			$date = date("Y-m-d	H:i:s");
			if($type == 'error' || $type == 'warning') {
				$str = '';
				if(is_array($data)) {
					foreach ($data as $index=>$item) {
						if($index == 0) {
							$e = $item;
						} else {
							if(is_array($item)) {
								$str.=json_encode($item).'  ';
							} else {
								$str.=$item.'  ';
							}
						}
					}
				} else {
					$e = $data;
				}
				$message = $e->getMessage();
				$code = $e->getCode();
				$file = $e->getFile();
				$line = $e->getLine();
				$trace = $e->getTraceAsString();
				$process_id = Core_PlusLog::getInstance()->getProcessId();
				$message = "<br>PID:{$process_id}<br>Code:{$code}<br>Message:{$message}{$str}<br>File:{$file}:{$line}<br>{$trace}";
			} else {
				if(is_array($data)) {
					$message = '';
					foreach ($data as $item) {
						if(is_object($item)) $item = (array)$item;
						if(is_array($item)) {
							$message.=json_encode($item).'  ';
						} else {
							$message.=$item.'  ';
						}
					}
				} else {
					$message = $data;
				}
			}
			$message = "{$date}  {$message}";
			$array[$type][$key][] = $message;
			$caching->save($array, $name);
		} catch (Exception $e) {
			Core_Log::error($e);
		}
	}
	
	public static function resetAlertInfo() {
		$caching = Core_Global::getCaching();
		$name = Core_Utils_Tools::getCachePrefix().'alert_info';
		$caching->remove($name);
	}
        
        /**
         * @param type $exc
         * @return boolean
         * @desc if return true, this exception will send SMS to admin else not send
         */
        public static function isNotifySMS($exc) {
            $key = '';
            $code = $exc->getCode();
            if($code != ERROR_CODE) {
                $key = ERROR_SYSTEM;
            } else {
                $importantErrors = array(
                    ERROR_CHECKOUT_CREATE_ORDER => ERROR_CHECKOUT_CREATE_ORDER,
                    ERROR_CHECKOUT_LOCKPLUS => ERROR_CHECKOUT_LOCKPLUS,
                    ERROR_CHECKOUT_CONSUMEPLUS => ERROR_CHECKOUT_CONSUMEPLUS,
                    ERROR_CHECKOUT_RELEASEPLUS => ERROR_CHECKOUT_RELEASEPLUS,
                    ERROR_CHECKOUT_PROFILE => ERROR_CHECKOUT_PROFILE,
                    ERROR_CHECKOUT_CREATESOPORDER => ERROR_CHECKOUT_CREATESOPORDER,
                    ERROR_SYSTEM_CHECKSUM => ERROR_SYSTEM_CHECKSUM,
                    ERROR_INVALID_PARAMS => ERROR_INVALID_PARAMS,
                    ERROR_CHECKOUT_ADDPOINT => ERROR_CHECKOUT_ADDPOINT,
                    ERROR_CHECKOUT_LOCKSMILESCARD => ERROR_CHECKOUT_LOCKSMILESCARD,
                    ERROR_CHECKOUT_CONSUMESMILESCARD => ERROR_CHECKOUT_CONSUMESMILESCARD,
                    ERROR_CHECKOUT_RELEASESMILESCARD => ERROR_CHECKOUT_RELEASESMILESCARD,
                    ERROR_CHECKOUT_GAMECODE => ERROR_CHECKOUT_GAMECODE,
                    ERROR_VALIDATE_GAME_DISCOUNT => ERROR_VALIDATE_GAME_DISCOUNT,
                    ERROR_CHECKOUT_GAME => ERROR_CHECKOUT_GAME,
                    //ERROR_PROFILE_OTP_LIMITED => ERROR_PROFILE_OTP_LIMITED,
                    ERROR_PROFILE_OTP_SPAM => ERROR_PROFILE_OTP_SPAM,
                    ERROR_PRODUCT_NOT_FOUND => ERROR_PRODUCT_NOT_FOUND,
                    ERROR_VALIDATE_POINT_DISCOUNT => ERROR_VALIDATE_POINT_DISCOUNT
                );
                if(isset($importantErrors[$exc->getMessage()])) {
                    $key = $importantErrors[$exc->getMessage()];
                }
            }
            if(!empty($key)) {
                Core_Utils_Notification::addAlertInfo($key, $exc, 'error');
                return true;
            }
            return false;
        }
}