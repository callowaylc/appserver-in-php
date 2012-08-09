<?php
namespace AiP\Middleware;

use \AiP;

/**
 * Adds mod_php familiarity to stateful environment
 * 
 * @NOTE this is seperate from AiP\
 */
class ModPHP extends AiP\Middleware {

	public function __invoke($context) {
		
		// place "superglobals" into global scope
		foreach(ModPHP::$globals as $global) {
			$GLOBALS[$global] = array();
			$context[$global] = &$GLOBALS[$global];
		}	
		
		$result = call_user_func($this->application, $context);
		
		// unset globals
		foreach(ModPHP::$globals as $global) {
			unset($GLOBALS[$global]);
		}	
		
		return $result;
	
	}

	private static $globals = [
		'_GET', '_POST', '_PUT', '_DELETE', '_COOKIE', '_FILES'
	];
}