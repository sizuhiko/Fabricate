<?php
App::uses('FabricateContext', 'Fabricate.Lib');

abstract class FabricateAbstractFactory {
	/**
	 * Create and Save fablicated model data to database.
	 * @param array $attributes
	 * @param integer $recordCount count for creating.
	 * @param FabricateDefinition $definition 
	 */
	abstract public function create($attributes, $recordCount, $definition);
	/**
	 * Only create a model instance.
	 * @param mixed $data 
	 * @param FabricateDefinition $definition 
	 * @return mided 
	 */
	abstract public function build($data, $definition);
	/**
	 * Only create model attributes array.
	 * @param integer $recordCount count for creating.
	 * @param FabricateDefinition $definition 
	 * @return array model attributes array.
	 */
	abstract public function attributes_for($recordCount, $definition);
	/**
	 * Fake a record
	 * @param mixed $params _generateRecords params attribute
	 * @param integer $index each record index
	 * @return mixed faked record
	 */
	abstract protected function fakeRecord($params, $index);

	protected $config;

	public function setConfig($config) {
		$this->config = $config;
	}

	/**
	 * Generate Records
	 *
	 * @param array $params fakeRecord parameter
	 * @param integer $recordCount
	 * @param FabricateDefinition $definition 
	 * @return array Array of records.
	 */
	protected function _generateRecords($params, $recordCount, $definition) {
		$world = new FabricateContext($this->config);
		$records = array();
		for ($i = 0; $i < $recordCount; $i++) {
			$record = $this->fakeRecord($params, $i);
			$record = array_merge($record, $definition->run($record, $world));
			$records[] = $record;
		}
		return $records;
	}
}