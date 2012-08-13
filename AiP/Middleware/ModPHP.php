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
		
		// PRE-REQUEST
		// place "superglobals" into global scope
		foreach(ModPHP::$globals as $global) {
			
			// if our "context" is already aware of superglobals
			// then simply reference it
			if (!isset($GLOBALS[$global])) {
				if (isset($context[$global])) {
					$GLOBALS[$global] = &$context[$global];
				}
				
				// otherwise, we create array instance and reference on
				// context
				else {
					$GLOBALS[$global] = [ ];
					$context[$global] = &$GLOBALS[$global];
				}
			}
		}	
		
		
		// PASS TO NEXT MIDDLEWARE INSTANCE
		$result = call_user_func($this->application, $context);
		
		// POST-REQUEST
		// unset globals - technically we dont have to unset our 
		// reference, but doing so for clarity sake and isset
		// funciton, should that ever come into play
		foreach(ModPHP::$globals as $global) {
			unset($GLOBALS[$global]);
			unset($context[$global]);
		}	
		
		// RESPONSE W/HEADERS
		return $result;
	
	}

	private static $globals = [
		'_GET', '_POST', '_PUT', '_DELETE', '_COOKIE', '_FILES', '_SESSION'
	];
}