<?php 
App::uses('FabricateFactory', 'Fabricate.Lib/Factory');
App::uses('AppModel', 'Model');
App::uses('FabricateDefinition', 'Fabricate.Lib/Definition');

class FabricateFactoryTestPost extends AppModel {
	public $useTable = 'posts';	
}

/**
 * FabricateFactory class test case
 */
class FabricateFactoryTest extends CakeTestCase {
	public $fixtures = ['plugin.fabricate.post'];

	public function testCreateModelFactory() {
		$this->assertInstanceOf('FabricateModelFactory', FabricateFactory::create(ClassRegistry::init('FabricateFactoryTestPost')));
	}

	public function testCreateDefinitionFactory() {
		$this->assertInstanceOf('FabricateDefinitionFactory', FabricateFactory::create(new FabricateDefinition([])));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCreateThrowExceptionIfNotSupportInstance() {
		FabricateFactory::create('Not Supported');
	}
}