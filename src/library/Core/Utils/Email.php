<?php
class Core_Utils_Email
{
	public static function render($template_name,$data,$module = 'pay') {
		try {
			$html = new Zend_View();
			$html->setScriptPath(Core_Utils_Tools::getPathByModule($module).'/'.Core_Utils_Tools::getVersion().'/views/scripts/templates/emails');
			// assign valeues
			$html->assign('data', $data);
			// render view
			return $html->render($template_name);
		} catch (Exception $e) {
			die('ERROR');
		}
		
	}
     
}
?>