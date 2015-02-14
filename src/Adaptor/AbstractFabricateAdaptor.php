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

    /**
     * Create and Save fablicated model data to database.
     *
     * @param string $modelName
     * @param array $attributes map of model attributes and data
     * @param int $recordCount count for creating.
     * @return mixed
     */
    abstract public function create($modelName, $attributes, $recordCount);

    /**
     * Only create a model instance.
     *
     * @param string $modelName
     * @param mixed $data model data
     * @return mixed a model instance
     */
    abstract public function build($modelName, $data);
}
