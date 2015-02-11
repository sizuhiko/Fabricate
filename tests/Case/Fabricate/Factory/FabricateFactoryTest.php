<?php
namespace Test\Fabricate\Factory;

use Fabricate\Factory\FabricateFactory;
use Fabricate\Definition\FabricateDefinition;

class FabricateFactoryTestPost extends AppModel {
    public $useTable = 'posts'; 
}

/**
 * FabricateFactory class test case
 */
class FabricateFactoryTest extends \PHPUnit_Framework_TestCase {
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