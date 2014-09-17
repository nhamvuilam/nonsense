<?php
class Core_Utils_Tools
{	
	public static function getCurrentDateSQL() {
		return date('Y-m-d H:i:s');
	}
	public static function file_get_contents_utf8($fn) {
		$opts = array(
				'http' => array(
						'method'=>"GET",
						'header'=>"Content-Type: text/html; charset=utf-8"
				)
		);
	
		$context = stream_context_create($opts);
		$result = @file_get_contents($fn,false,$context);
		return $result;
	}
	
	public static function getParams($url) {
		$parts = parse_url($url);
		$query = array();
		if(isset($parts['query']) && !empty($parts['query']))
			parse_str($parts['query'], $query);
		return $query;
	}
	public static function printMessage($element) {
		$messages = $element->getMessages();
		$str = '';
		if(!empty($messages)) {
			$str = join('<br/>', $messages);
		}
		return $str;
	}
	public static function genKey($email=null) {
		if($email == null) {
			$key = '';
			list($usec, $sec) = explode(' ', microtime());
			mt_srand((float) $sec + ((float) $usec * 100000));
			$inputs = array_merge(range('z','a'),range(0,9),range('A','Z'));
			for($i=0; $i<32; $i++)
			{
				$key .= $inputs{mt_rand(0,61)};
			}
			return $key;
		} else {
			return hash('ripemd160', $email);
		}
		//return ord($email)  & 0x1FE;
	}
	public static function substr($str,$len=255) {
		if(mb_strlen($str,'UTF-8') <= $len) return $str;
		return mb_substr($str, 0, $len,'UTF-8').'...';
	}
	public static function getFullURL() {
		return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	}
	public static function genJobUrl($job) {
		return '/job/view-job/'.Core_Utils_String::getSlug($job['title']).'?id='.$job['id'];
	}
	public static function genSecureKey($len = 10) {
		$key = '';
		list($usec, $sec) = explode(' ', microtime());
		mt_srand((float) $sec + ((float) $usec * 100000));
		$inputs = array_merge(range('z','a'),range(0,9),range('A','Z'));
		for($i=0; $i<$len; $i++)
		{
		$key .= $inputs{mt_rand(0,61)};
		}
		return $key;
	}
	public static function getIPClient() {
		return $_SERVER['REMOTE_ADDR'];
	}
	public static function form2HTML($form) {
		$html = '';
    	foreach ($form as $element => $item) {
    		$str = '';
    		if($item['tag'] == 'input') {
    			$str = "<input name='$element' id='$element' ";
    			foreach ($item['attrs'] as $name => $value) {
    				$str.=$name.' = "'.$value.'" ';
    			}
    			$str.='/>';
    		}
    		$html.=$str;
    	}
    	return $html;
	}
	public static function trace($e) {
		echo '<pre>'.$e->getTraceAsString().'</pre>';die;
	}
	public static function isProduct() {
		if(APPLICATION_ENV == 'production') return true;
		return false;
	}
	public static function generateCookie(){
		$keycookie = '';
		if(!isset($_COOKIE['zingid'])){
			$keycookie = time().'_'.rand(0,1000);
			setcookie("zingid", $keycookie, time()+(7*24*3600), '/', $_SERVER['HTTP_HOST']); //expire in 7 days
		}else{
			$keycookie = '123s_'.$_COOKIE['zingid'];
		}
		return $keycookie;
	}
	
