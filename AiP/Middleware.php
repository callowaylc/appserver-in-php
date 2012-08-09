<?php
namespace AiP;

/**
 * Provides common functionality amongst middleware components
 * @author Christian Calloway
 */
abstract class Middleware extends Object {
	
	function __construct($application) {
		
		// due to the poor design of appserver, middleware traditionally is invoked
		// via __invoke (which doesn't handle request/response); so we have to check
		// for both conditions
		// @TODO I really hate this but we are forced to accept two different
		// types
		if (is_callable($application) || $application instanceof Middleware) {
			$this->application = $application;
			
			// check if this class has been previously instantiated, we are going to 
			// "transparently" determine if middleware component is processing request or response.
			// Since we are only processing request and then response, we know that on
			// first instantiation that we are handling request, and on second, our response
			$this->invokes = isset(static::$history[get_class($this)])
			
				// wrap our invoke method within a lambda - this is cleaner than
				// using a string/symbol to determine invoke method later
				? function(&$response) { return $this->processResponse($response); } 			
				
				: function($request) { return $this->processRequest($request); };
			
		}
		
		else {
			throw new \Exception(
				"Failed to construct middleware component $this because paramter '$application' " .
				"must be a middleware component or invokable"
			);
		}
	}
	
	/**
	 * Returns request parameter; this methods purpose is to serve as stub
	 * until overriden in child class
	 */
	public function processRequest($request) {
		return $request;
	}
	
	/**
	 * Returns response parameter; this methods purpose is to serve as stub
	 * until overriden in child class
	 */
	public function processResponse($response) {
		return $response;
	}
	
	/**
	 * Our route to invocation of middleware always flows through invoke;
	 * its sloppy but fits into existing architecture
	 */
	public function __invoke($context) {		
    return call_user_func(
    	$this->app, $this->invokes($context)
		);
		
	}

	protected      $application;
	private        $invokes;
	private static $history = [ ];
}