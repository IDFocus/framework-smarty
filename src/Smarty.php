<?php
namespace IDFocus;
/**
* Wrapper voor de smarty class.
*
* @uses   Smarty  
*
* @author   IDFocus
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

		$smarty->template_dir = realpath(dirname(__FILE__).'/../../../../templates');
		$smarty->compile_dir = realpath(dirname(__FILE__).'/../../../../cache/templates_c');
		$smarty->plugins_dir = realpath(dirname(__FILE__).'/../../../../plugins');
		$smarty->debugging = false;

		if (defined('DEBUG') && DEBUG === true && defined('FORCE_COMPILE') && FORCE_COMPILE === true) {
			$smarty->compile_check = true;
			$smarty->force_compile = true;
		}

		$config = \IDFocus\Config::getInstance();
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
