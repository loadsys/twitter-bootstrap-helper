<?php

App::uses('Controller', 'Controller');
App::uses('Helper', 'View');
App::uses('AppHelper', 'View/Helper');
App::uses('BootstrapPaginatorHelper', 'TwitterBootstrap.View/Helper');

if (!defined('FULL_BASE_URL')) {
	define('FULL_BASE_URL', 'http://cakephp.org');
}

class TestBootstrapPaginatorController extends Controller {
	public $name = 'TestBootstrapPaginator';
	public $uses = null;
}

class TestBootstrapPaginatorHelper extends BootstrapPaginatorHelper {
	/**
	 * expose a method as public
	 */
	public function parseAttributes($options, $exclude = null, $insertBefore = ' ', $insertAfter = null) {
		return $this->_parseAttributes($options, $exclude, $insertBefore, $insertAfter);
	}

	/**
	 * Get a protected attribute value
	 */
	public function getAttribute($attribute) {
		if (!isset($this->{$attribute})) {
			return null;
		}
		return $this->{$attribute};
	}

	/**
	 * Overwriting method to return a static string.
	 */
	public function _flash_content($key) {
		return "Flash content";
	}
}

class BootstrapPaginatorHelperTest extends CakeTestCase {

	public $BootstrapPaginator;
	public $View;

	public function setUp() {
		parent::setUp();
		$this->View = $this->getMock('View', array('append'), array(new TestBootstrapPaginatorController()));
		$this->BootstrapPaginator = new TestBootstrapPaginatorHelper($this->View);
		Configure::write('Asset.timestamp', false);
	}

	public function tearDown() {
		parent::tearDown();
		unset($this->BootstrapPaginator, $this->View);
	}

}
