<?php

/**
 * FabricateDefinition class
 */
class FabricateDefinition {

/**
 * definition for fabrication
 *
 * @var callback|array|false
 */
	private $define = false;

/**
 * parent defnition
 *
 * @var FabricateDefinition|false
 */
	public $parent = false;

/**
 * Construct
 *
 * @param mixed $define callback or attributes
 */
	public function __construct($define) {
		$this->define = $define;
	}

/**
 * Run to apply this definition 
 *
 * @param array $data data
 * @param FabricateContext $world fabricate context
 * @return array applied data
 */
	public function run($data, $world) {
		$result = [];
		if (is_callable($this->define)) {
			$callback = $this->define;
			$result = $callback($data, $world);
		} elseif (is_array($this->define)) {
			$result = $this->define;
		}
		return $result;
	}
}