<?php

class AllBootstrapTest extends CakeTestSuite {
	public static function suite() {
		$suite = new CakeTestSuite('All Bootstrap Test');
		$path = APP . implode(DS, array('Plugin','TwitterBootstrap', 'Test','Case'));
		$suite->addTestDirectory($path . DS . 'Lib');
		$suite->addTestDirectory($path . DS . 'View' . DS . 'Helper');
		return $suite;
	}
}