<?php
/**
 * Fabricate
 * *
 * @package    Fabricate
 */
namespace Fabricate;

/**
 * Fabricator Sequence Class 
 */
class FabricateSequence {

    /**
     * @var int
     */
    private $sequence;

    /**
     * Construct with sequence start
     *
     * @param int $start number of starting
     */
    public function __construct($start) {
        $this->sequence = $start;
    }

    /**
     * Get current sequence number
     *
     * @return int
     */
    public function current() {
        return $this->sequence;
    }

    /**
     * Increment sequence number
     *
     * @return int incremented number
     */
    public function next() {
        return ++$this->sequence;
    }
}