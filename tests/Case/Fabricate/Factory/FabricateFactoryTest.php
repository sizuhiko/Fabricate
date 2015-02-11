<?php
namespace Test\Fabricate\Factory;

use Fabricate\Factory\FabricateFactory;
use Fabricate\Definition\FabricateDefinition;
use Fabricate\Model\FabricateModel;

/**
 * FabricateFactory class test case
 */
class FabricateFactoryTest extends \PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->model = (new FabricateModel('Post'))
            ->addColumn('id', 'integer')
            ->addColumn('author_id', 'integer', ['null' => false])
            ->addColumn('title', 'string', ['null' => false])
            ->addColumn('body', 'text')
            ->addColumn('published', 'string', ['limit' => 1])
            ->addColumn('created', 'datetime')
            ->addColumn('updated', 'datetime');
    }

    public function testCreateModelFactory() {
        $this->assertInstanceOf('Fabricate\Factory\FabricateModelFactory', FabricateFactory::create($this->model));
    }

    public function testCreateDefinitionFactory() {
        $this->assertInstanceOf('Fabricate\Factory\FabricateDefinitionFactory', FabricateFactory::create(new FabricateDefinition([])));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreateThrowExceptionIfNotSupportInstance() {
        FabricateFactory::create('Not Supported');
    }
}