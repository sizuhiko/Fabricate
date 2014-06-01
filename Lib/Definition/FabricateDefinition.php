<?php

/**
 * FabricateDefinition class
 */
class FabricateDefinition {
	private $define = false;
	public $parent = false;

	/**
	 * @param mixed $define callback or attributes
	 */
	public function __construct($define) {
		$this->define = $define;
	}

	public function run($data, $world) {
		$result = [];
		if(is_callable($this->define)) {
			$callback = $this->define;
			$result = $callback($data, $world);
		} else if(is_array($this->define)) {
			$result = $this->define;
		}
		return $result;
	}
}