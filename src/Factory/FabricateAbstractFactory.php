<?php
/**
 * Fabricate
 * *
 * @package    Fabricate
 * @subpackage Fabricate\Factory
 */
namespace Fabricate\Factory;

use Fabricate\FabricateContext;
use Fabricate\Fabricate;

/**
 * FabricateAbstractFactory class
 */
abstract class FabricateAbstractFactory {

/**
 * Create and Save fablicated model data to database.
 *
 * @param array $attributes map of model attributes and data
 * @param int $recordCount count for creating.
 * @param FabricateDefinition $definition define
 * @return mixed
 */
    abstract public function create($attributes, $recordCount, $definition);

/**
 * Only create a model instance.
 *
 * @param mixed $data model data
 * @param FabricateDefinition $definition define
 * @return mixed a model instance
 */
    abstract public function build($data, $definition);

/**
 * Only create model attributes array.
 *
 * @param int $recordCount count for creating.
 * @param FabricateDefinition $definition define
 * @return array model attributes array.
 */
    abstract public function attributes_for($recordCount, $definition);

/**
 * Fake a record
 *
 * @param mixed $params _generateRecords params attribute
 * @param int $index each record index
 * @return mixed faked record
 */
    abstract protected function fakeRecord($params, $index);

    protected $config;

/**
 * Set configuration
 *
 * @param array $config configuration
 * @return void
 */
    public function setConfig($config) {
        $this->config = $config;
    }

/**
 * Generate Records
 *
 * @param array $params fakeRecord parameter
 * @param int $recordCount count for generating
 * @param mixed $definitions FabricateDefinition(s)
 * @param mixed $model Model instance
 * @return array Array of records.
 */
    protected function _generateRecords($params, $recordCount, $definitions, $model) {
        $world = new FabricateContext($this->config, $model);
        if (!is_array($definitions)) {
            $definitions = [$definitions];
        }
        $records = array();
        for ($i = 0; $i < $recordCount; $i++) {
            $record = $this->fakeRecord($params, $i);
            $records[] = $this->applyNestedDefinitions($definitions, $record, $world);
        }
        return $records;
    }

/**
 * Apply nested definitions
 *
 * @param array $definitions array of FabricateDefinition
 * @param array $record data
 * @param FabricateContext $world context
 * @return array record applied nested definitions
 */
    private function applyNestedDefinitions($definitions, $record, $world) {
        foreach ($definitions as $definition) {
            $result = $definition->run($record, $world);
            $record = $this->applyTraits($record, $world);
            $record = array_merge($record, $result);
        }
        return $record;
    }

/**
 * Apply traits
 *
 * @param array $record data
 * @param FabricateContext $world context
 * @return array record applied traits
 */
    private function applyTraits($record, $world) {
        foreach ($world->flashTraits() as $use) {
            $traits = Fabricate::traits();
            if (array_key_exists($use, $traits)) {
                $record = array_merge($record, $traits[$use]->run($record, $world));
            }
        }
        return $record;
    }

}