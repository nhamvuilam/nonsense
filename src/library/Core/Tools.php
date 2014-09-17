<?php
class Core_Tools
{
	public static function getCardType($ccNum) {
		if (preg_match("/^5[1-5][0-9]{14}$/", $ccNum))
			return "002";
		
		if (preg_match("/^4[0-9]{12}([0-9]{3})?$/", $ccNum))
			return "001";
		/* if (ereg("^3[47][0-9]{13}$", $ccNum))
			return "American Express";
		
		if (ereg("^3(0[0-5]|[68][0-9])[0-9]{11}$", $ccNum))
			return "Diners Club";
		
		if (ereg("^6011[0-9]{12}$", $ccNum))
			return "Discover";
		 */
		if (preg_match("/^(3[0-9]{4}|2131|1800)[0-9]{11}$/", $ccNum))
			return "007";
		return '';
	}
	public static function getUri() {
		return isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'';
	}
	
	public static function genSecureKey($len = 10) {
		$key = '';
		list($usec, $sec) = explode(' ', microtime());
		mt_srand((float) $sec + ((float) $usec * 100000));
		$inputs = array_merge(range('z', 'a'), range(0, 9), range('A', 'Z'));
		for ($i = 0; $i < $len; $i++) {
			$key .= $inputs{mt_rand(0, 61)};
		}
		return $key;
	}
	
	public static function getCachePrefix() {
		return '123pay_cybersource_cache_';
	}
	
	public static function writeCache($data,$id) {
		$caching = Core_Global::getCaching();
		$key = Core_Tools::getCachePrefix().$id;
		$caching->save($data, $key);
	}
	
	public static function hideCardNum($cardNumber) {
		//if(APPLICATION_ENV != 'production' && APPLICATION_ENV != 'staging') return $cardNumber;
                $prefix = substr($cardNumber, 0, 6);
                $suffix = substr($cardNumber, -4);
		return $prefix.'xxxxxx'.$suffix;
	}
	public static function hideCardCVV($cardCVV) {
		if(APPLICATION_ENV != 'production' && APPLICATION_ENV != 'staging') return $cardCVV;
		if(strlen($cardCVV) < 3) return 'xx';
		return substr($cardCVV, 0, -2) . 'xx';
	}
	public static function isDev() {
		if(APPLICATION_ENV == 'production') return false;
		return true;
	}
	public static function getMerchantInfo($merchantCode) {
		$caching = Core_Global::getCaching();
		if(defined('CACHING_PREFIX')) {
			$caching_prefix = CACHING_PREFIX;
		} else {
			$caching_prefix = Core_Tools::getCachePrefix();
		}
		$key = $caching_prefix.'partners_'.$merchantCode;
		if(($result = $caching->load($key)) === false) {
			$db = Core_Global::getDb123Pay();
			$sql = 'select icon, image, urlpartner, merchant_code,`title` from partners where merchant_code = ? AND isactived =1';
			$stmt = $db->prepare($sql);
			$stmt->execute(array($merchantCode));
			$row = $stmt->fetch();
			$stmt->closeCursor();
			$db->closeConnection();
			$result = ($row == false)?null:$row;
			if($result != null) {
				$caching->save($result, $key,array(),3600);
			}
		}
		if($result != null) {
			return array(
					'logo' => empty($result['image'])?DEFAULT_LOGO:'https://img.123pay.vn/img123pay/images/merchant/'.$result['image'],
					'website' => $result['urlpartner'],
					'title' => $result['title']
			);
		}
		return array(
				'logo' => DEFAULT_LOGO,
				'website' => '',
				'title' => ''
		);
	}
	public static function getErrorMessageByCode($error_code) {
		switch ($error_code) {
			case 0:
				return 'Phát sinh lỗi từ hệ thống';
				break;
			case -1:
				return 'Thông tin về thẻ không hợp lệ. Vui lòng nhập lại hoặc liên hệ với ngân hàng của quý khách biết thêm thông tin thẻ';
				break;
			case -2:
				return 'Khách hàng không nhập OTP hoặc thông tin OTP không đúng';
				break;
			case -3:
				return 'Nhập sai OTP quá 3 lần';
				break;
			case -4:
				return 'Nhập sai thông tin thẻ quá 3 lần';
				break;
			case -5:
				return 'Xác thực thẻ không thành công';
				break;
			case -6:
				return 'Thẻ đã vượt quá giới hạn thanh toán trong vòng 30 ngày gần nhất';
				break;
			case -7:
				return 'Tài khoản đã vượt quá giới hạn thanh toán trong vòng 30 ngày gần nhất';
				break;
			case -8:
				return 'Thẻ đã vượt quá giới hạn giao dịch theo quy định của 123Pay';
				break;
			case -9:
				return 'Thông tin thanh toán không hợp lệ';
				break;
			case -10:
				return 'Không đủ tiền trong tài khoản thanh toán';
				break;
			case -11:
				return 'Không đảm bảo số dư tối thiểu trong tài khoản thanh toán';
				break;
			case -12:
				return 'Thẻ đã vượt giới hạn số tiền thanh toán trên ngày';
				break;
			case -13:
				return 'Thẻ đã vượt giới hạn số giao dịch trên ngày';
				break;
			case -14:
				return 'Giá trị thanh toán vượt quá giới hạn cho phép';
				break;
			case -15:
				return 'Khách hàng đã hủy giao dịch';
				break;
			case -16:
				return 'Khách hàng không nhập thông tin thanh toán';
				break;
			case -17:
				return 'Thẻ chưa đăng ký dịch vụ thanh toán trực tuyến';
				break;
			case -18:
				return 'Dịch vụ thanh toán trực tuyến của tài khoản đang tạm khóa';
				break;
			case -19:
				return 'Tài khoản thanh toán đang bị khóa';
				break;
			case -20:
				return 'Thẻ có vấn đề nên ngân hàng từ chối thanh toán.Vui lòng liên hệ với ngân hàng để biết thêm thông tin';
				break;
			case -21:
				return 'Sai tên chủ thẻ';
				break;
			case -22:
				return 'Thẻ không hợp lệ';
				break;
			case -23:
				return 'Sai ngày phát hành thẻ';
				break;
			case -24:
				return 'Sai ngày hết hạn';
				break;
			case -25:
				return 'Card did not pass all risk checks';
				break;
			case -26:
				return 'Ngân hàng từ chối thanh toán';
				break;
			case -27:
				return 'Tài khoản thanh toán không hợp lệ';
				break;
			case -28:
				return 'Cardholder is not enrolled in Authentication Scheme';
				break;
			case -29:
				return 'Giao dịch đã bị hủy';
				break;
			case -30:
				return 'Thẻ đang bị hạn chế sử dụng';
				break;
			case -31:
				return 'Giao dịch hết thời hạn thực hiện';
				break;
			case -32:
				return 'Thẻ không được 123Pay hỗ trợ thanh toán';
				break;
			case -33:
				return 'Thẻ của quý khách đã hết thời hạn thanh toán. Vui lòng liên hệ ngân hàng của quý khách';
				break;
			case -34:
				return 'Ngân hàng từ chối giao dịch. Giao dịch không thành công. Vui lòng thực hiện giao dịch mới';
				break;
			case -35:
				return 'Tài khoản quý khách không đủ tiền để thực hiện giao dịch. Vui lòng kiểm tra lại tài khoản (chú ý số dư tối thiểu theo quy định của ngân hàng)';
				break;
			case -36:
				return 'Giao dịch không thành công do thẻ hoặc tài khoản đang bị khóa. Vui lòng liên hệ với ngân hàng của quý khách biết thêm thông tin';
				break;
			case -37:
				return 'Thẻ đang tạm khóa/chưa kích hoạt. Vui lòng liên hệ ngân hàng của quý khách';
				break;
			case -38:
				return 'Mã số bảo mật CVV/CVC không đúng. Vui lòng kiểm tra lại hoặc liên hệ với ngân hàng của quý khách biết thêm thông tin';
				break;
			default:
				break;
		}
		return 'Phát sinh lỗi từ hệ thống';
	}
	
