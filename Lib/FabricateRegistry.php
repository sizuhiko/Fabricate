<?php

/**
 * Fabricator Registry Class 
 */
class FabricateRegistry {
	private $name;
	private $items;

	/**
	 * Construct with registry name
	 * @param string $name registry name
	 */
	public function __construct($name) {
		$this->name  = $name;
		$this->items = [];
	}

	/**
	 * Clear registerd entries
	 */
	public function clear() {
		$this->items = [];
	}

	/**
	 * Find from registred or model by name
	 * @param string $name
	 * @param boolean $testing
	 * @return mixed registerd object
	 */
	public function find($name, $testing=true) {
		if($this->is_registered($name)) {
			return $this->items[$name];
		}
		$model = ClassRegistry::init(['class'=>$name, 'testing'=>$testing], true);
		if($model) {
			return $model;
		}
		throw new InvalidArgumentException("{$name} not registered");
	}

	/**
	 * Regist to registries
	 * @param string $name
	 * @param FabricateDefinition $item
	 */
	public function register($name, $item) {
		$this->items[$name] = $item;
	}

	/**
	 * Is registered?
	 * @param string $name
	 * @return boolean
	 */
	public function is_registered($name) {
		return array_key_exists($name, $this->items);
	}
}
