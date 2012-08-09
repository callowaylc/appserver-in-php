<?php
namespace AiP;

/**
 * Provides common functionality amongst middleware components
 * @author Christian Calloway
 */
abstract class Middleware implements ApplicationInterface {
	
	function __construct(ApplicationInterface $application) {
		//$this->app
	}
}
