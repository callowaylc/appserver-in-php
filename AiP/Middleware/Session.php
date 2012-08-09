<?php
namespace AiP\Middleware;

use \AiP;


class Session extends AiP\Middleware {

	/**
	 * Retrieve session data from cookie and write to $_SESSION
	 * global
	 */
	public function processRequest($request) {
	  if (isset($context['mfs.session'])) {
	      throw new Session\LogicException('"mfs.session" key is already occupied in context');
		}
		
	  $ck = $context['mfs.session'] = new Session\Engine($context);
	
	
	  // Append cookie-headers
	  $result[1] = array_merge($result[1], $ck->_getHeaders());
	
	  return $result;		
	}
	
	/**
	 * Retrieve session data from $_SESSION global and write to
	 * cookie
	 */
	public function processResponse($response) {
		return $response;
	}


}