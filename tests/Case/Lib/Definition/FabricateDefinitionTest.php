<?php 
App::uses('FabricateDefinition', 'Fabricate.Lib/Definition');

/**
 * FabricateDefinition class test case
 */
class FabricateDefinitionTest extends CakeTestCase {
	public function testRunCallbackDefinition() {
		$target = new FabricateDefinition(function($data, $world) {
			$this->assertEquals(['name'=>'taro'], $data);
			$this->assertEquals('world', $world);
			return ['name'=>'jiro'];
		});
		$this->assertEquals(['name'=>'jiro'], $target->run(['name'=>'taro'], 'world'));
	}

	public function testRunArrayDefinition() {
		$target = new FabricateDefinition(['name'=>'jiro']);
		$this->assertEquals(['name'=>'jiro'], $target->run(['name'=>'taro'], 'world'));
	}

	public function testRunNullDefinition() {
		$target = new FabricateDefinition(null);
		$this->assertEquals([], $target->run(['name'=>'taro'], 'world'));
	}
}