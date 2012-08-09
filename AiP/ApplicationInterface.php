<?php
namespace AiP;

/**
 * Provides protocol/contract for middleware and application components in
 * AiP library; 
 * @TODO Perhaps placing a magic method into an interface
 * is bad form?
 * @author Christian Calloway
 */
interface ApplicationInterface {
	public function __invoke();
}
