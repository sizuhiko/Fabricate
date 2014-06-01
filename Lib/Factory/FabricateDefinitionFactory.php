<?php

class FabricateDefinitionFactory extends FabricateAbstractFactory {
	private $definition;

	public function __construct($definition) {
		$this->definition = $definition;
	}

	public function create($attributes, $recordCount, $definition) {
		if($this->definition->parent) {
			return $this->definition->parent->create($attributes, $recordCount, $definition);
		}
		return;
	}
	public function build($data, $definition) {
		if($this->definition->parent) {
			return $this->definition->parent->build($attributes, $definition);
		}
		return;
	}
	public function attributes_for($recordCount, $definition) {
		if($this->definition->parent) {
			if(is_array($definition)) {
				$definitions = $definition;
			} else {
				$definitions = [$definition];
			}
			array_unshift($definitions, $this->definition);
			return $this->definition->parent->attributes_for($recordCount, $definitions);
		}
		return $this->_generateRecords([], $recordCount, $definition);
	}

	protected function fakeRecord($params, $index) {
		return [];
	}	
}