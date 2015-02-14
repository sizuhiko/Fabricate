<?php 
/**
 * Fabricate
 * *
 * @package    Fabricate
 * @subpackage Fabricate\Factory
 */
namespace Fabricate\Factory;

/**
 * FabricateModelFactory class
 */
class FabricateModelFactory extends FabricateAbstractFactory {

/**
 * @var Model CakePHP Model instance
 */
    private $model;

/**
 * Construct
 *
 * @param Model $model CakePHP Model instance
 */
    public function __construct($model) {
        $this->model = $model;
    }

/**
 * {@inheritDoc}
 */
    public function create($attributes, $recordCount, $definition) {
        return $this->config->adaptor->create($this->model->getName(), $attributes, $recordCount);
    }

/**
 * {@inheritDoc}
 */
    public function build($data, $definition) {
        return $this->config->adaptor->build($this->model->getName(), $data[0], $this->model);
    }

/**
 * {@inheritDoc}
 */
    public function attributes_for($recordCount, $definition) {
        return $this->_generateRecords($this->model->getColumns(), $recordCount, $definition, $this->model);
    }

/**
 * {@inheritDoc}
 */
    protected function fakeRecord($tableInfo, $index) {
        foreach ($tableInfo as $field => $fieldInfo) {
            if (empty($fieldInfo['type'])) {
                continue;
            }
            $insert = '';
            switch ($fieldInfo['type']) {
                case 'biginteger':
                case 'integer':
                case 'float':
                case 'decimal':
                    $insert = $this->config->sequence_start + $index;
                    break;
                case 'string':
                case 'binary':
                    $insert = $this->config->faker->realText();
                    if(!empty($fieldInfo['options']['limit'])) {
                        $insert = substr($insert, 0, (int)$fieldInfo['options']['limit']);
                    }
                    break;
                case 'timestamp':
                    $insert = time();
                    break;
                case 'datetime':
                    $insert = date('Y-m-d H:i:s');
                    break;
                case 'date':
                    $insert = date('Y-m-d');
                    break;
                case 'time':
                    $insert = date('H:i:s');
                    break;
                case 'boolean':
                    $insert = true;
                    break;
                case 'text':
                    $maxNbChars = !empty($fieldInfo['options']['limit']) ? $fieldInfo['options']['limit'] : 200;
                    $insert = $this->config->faker->text($maxNbChars);
                    break;
            }
            $record[$field] = $insert;
        }
        return $record;
    }
}