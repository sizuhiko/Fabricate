<?php
App::uses('FabricateDefinition', 'Fabricate.Lib/Definition');
App::uses('FabricateDefinitionFactory', 'Fabricate.Lib/Factory');
App::uses('Model', 'Model');
App::uses('FabricateModelFactory', 'Fabricate.Lib/Factory');

/**
 * Fabricator Factory Proxy Class 
 */
class FabricateFactory {

/**
 * Create factory depends with definition
 *
 * @param mixed $definition FabricateDifinition or CakePHP Model instance.
 * @return FabricateAbstractFactory 
 * @throws InvalidArgumentException
 */
	public static function create($definition) {
		if ($definition instanceof FabricateDefinition) {
			return new FabricateDefinitionFactory($definition);
		}
		if ($definition instanceof Model) {
			return new FabricateModelFactory($definition);
		}
		throw new InvalidArgumentException("FabricateFactory is not support instance");
	}
}