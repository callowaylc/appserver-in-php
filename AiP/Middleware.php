<?php
namespace AiP;

/**
 * Provides common functionality amongst middleware components
 * @author Christian Calloway
 */
abstract class Middleware extends Object {
	
	function __construct($application) {

		// determines if application parameter is callable, either via
		// __invoke method or as a lambda
		if (is_callable($application) ) {
			$this->application = $application;
		}
		
		else {
			throw new \Exception(
				"Failed to construct middleware component $this because paramter '$application' " .
				"must be a middleware component or invokable"
			);
		}
	}
	 
}