	public static function rc4_encrypt ($data,$key)
	{
		if(APPLICATION_ENV == 'local') return sha1($data);
		$commonLib = new \Vng\G8\Crypt\Rc4Crypt();
		return base64_encode($commonLib->encrypt($data,array('key' => $key,'ispwdHex' => false)));
	}
	public static function rc4_decrypt ($data,$pwd, $ispwdHex = 0)
	{
		return rc4crypt::encrypt($pwd, $data, $ispwdHex);
	}
	public static function getAllStandartCountry() {
		$result  = array();
		try {
			$caching = Core_Global::getCaching();
			if(defined('CACHING_PREFIX')) {
				$caching_prefix = CACHING_PREFIX;
			} else {
				$caching_prefix = Core_Tools::getCachePrefix();
			}
			$key = $caching_prefix.'all_countries';
			if(($result = $caching->load($key)) === false) {
				$db = Core_Global::getDb123Pay();
				$sql = 'SELECT * FROM `countries` WHERE `status` = 1 order by stt';
				$stmt = $db->prepare($sql);
				$stmt->execute();
				$rows = $stmt->fetchAll();
				$stmt->closeCursor();
				foreach ($rows as $row) {
					$result[trim($row['country_code'])] = $row['country_name'];
				}
				$caching->save($result, $key);
			}
		} catch (Exception $e) {
			$result = array('VN' => 'VIET NAM','US' => 'US');
		}
		return $result;
	}
	public static function parseFullname($fullname) {
		$fullname = trim($fullname);
		$array = explode(' ', $fullname);
		$len = count($array);
		if($len == 1) return false;
		$firstname = trim($array[$len - 1]);
		if(empty($firstname)) return false;
		unset($array[$len - 1]);
		$lastname = join(' ', $array);
		if(empty($lastname)) return false;
		return array(
				'firstname' => $firstname,
				'lastname' => $lastname
		);
	}
	public static function hasSpecialChars($string,$regex='/[\`\~\!\@\#\$\%\^\&\*\(\)\-\=\+\[\{\\]\}\;\:\'\"\,\<\.\>\/\?\|]/') {
		$rs = preg_grep($regex, array($string));
		if(empty($rs)) return false;
		return true;
	}
        public static function isStringNumber($str) {
            if(is_numeric($str) && $str >= 0){
                return true;
            }
            return false;
        }
        public static function convertToASCII($string,$len = null) {
        	$string = trim($string);
        	if(empty($string)) return $string;
        	$pattern = array("a" => "á|à|ạ|ả|ã|Á|À|Ạ|Ả|Ã|ă|ắ|ằ|ặ|ẳ|ẵ|Ă|Ắ|Ằ|Ặ|Ẳ|Ẵ|â|ấ|ầ|ậ|ẩ|ẫ|Â|Ấ|Ầ|Ậ|Ẩ|Ẫ", "o" => "ó|ò|ọ|ỏ|õ|Ó|Ò|Ọ|Ỏ|Õ|ô|ố|ồ|ộ|ổ|ỗ|Ô|Ố|Ồ|Ộ|Ổ|Ỗ|ơ|ớ|ờ|ợ|ở|ỡ|Ơ|Ớ|Ờ|Ợ|Ở|Ỡ", "e" =>
        			"é|è|ẹ|ẻ|ẽ|É|È|Ẹ|Ẻ|Ẽ|ê|ế|ề|ệ|ể|ễ|Ê|Ế|Ề|Ệ|Ể|Ễ", "u" => "ú|ù|ụ|ủ|ũ|Ú|Ù|Ụ|Ủ|Ũ|ư|ứ|ừ|ự|ử|ữ|Ư|Ứ|Ừ|Ự|Ử|Ữ", "i" => "í|ì|ị|ỉ|ĩ|Í|Ì|Ị|Ỉ|Ĩ", "y" => "ý|ỳ|ỵ|ỷ|ỹ|Ý|Ỳ|Ỵ|Ỷ|Ỹ", "d" => "đ|Đ", "c" => "ç", );
        	$i = 0;
        	while ((list($key, $value) = each($pattern)) != null)
        	{
        		$i++;
        		if($i>=5000) break;
        		$string = preg_replace('/' . $value . '/i', $key, $string);
        	}
        	
        	if(mb_detect_encoding($string) != 'ASCII') {
        		$string = mb_convert_encoding($string, 'ASCII');
        	}
        	if($len == null) return $string;
        	return substr($string, 0, $len);
        }
        public static function getUserAgent() {
            return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        }
        public static function getChecksum($params,$sec_key,$ksort = true) {
            if($ksort == true) {
                ksort($params);
            }
            $rawData = '';
            foreach ($params as $key => $value) {
                    if($key != 'checksum') {
                        $rawData.=$value;
                    }
            }
            //debug($rawData.$sec_key);
            return sha1($rawData.$sec_key);
        }
        