	public static function generateKey($zingid=NULL){
		if($zingid ==''){
			$key = Core_Utils_Tools::generateCookie();
			return $key;
		}
		return @trim($zingid);
	}
	public static function loadCities() {
		$caching = Core_Global::getCaching();
		$key  = Core_Global::getKeyPrefixCaching('vip_shop_city_key');
		if(($result = $caching->load($key)) == false) {
			$rows = Core_Utils_DB::query('SELECT `city_id`,`city_name` FROM `city` WHERE `status` = 1 ORDER BY `city_id`');
			$result = array();
			foreach ($rows as $row) {
				$result[$row['city_id']] = $row['city_name'];
			}
			$caching->save($result, $key, array(), 60*60*24);
		} 
		return $result;
	}
	public static function loadAllCities() {
		$caching = Core_Global::getCaching();
		$key  = Core_Utils_Tools::getCachePrefix().'all_cities';
		if(($result = $caching->load($key)) == false) {
			$rows = Core_Utils_DB::query('SELECT `city_id`,`city_name` FROM `city` WHERE `status` = 1 ORDER BY `city_id`');
			$result = array('' => '--Chọn tỉnh thành--');
			foreach ($rows as $row) {
				$result[$row['city_id']] = $row['city_name'];
			}
			$caching->save($result, $key, array(), 60*60*24);
		} 
		return $result;
	}
	public static function loadDistrictByCity($city_id) {
		$result = array();
		/* if($city_id != 1 && $city_id != 2) { // ko phai Hanoi & HCM
			return $result;
		} */
		$rows = Core_Utils_DB::query('SELECT `district_id`,`district_name` FROM `district` WHERE `status` = 1 AND `city_id` = ? ORDER BY `district_name`',1,array($city_id));
		//$array = array(38,39,40,41,42,57,61,7,8,9,10,11,12,13,14,15,17,18,19,34,35,36,770);
		foreach ($rows as $row) {
			//if(in_array($row['district_id'], $array)) continue;
			$result[$row['district_id']] = $row['district_name'];
		}
		return $result;
	}
	public static function strip_tags($data) {
		foreach($data as $key => $value) {
			$data[$key] = htmlspecialchars($value);
		}
		return $data;
	}
	public static function genToken() {
		$session = new Zend_Session_Namespace(SESSION_VIP_123PAY_VN);
		$token = Core_Utils_Tools::genSecureKey(32);
		$session->token = $token;
		return $token;
	}
	public static function getUid() {
		if(Core_Auth::getInstance()->isLoggedIn() == false) return '';
		$uid = Core_Auth::getInstance()->getEid();
		if(isset($uid) && !empty($uid)) return $uid;
		return Model_User::getInstance()->getZingId();
	}
	public static function getPoint($zid = '') {
		$flag_real = false;
                $zing_id = Model_User::getInstance()->getZingId();
		if(empty($zing_id)) return 0;
		$key = Core_Utils_Tools::getCachePrefix().'_flag_check_point_'.$zing_id;
		$caching = Core_Global::getCaching();
		$session = new Zend_Session_Namespace(SESSION_VIP_123PAY_VN);
		if(!isset($session->accountPoint) || $session->zingidPoint != $zing_id) {
			$flag_real = true;
		}
		if($flag_real == false) {
			if($caching->load($key) === false) $flag_real = true;
		}
		if($flag_real) {
			//Core_Log::trackcheckout(array('Load point realtime'),'debug');
			$rep = '';
			$session->accountPoint = Model_Point::getPoint($zing_id,$rep);
			$session->zingidPoint = $zing_id;
			$session->rep = $rep;
			$caching->save(array('point' => $session->accountPoint,'ranking' => $rep), $key, array(), 120);
		}
		return $session->accountPoint;
	}
	public static function getRep() {
		$session = new Zend_Session_Namespace(SESSION_VIP_123PAY_VN);
		if(!isset($session->rep)) {
			return 'Silver';
		}
		return $session->rep;
	}
	public static function resetPoint() {
		$session = new Zend_Session_Namespace(SESSION_VIP_123PAY_VN);
		$session->accountPoint = null;
	}
	public static function validProductPoint($point) {
		if($point == null || empty($point) ) return false;
		if(is_numeric($point)) {
			$point = intval($point);
		} else {
			$point = Core_Utils_Number::parseInt($point);
		}
		if($point < VIP_MIN_POINT) {
			return false;
		}
		return true;
	}
	public static function getContent($zingid=''){
		$content = array();
		$total = 0;
		for($i=0;$i<$total;$i++){
			$content[] = array('img'=>'','title'=>'Giảm 10% cho chủ thẻ Visa/ Master Card khi mua hàng tại 123.vn','url'=>'http://p.123.vn/eximbank/','target' => '_blank');
		}
		return $content;
	}
	public static function getPathByModule($module){
		return APPLICATION_PATH. '/modules/'.$module;
	}
	public static function getAddress($number,$address_name,$district_id){
		$result = '';
		try{
			//Excute
			$db = Core_Global::getDbMaster();
			$stmt = $db->prepare("SELECT city_name,`district_name` FROM `city` c LEFT JOIN `district` d ON c.`city_id` = d.`city_id` WHERE d.`district_id` = ?");
			$stmt->execute(array($district_id));
		
			//Fetch Result
			$row = $stmt->fetch();
			$stmt->closeCursor();
			$db->closeConnection();
			if($row != false) {
				$result = "$number $address_name, {$row['district_name']}, {$row['city_name']}";
			}
		}catch(Exception $e){
			Model_Redis::getInstance()->monitorDaily(array('type'=>'fe_db_exception','code'=>-1,'info'=>array('store'=>'getAddress','err'=>$e->getMessage(),'date'=>date("Y-m-d H:i:s"))));
			throw new Zend_Exception($e);
		}
		return $result;
	}
	public static function getCachePrefix() {
		return Core_Global::getKeyPrefixCaching('plus_123pay').'_';
	}
	
