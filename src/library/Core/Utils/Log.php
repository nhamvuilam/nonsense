<?php
class Core_Utils_Log
{	
	public static function log($msg) {
		//echo $msg.PHP_EOL;
		/* $logFileName = 'LOG_'.date('Y-m-d').'.txt';
		$writer = new Zend_Log_Writer_Stream(LOG_PATH.$logFileName);
		$logger = new Zend_Log($writer);
		$logger->setTimestampFormat('Y-m-d H:i:s');
		$logger->log($msg, Zend_Log::INFO);
		$writer->shutdown(); */
		$db = Core_Global::getDbMaster();
		$stmt = $db->prepare("INSERT DELAYED INTO `plus_log`(`log_time`,`log_type`,`content`) VALUES (NOW(),'INFO',?)");
		$stmt->execute(array($msg));
		$stmt->closeCursor();
		$db->closeConnection();
		//$logger->error($msg);
	}
	public static function error($msg,$code='',$urgent = false) {
		//echo 'MESSAGE : '.$msg.PHP_EOL;
		/* $msg = $e->getMessage().PHP_EOL;
		$msg.= $e->getTraceAsString();
		if($pri == null) $pri = Zend_Log::ERR;
		if($pri == Zend_Log::EMERG) { //khan cap
			//send email & sms
			//Core_Utils_MailUtil::getInstance()->send(MASTER_EMAIL,'Grab error',$msg);
			//Worker_Model_Log::getInstance()->writeLog($msg);
			//$coreEmail = new Core_Email();
			//$coreEmail->send(DEV_EMAIL, '[jobbid.vn] EMERG!', $msg);
		}
		$logFileName = 'ERROR_'.date('Y-m-d').'.txt';
		$writer = new Zend_Log_Writer_Stream(LOG_PATH.$logFileName);
		$logger = new Zend_Log($writer);
		$logger->setTimestampFormat('Y-m-d H:i:s');
		$logger->log($msg, $pri);
		$writer->shutdown(); */
		if($urgent == true && APPLICATION_ENV != 'development') {
			$commonService = new Core_ApiService("Common");
			$commonService->sendMail('nclong87@gmail.com',$msg,'[plus.123pay.vn] ERROR : '.$code);
		}
		$db = Core_Global::getDbMaster();
		$stmt = $db->prepare("INSERT DELAYED INTO `plus_log`(`log_time`,`log_type`,`code`,`content`) VALUES (NOW(),'ERROR',?,?)");
		$stmt->execute(array($code,$msg));
		$stmt->closeCursor();
		$db->closeConnection();
		//$logger->error($msg);
	}

	
}