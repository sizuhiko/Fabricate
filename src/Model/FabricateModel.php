<?php
/**
 * Fabricate
 *
 * @package    Fabricate
 * @subpackage Fabricate\Model
 */
namespace Fabricate\Model;

/**
 * Fabricate Model
 */
class FabricateModel {
    /** Model Name */
    private $modelName;
    /** Columns */
    private $columns = [];

/**
 * Construct
 *
 * @param string $modelName Model Name
 */
    public function __construct($modelName) {
        $this->modelName = $modelName;
    }

/**
 * Add column to the model
 *
 * Valid Column Types
 * Column types are specified as strings and can be one of:
 * <ul>
 * <li>string</li>
 * <li>text</li>
 * <li>integer</li>
 * <li>biginteger</li>
 * <li>float</li>
 * <li>decimal</li>
 * <li>datetime</li>
 * <li>timestamp</li>
 * <li>time</li>
 * <li>date</li>
 * <li>binary</li>
 * <li>boolean</li>
 * </ul>
 *
 * @param string $columnName Column Name
 * @param string $type Column Type
 * @param array $options Column Options
 * @return FabricateModel $this
 */
    public function addColumn($columnName, $type, $options = []) {
        $columns[$columnName] = ['type' => $type, 'options' => $options];
        return $this;
    }

/**
 * Get model name
 *
 * @return string
 */
    public function getName() {
        return $this->modelName;
    }
}
