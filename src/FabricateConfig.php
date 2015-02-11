<?php
/**
 * Fabricate
 * *
 * @package    Fabricate
 */
namespace Fabricate;

/**
 * Fabricator Configuration
 */
class FabricateConfig {

/**
 * start number for $world->sequence()
 *
 * @var int
 */
    public $sequence_start = 1;

/**
 * validate either a boolean
 *
 * @var bool
 */
    public $auto_validate = false;

/**
 * overwrites any primary key input with an empty value if true 
 *
 * @var bool
 */
    public $filter_key = false;

/**
 * connect to test datasouce if true
 *
 * @var bool
 */
    public $testing = true;

/**
 * adaptor
 *
 * @var Fabricate\Adaptor\AbstractFabricateAdaptor
 */
	public $adaptor = null;
}