	public static function callRest($aConfig, $aData)
	{
		/* return array(
			'response_description' => 'SUCCESSFULLY',
			'httpcode' => 200		
		); */
		try {
			$sRawDataSign = '';
			foreach ($aData as $k => $v) {
				if ($k != 'checksum')
					$sRawDataSign .= $v;
			}
			//echo $sRawDataSign . $aConfig['key'].'<br>';
			$sign = sha1($sRawDataSign . $aConfig['key']);
			$aData['checksum'] = $sign;
			//echo $sign;
			//echo '<br>';
			$request = new Core_RestRequest($aConfig['url'], 'POST');
			$request->buildPostBody($aData);
			$request->execute();
			//$result = $request->getResponseInfo();
			
			//echo '<pre>';print_r($result);exit;
			$http_code = $request->getHTTPCode();
			$result = array(
					'httpcode' => $http_code,
					'response_code' => 0
			);
			if ($http_code == '200') {
				$result = json_decode($request->getResponseBody(), true);
				//$rs->return = $result;
				//$rs->return['httpcode'] = $http_code;
			}
			return $result;
		} catch (Exception $fault) {
			throw $fault;
		}
	} 
	public function findBannerByCode($blocklist){
		require_once APPLICATION_PATH . '/modules/default/models/Admbanner.php';
		//$blocklist = explode(",",$blocklist);
		//$result = array();
		$result_format = array();
		foreach ($blocklist as $code) {
			$result_format[$code] = array();
		}
		
		if(!empty($blocklist)){
			$time = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
			$ids = Model_Admbanner::getInstance()->getAllBlock();
			$result = array();
			if(!empty($ids)){
				foreach($ids as $item){
					if(!in_array($item['block_code'], $blocklist)) continue;
					$banner = Model_Admbanner::getInstance()->getBannerDetail($item['id']);
					foreach ($banner[$item['block_code']] as $index => $value) {
						//check time
						if((!empty($value['start_time']) && $time>=$value['start_time']) && (!empty($value['end_time']) && $time<=$value['end_time'])){
							$value['image'] = str_replace('http://', 'https://', $value['image']);
							$result_format[$item['block_code']][] = $value;
						}
					}
					//$result = array_merge($result, $result_format);
				}
			}
		}
		return $result_format;
	}
	public static function calculatePlus($product_point,$qty,$pay_point,$user_point) {
		$total = $product_point * $qty;
		$remain_point = $user_point - $pay_point;
		$min = $total;
		$result = array(
			'message' => '',
			'pay_money'	=> 0,
			'remain_point' => 0
		);
		$message = '';
		if($pay_point < $min) {
			$result['message'] = 'Bạn cần sử dụng ít nhất '+Core_Utils_Number::formatNumber($min)+' điểm Plus';
			return $result;
		}
		if($pay_point > $user_point ) {
			$result['message'] =  'Số điểm nhập không được lớn hơn số điểm hiện có, vui lòng nhập lại.';
			return $result;
		}
		if($pay_point > $total) {
			$result['message'] =  'Số điểm nhập vượt quá số điểm cần đổi, vui lòng nhập lại.';
			return $result;
		}
		if($pay_point == $total) {
			$result['remain_point'] = $remain_point;
			return $result;
		}
		/* if($pay_point % 50 != 0) {
			return 'Số điểm nhập phải là bội số của 50, vui lòng nhập lại.';
		} */
		$pay_money = ($total - $pay_point)*100;
		if($pay_money > 0  && $pay_money < 50000) {
			$result['message'] = 'Số tiền thanh toán thêm không được nhỏ hơn 50.000 VNĐ';
		}
		$result['pay_money'] = $pay_money;
		$result['remain_point'] = $remain_point;
		return $result;
	}
	
