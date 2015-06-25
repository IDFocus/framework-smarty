<?php
namespace InterExperts;
/**
* Wrapper voor de smarty class.
*
* @uses   Smarty  
*
* @author   InterExperts
*/
class Smarty {
	protected static $instances = array();
	private function __construct(){}

	/**
	 * Geeft een Smarty object terug voor de naam, wanneer deze al bestaat
	 * wordt het bestaande object opnieuw gegeven.
	 */
	public static function getInstance($name = '_stdout'){
		if(!isset(self::$instances[$name])){
			self::$instances[$name] = self::getUnique();
		}
		return self::$instances[$name];
	}

	/**
	 * Geef een geconfigureerd Smarty object terug.
	 * @return \Smarty Smarty object.
	 * @SuppressWarnings(PHPMD.ExitExpression)
	 */
	public static function getUnique() {
		$smarty = new \Smarty();

		$smarty->template_dir = dirname(__FILE__).'/../templates';
		$smarty->compile_dir = dirname(__FILE__).'/../cache/templates_c';
		$smarty->debugging = false;

		if (DEBUG === true && FORCE_COMPILE === true) {
			$smarty->compile_check = true;
			$smarty->force_compile = true;
		}

		$config = \InterExperts\Config::getInstance();
		$smarty->assign('config', $config);

		return $smarty;
	}

	/**
	 * @SuppressWarnings(PHPMD.ExitExpression)
	 */
	public static function showError($message){
		$smarty = self::getUnique();
		$smarty->assign('message', $message);
		$smarty->display('common/error.html');
		die();
	}
}