        public static function hideString($string,$len) {
            $result = '';
            try {
                if(strlen($string) <= $len) {
                    return 'xxx';
                }
                $result = substr($string, 0, (0 - $len)) . 'xxx';
            } catch (Exception $exc) {
                $result = '';
            }
            return $result;
	}
        
        public static function isMobile() {
            if(APPLICATION_ENV == 'staging' || APPLICATION_ENV == 'production') {
                return false;
            }
            $session = new Zend_Session_Namespace(SESSION_USER_NAMESPACE);
            if(!isset($session->isMobile)) {
                include APPLICATION_PATH . '/../library/Core/Mobile_Detect.php';
                $mobileDetect = new Mobile_Detect();
                $session->isMobile = $mobileDetect->isMobile();
            }
            return $session->isMobile;
        }
        
        public static function isChar($char) {
            $char = strtolower($char);
            return ($char >= 'a' && $char <='z');
        }
        
        public static function isValidName($cardHolderName) {
            $len = strlen($cardHolderName);
            for ($i = 0;$i < $len;$i++) {
                if(Core_Tools::isChar($cardHolderName[$i])) {
                    return true;
                }
            }
            return false;
        }
        
        public static function isValidAlphabet($string) {
            if(empty($string)) {
                return true;
            }
            $length = strlen($string);
            $array = array('1','2','3','4','5','6','7','8','9','0','q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m');
            $i = 0;
            while ($i < $length) {
                if($i > 100) {
                    break;
                }
                if(!isset($string[$i])) {
                    break;
                }
                $char = strtolower($string[$i]);
                if(!in_array($char, $array)) {
                    return false;
                }
                $i++;
            }
            return true;
        }
        
}
