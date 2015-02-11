<?php
/**
 * Fabricate
 *
 * @package    Fabricate
 * @subpackage Fabricate\Factory
 */
namespace Fabricate\Factory;

use Fabricate\Definition\FabricateDefinition;
use Fabricate\Model\FabricateModel;

/**
 * Fabricator Factory Proxy Class 
 */
class FabricateFactory {

/**
 * Create factory depends with definition
 *
 * @param mixed $definition FabricateDifinition or FabricateModel instance.
 * @return FabricateAbstractFactory 
 * @throws InvalidArgumentException
 */
    public static function create($definition) {
        if ($definition instanceof FabricateDefinition) {
            return new FabricateDefinitionFactory($definition);
        }
        if ($definition instanceof FabricateModel) {
            return new FabricateModelFactory($definition);
        }
        throw new \InvalidArgumentException("FabricateFactory is not support instance");
    }
}