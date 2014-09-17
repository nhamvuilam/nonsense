<?php
class Core_Utils_Game
{	
	public static function getServers($game_code) {
		$result = array(
			'response_code' => 0,
			'data' => array()
		);
		try {
			$response  = json_decode('{"response_code":1,"response_description":"Success","data":[{"id":"1","name":"All","address":"1","gamecode":"MSG","description":"Server game cu hanh","created":"2013-05-03","created_by":"luanpd","modified":"2013-05-03","modified_by":"luanpd"}]}',true);
			if($response['response_code'] == 1) {
				$result = array();
				foreach ($response['data'] as $item) {
					$result[$item['id']] = $item['name'];
				}
				$result = array(
					'response_code' => 1,
					'data' => $result
				);
			} else {
				$result['response_code'] = $response['response_code'];
			}
		} catch (Exception $e) {
			Model_Redis::getInstance()->monitorDaily(array('type'=>'Core_Utils_Game','code'=>-1,'info'=>array('store'=>Model_Order::$PREFIX_LOG."Model_Order::getServers({$game_code})",'err'=>$e->getMessage(),'date'=>date("Y-m-d H:i:s"))));
		}
		return $result;
	}
	public static function getGameCodes() {
		return array('CUHANH','VLCM');
	}
	public static function addGameItem($aData) {
		try {
			//throw new Exception('loi loi loi');
			//return 12;
			$aConfig = array(
					'url' => 'https://118.102.5.53/eloyalty/additem', //http://api.123pay.additem.vn/additem <https://sandbox.123pay.vn/eloyalty/additem%27%2c%20//http://api.123pay.additem.vn/additem> ',
					'key' => 'a'
			);
			$data = Core_Utils_Tools::callRest($aConfig, $aData);
			return $data['response_code'];
		} catch (Exception $e) {
			throw new Zend_Exception($e->getMessage(),ERR_ADD_GAME); 
		}
		return 0;
		
	}
}