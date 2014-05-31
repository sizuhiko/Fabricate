<?php 
App::uses('FabricateAbstractFactory', 'Fabricate.Lib/Factory');

class FabricateModelFactory extends FabricateAbstractFactory {
	private $model;

	public function __construct($model) {
		$this->model = $model;
	}

	public function create($attributes, $recordCount=1, $callback = null) {
		foreach ($attributes as $data) {
			$this->model->create($data);
			$this->model->save(null, $this->config->auto_validate);
		}
		return $this->model;
	}
	public function build($data, $callback = null) {
		$this->model->create($data[0]);
		return $this->model;
	}
	public function attributes_for($recordCount=1, $callback = null) {
		return $this->_generateRecords($this->model->schema(), $recordCount, $callback);
	}

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
							$insert = substr($insert, 0, (int)$fieldInfo['length'] - 2);
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