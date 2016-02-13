<?php 
App::uses('FabricateAbstractFactory', 'Fabricate.Lib/Factory');

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
		foreach ($attributes as $data) {
			$this->model->create($data, $this->config->filter_key);
			$this->model->saveAssociated(null,  [
				'validate' => $this->config->auto_validate,
				'deep'     => true,
			]);
		}
		return $this->model;
	}

/**
 * {@inheritDoc}
 */
	public function build($data, $definition) {
		$this->model->create($data[0], $this->config->filter_key);
		return $this->model;
	}

/**
 * {@inheritDoc}
 */
	public function attributes_for($recordCount, $definition) {
		return $this->_generateRecords($this->model->schema(), $recordCount, $definition, $this->model);
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
				case 'integer':
				case 'float':
					$insert = $this->config->sequence_start + $index;
					break;
				case 'string':
				case 'binary':
					$isPrimaryUuid = (
						isset($fieldInfo['key']) && strtolower($fieldInfo['key']) === 'primary' &&
						isset($fieldInfo['length']) && $fieldInfo['length'] == 36
					);
					if ($isPrimaryUuid) {
						$insert = String::uuid();
					} else {
						$insert = "Lorem ipsum dolor sit amet";
						if (!empty($fieldInfo['length'])) {
							$length = (int)$fieldInfo['length'];
							$length = $length === 1? $length : ($length - 2);
							$insert = substr($insert, 0, $length);
						}
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
					$insert = 1;
					break;
				case 'text':
					$insert = "Lorem ipsum dolor sit amet, aliquet feugiat.";
					$insert .= " Convallis morbi fringilla gravida,";
					$insert .= " phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin";
					$insert .= " venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla";
					$insert .= " vestibulum massa neque ut et, id hendrerit sit,";
					$insert .= " feugiat in taciti enim proin nibh, tempor dignissim, rhoncus";
					$insert .= " duis vestibulum nunc mattis convallis.";
					break;
			}
			$record[$field] = $insert;
		}
		return $record;
	}
}