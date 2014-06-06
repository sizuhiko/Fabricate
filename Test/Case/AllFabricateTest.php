<?php
/**
 * AllFabricateTest file
 */

class AllFabricateTest extends PHPUnit_Framework_TestSuite {

/**
 * suite method, defines tests for this suite.
 *
 * @return void
 */
	public static function suite() {
		$suite = new CakeTestSuite('All Fabricate Plugin related class tests');
		$suite->addTestDirectoryRecursive(dirname(__FILE__).DS.'Lib');
		return $suite;
	}
}
