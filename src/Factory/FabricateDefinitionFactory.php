<?php
/**
 * Fabricate
 * *
 * @package    Fabricate
 * @subpackage Fabricate\Factory
 */
namespace Fabricate\Factory;

/**
 * FabricateDefinitionFactory class
 */
class FabricateDefinitionFactory extends FabricateAbstractFactory
{

    /**
     * @var FabricateDefinition
     */
    private $definition;

    /**
     * Construct
     *
     * @param FabricateDefinition $definition definition instance
     */
    public function __construct($definition)
    {
        $this->definition = $definition;
    }

    /**
     * {@inheritDoc}
     */
    public function create($attributes, $recordCount, $definition)
    {
        if ($this->definition->parent) {
            return $this->definition->parent->create($attributes, $recordCount, $definition);
        }
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function build($data, $definition)
    {
        if ($this->definition->parent) {
            return $this->definition->parent->build($data, $definition);
        }
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function attributes_for($recordCount, $definition)
    {
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
    protected function fakeRecord($params, $index)
    {
        return [];
    }
}