	public static function match($source,$s) {
		preg_match('/'.$s.'\s*([^;]*)/mi', $source, $m);
		if(isset($m[1])) return $m[1];
		return null;
	}
	
	public static function getVersion() {
		try {
			$version = Zend_Registry::get('version');
			if(isset($version) && !empty($version)) return $version;
		} catch (Exception $e) {
			return VERSION;
		}
		return VERSION;
	}
	
	public static function getImages() {
		$caching = Core_Global::getCaching();
		$name = Core_Utils_Tools::getCachePrefix().'product_images';
		if(($array = $caching->load($name)) == false) return array();
		return $array;
	}
	public static function debug($var,$exit=true) {
		echo '<pre>';
		print_r($var);
		if($exit) exit;
	}
	public static function check($var) {
		if(empty($var)) die('empty');
		if($var == null) die('null');
		print_r($var);
		exit;
	}
	public static function getPoint2(){
		$zingid = Model_User::getInstance()->getZingId();
		if(!empty($zingid)) {
			$session = new Zend_Session_Namespace('vngauth');
			$loyalty = isset($session->loyalty)?$session->loyalty:null;
			if($loyalty == null) {
				$eloyaltySrvc = new Core_Service_ELoyalty(); 
				$loyalty = $eloyaltySrvc->checkPoint($zingid);
				if (isset($loyalty['Status']) && $loyalty['Status'] == 1) {
					$loyalty['AccountName'] = $zingid;
					$loyalty['AccPoint'] = 0;
					$loyalty['ClassID'] = 0;
				}
				$session->loyalty = $loyalty;
			}
		}
		return $loyalty;
	}
	
	public static function isVNG() {
		if(APPLICATION_ENV == 'development') return true;
		if(APPLICATION_ENV=='production' && in_array(Core_Map::getIp(), array('118.102.7.146', '113.160.18.38', '117.6.84.202', '113.160.18.210', '117.6.64.165', '183.91.2.121', '117.6.84.136', '118.69.176.156','113.172.128.162','118.102.0.82','123.20.22.9','123.20.196.130','115.79.24.53'))){
			return true;
		}
		return false;
	}
	/**
	 * @desc Check chenh lech diem Plus voi gia san pham
	 * @param int $product_point
	 * @param int $product_price
	 * @return boolean
	 */
	public static function checkRate($product_point,$product_price,$product_id) {
		$product_point = intval($product_point);
		$product_price = intval($product_price);
		$check = intval($product_point * 2 / $product_price);
		if($check >= 1) {
			return true;
		}
		Core_PlusLog::getInstance()->log(array('error','InvalidPoint!',$product_id,$product_point,$product_price));
		Core_Utils_Notification::addAlertInfo('InvalidPoint', array($product_id,$product_point,$product_price),'sms');
		return false;
	}
        
        public static function isClicker() {
            $ip = Core_Map::getIp();
            if(empty($ip)) {
                return false;
            }
            if(in_array($ip, array('10.74.7.238','113.160.18.38','117.6.84.202','113.160.18.210','117.6.64.165','183.91.2.121','117.6.84.136','118.69.176.156','113.172.128.162','118.102.0.82','123.20.22.9','118.102.7.146','1.54.246.190','123.30.135.76','113.172.134.24 '))) {
                return true;
            }
            return false;
        }
}
