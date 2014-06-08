<?php 
App::uses('FabricateRegistry', 'Fabricate.Lib');
App::uses('AppModel', 'Model');

class FabricateRegistryTestPost extends AppModel {
	public $useTable = 'posts';	
}

/**
 * Fabricate class test case
 */
class FabricateRegistryTest extends CakeTestCase {
	public $fixtures = ['plugin.fabricate.post'];

	public function setUp() {
		$this->Registry = new FabricateRegistry('FabricateRegistry');
	}

	public function testFindIfNotRegisterdAndExistsModel() {
		$this->assertInstanceOf('FabricateRegistryTestPost', $this->Registry->find('FabricateRegistryTestPost'));
	}

	public function testFindIfRegisteredObject() {
		$this->Registry->register('FabricateRegistryTestComment', 'dummy');
		$this->assertEquals('dummy', $this->Registry->find('FabricateRegistryTestComment'));
	}

	public function testFindIfRegisteredObjectOverwriteExistsModel() {
		$this->Registry->register('FabricateRegistryTestPost', 'dummy');
		$this->assertEquals('dummy', $this->Registry->find('FabricateRegistryTestPost'));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testFindThrowExceptionIfNotRegistered() {
		$this->Registry->find('NotRegistered');
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testFindThrowExceptionIfRegisteredObjectCleared() {
		$this->Registry->register('FabricateRegistryTestComment', 'dummy');
		$this->Registry->clear();
		$this->Registry->find('FabricateRegistryTestComment');
	}
}