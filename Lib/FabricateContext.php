<?php

App::uses('FabricateSequence', 'Fabricate.Lib');
App::uses('FabricateConfig', 'Fabricate.Lib');

/**
 * Fabricator Context
 */
class FabricateContext {
	/**
	 * Sequence Hash map
	 */
	private $sequences = [];
	/**
	 * Trait use array
	 */
	private $traits = [];
	/**
	 * Fabricate config
	 */
	private $config;

	/**
	 * Construct with Configuration
	 */
	public function __construct($conf) {
		$this->config = $conf;
	}

	/**
	 * sequence allows you to get a series of numbers unique within the fabricate context.
	 * @param $name string sequence name
	 * @param $start int If you want to specify the starting number, you can do it with a second parameter. 
	 *         default value is 1.
	 * @param $callback function If you are generating something like an email address, 
	 *         you can pass it a block and the block response will be returned.
	 * @return mixed generated sequence
	 */
	public function sequence($name, $start=null, $callback=null) {
		if(is_callable($start)) {
			$callback = $start;
			$start = null;
		}
		if(!array_key_exists($name, $this->sequences)) {
			if($start === null) {
				$start = $this->config->sequence_start;
			}
			$this->sequences[$name] = new FabricateSequence($start);
		}
		$ret = $this->sequences[$name]->current();
		if(is_callable($callback)) {
			$ret = $callback($ret);
		}
		$this->sequences[$name]->next();
		return $ret;
	}

	/**
	 * Add apply trait in the scope.
	 * @param string|array $name use trait name(s)
	 */
	public function traits($name) {
		if(is_array($name)) {
			$this->traits = array_merge($this->traits, $name);
		} else {
			$this->traits[] = $name;
		}
	}

	/**
	 * Flush trait stack in the scope
	 * @return array flushed trait stack
	 */
	public function flashTraits() {
		$traits = $this->traits;
		$this->traits = [];
		return $traits;
	}

}