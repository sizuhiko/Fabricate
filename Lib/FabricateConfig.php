<?php

/**
 * Fabricator Configuration
 */
class FabricateConfig {

/**
 * start number for $world->sequence()
 *
 * @var integer
 */
	public $sequence_start = 1;

/**
 * validate either a boolean
 *
 * @var boolean
 */
	public $auto_validate = false;

/**
 * overwrites any primary key input with an empty value if true 
 *
 * @var boolean
 */
	public $filter_key = false;

/**
 * connect to test datasouce if true
 *
 * @var boolean
 */
	public $testing = true;
}