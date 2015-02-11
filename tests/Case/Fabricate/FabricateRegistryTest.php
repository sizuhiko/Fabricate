<?php 
namespace Test\Fabricate;

use Fabricate\FabricateRegistry;
use Fabricate\Adaptor\FabricateArrayAdaptor;
use Fabricate\Model\FabricateModel;

/**
 * Fabricate class test case
 */
class FabricateRegistryTest extends \PHPUnit_Framework_TestCase {
    public function setUp() {
        $adaptor = new FabricateArrayAdaptor();
        $adaptor::$definitions = [
            'Post' => (new FabricateModel('Post'))
                ->addColumn('id', 'integer')
                ->addColumn('author_id', 'integer', ['null' => false])
                ->addColumn('title', 'string', ['null' => false])
                ->addColumn('body', 'text')
                ->addColumn('published', 'string', ['limit' => 1])
                ->addColumn('created', 'datetime')
                ->addColumn('updated', 'datetime'),
        ];
        $this->Registry = new FabricateRegistry('FabricateRegistry', $adaptor);
    }

    public function testFindIfNotRegisterdAndExistsModel() {
        $this->assertEquals('Post', $this->Registry->find('Post')->getName());
    }

    public function testFindIfRegisteredObject() {
        $this->Registry->register('FabricateRegistryTestComment', 'dummy');
        $this->assertEquals('dummy', $this->Registry->find('FabricateRegistryTestComment'));
    }

    public function testFindIfRegisteredObjectOverwriteExistsModel() {
        $this->Registry->register('Post', 'dummy');
        $this->assertEquals('dummy', $this->Registry->find('Post'));
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