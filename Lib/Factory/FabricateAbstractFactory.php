<?php
App::uses('FabricateContext', 'Fabricate.Lib');

abstract class FabricateAbstractFactory {
	/**
	 * Create and Save fablicated model data to database.
	 * @param array $attributes
	 * @param integer $recordCount count for creating.
	 * @param mixed $callback callback or array can change fablicated data if you want to overwrite
	 */
	abstract public function create($attributes, $recordCount=1, $callback = null);
	/**
	 * Only create a model instance.
	 * @param mixed $data 
	 * @param $callback  function callback can chenge fablicated data if you want to overwrite
	 * @return Model Initializes the model for writing a new record
	 */
	abstract public function build($data, $callback = null);
	/**
	 * Only create model attributes array.
	 * @return array model attributes array.
	 */
	abstract public function attributes_for($recordCount=1, $callback = null);
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
	 * @return array Array of records.
	 */
	protected function _generateRecords($params, $recordCount = 1, $callback) {
		$world = new FabricateContext($this->config);
		$records = array();
		for ($i = 0; $i < $recordCount; $i++) {
			$record = $this->fakeRecord($params, $i);

			if(is_callable($callback)) {
				$record = array_merge($record, $callback($record, $world));
			} else if(is_array($callback)) {
				$record = array_merge($record, $callback);
			}
			$records[] = $record;
		}
		return $records;
	}
}