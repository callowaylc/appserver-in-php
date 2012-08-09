<?php
namespace Aip;

/**
 * Aiup
 * @author Christian Calloway
 */
abstract class Object {
	
	public function __toString() {
		return get_class($this) . '<' . spl_object_hash($this)  . '>';
	}
}
