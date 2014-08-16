<?php

class FabricateDefinitionFactory extends FabricateAbstractFactory {

/**
 * @var FabricateDefinition
 */
	private $definition;

/** 
 * Construct
 *
 * @param FabricateDefinition $definition definition instance
 */
	public function __construct($definition) {
		$this->definition = $definition;
	}

/**
 * {@inheritDoc}
 */
// @codingStandardsIgnoreStart
	public function create($attributes, $recordCount, $definition) {
// @codingStandardsIgnoreEnd
		if ($this->definition->parent) {
			return $this->definition->parent->create($attributes, $recordCount, $definition);
		}
		return null;
	}

/**
 * {@inheritDoc}
 */
// @codingStandardsIgnoreStart
	public function build($data, $definition) {
// @codingStandardsIgnoreEnd
		if ($this->definition->parent) {
			return $this->definition->parent->build($attributes, $definition);
		}
		return null;
	}

/**
 * {@inheritDoc}
 */
// @codingStandardsIgnoreStart
	public function attributes_for($recordCount, $definition) {
// @codingStandardsIgnoreEnd
		if ($this->definition->parent) {
			if (is_array($definition)) {
				$definitions = $definition;
			} else {
				$definitions = [$definition];
			}
			array_unshift($definitions, $this->definition);
			return $this->definition->parent->attributes_for($recordCount, $definitions);
		}
		return $this->_generateRecords([], $recordCount, $definition, false);
	}

/**
 * {@inheritDoc}
 */
// @codingStandardsIgnoreStart
	protected function fakeRecord($params, $index) {
// @codingStandardsIgnoreEnd
		return [];
	}
}