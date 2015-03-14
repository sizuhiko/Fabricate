<?php 
namespace Test\Fabricate;

use Fabricate\FabricateConfig;
use Fabricate\FabricateContext;

/**
 * Fabricate class test case
 */
class FabricateContextTest extends \PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->Config = new FabricateConfig();
        $this->Context = new FabricateContext($this->Config);
    }

    public function testBasicSequence() {
        $this->assertEquals(1, $this->Context->sequence('name'));
        $this->assertEquals(2, $this->Context->sequence('name')); // second time should be incremented
    }

    public function testSequenceWithStartNumber() {
        $this->assertEquals(10, $this->Context->sequence('name', 10));
        $this->assertEquals(11, $this->Context->sequence('name', 10)); // second time should be incremented
    }

    public function testSequenceWithCallback() {
        $this->assertEquals("Name 1", $this->Context->sequence('name', function($i){
            return "Name {$i}";
        }));
        $this->assertEquals("Name 2", $this->Context->sequence('name', function($i){
            return "Name {$i}";
        })); // second time should be incremented
    }

    public function testSequenceWithStartNumberAndCallback() {
        $this->assertEquals("Name 10", $this->Context->sequence('name', 10, function($i){
            return "Name {$i}";
        }));
        $this->assertEquals("Name 11", $this->Context->sequence('name', 10, function($i){
            return "Name {$i}";
        })); // second time should be incremented
    }

    public function testSequenceMultiNames() {
        $this->assertEquals(1, $this->Context->sequence('name'));
        $this->assertEquals(2, $this->Context->sequence('name')); // second time should be incremented
        $this->assertEquals(1, $this->Context->sequence('number'));
        $this->assertEquals(2, $this->Context->sequence('number')); // second time should be incremented
    }

    public function testGetFakerInstance() {
        $this->Config->faker = \Faker\Factory::create();
        $this->assertSame($this->Config->faker, $this->Context->faker());
    }
}