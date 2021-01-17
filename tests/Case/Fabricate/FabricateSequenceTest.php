<?php
namespace Test\Fabricate;

use Fabricate\FabricateSequence;
use PHPUnit\Framework\TestCase;

/**
 * Fabricate class test case
 */
class FabricateSequenceTest extends TestCase {

    public function setUp(): void {
        $this->Sequence = new FabricateSequence(1);
    }

    public function testCurrent() {
        $this->assertEquals(1, $this->Sequence->current());
    }

    public function testNext() {
        $this->assertEquals(2, $this->Sequence->next());
        $this->assertEquals(2, $this->Sequence->current());
    }
}
