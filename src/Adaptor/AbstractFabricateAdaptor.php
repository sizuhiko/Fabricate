<?php
/**
 * Fabricate
 *
 * @package    Fabricate
 * @subpackage Fabricate\Adaptor
 */
namespace Fabricate\Adaptor;

/**
 * Fabricate Adaptor Abstract Class for adapting any framework model
 */
abstract class AbstractFabricateAdaptor {

/**
 * Get model definition
 *
 * @param string $modelName
 * @return Fabricate\Model\FabricateModel
 */
    abstract public function getModel($modelName);
}
