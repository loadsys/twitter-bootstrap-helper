<?php
/**
 * TwitterBootstrapHelperTest file
 *
 */
App::uses('Controller', 'Controller');
App::uses('Helper', 'View');
App::uses('AppHelper', 'View/Helper');
App::uses('TwitterBootstrapHelper', 'TwitterBootstrap.View/Helper');
App::uses('HtmlHelper', 'View/Helper');
App::uses('FormHelper', 'View/Helper');
App::uses('ClassRegistry', 'Utility');
App::uses('Folder', 'Utility');

if (!defined('FULL_BASE_URL')) {
	define('FULL_BASE_URL', 'http://cakephp.org');
}

/**
 * TheBootstrapTestController class
 *
 * @package       Cake.Test.Case.View.Helper
 */
class TheBootstrapTestController extends Controller {

/**
 * name property
 *
 * @var string 'TheTest'
 */
	public $name = 'TheTest';

/**
 * uses property
 *
 * @var mixed null
 */
	public $uses = null;
}

class TestBootstrapHelper extends TwitterBootstrapHelper {
/**
 * expose a method as public
 *
 * @param string $options
 * @param string $exclude
 * @param string $insertBefore
 * @param string $insertAfter
 * @return void
 */
	public function parseAttributes($options, $exclude = null, $insertBefore = ' ', $insertAfter = null) {
		return $this->_parseAttributes($options, $exclude, $insertBefore, $insertAfter);
	}

/**
 * Get a protected attribute value
 *
 * @param string $attribute
 * @return mixed
 */
	public function getAttribute($attribute) {
		if (!isset($this->{$attribute})) {
			return null;
		}
		return $this->{$attribute};
	}

}

/**
 * HtmlHelperTest class
 *
 * @package       Cake.Test.Case.View.Helper
 */
class TwitterBootstrapHelperTest extends CakeTestCase {

/**
 * html property
 *
 * @var object
 */
	public $Html = null;

	public $validLabel = '<span class="label%s">Message</span>';

	public $validButton = '<button type="submit" class="btn%s">Submit</button>';

/**
 * setUp method
 *
 */
	public function setUp() {
		parent::setUp();
		$this->View = $this->getMock('View', array('addScript'), array(new TheBootstrapTestController()));
		$this->TwitterBootstrap = new TestBootstrapHelper($this->View);
		$this->TwitterBootstrap->request = new CakeRequest(null, false);
		$this->TwitterBootstrap->request->webroot = '';

		Configure::write('Asset.timestamp', false);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
		unset($this->TwitterBootstrap, $this->View);
	}
	
	/**
	 * Test the cases of the label method 
	 * 
	 * @access public
	 * @return void
	 */
	public function testValidLabels() {
		$expected = $this->validLabel;

		$default = $this->TwitterBootstrap->label("Message");
		$this->assertEquals(sprintf($expected, ""), $default);
		// Green label
		$success = $this->TwitterBootstrap->label("Message", "success");
		$this->assertEquals(sprintf($expected, " success"), $success);
		// Orange label
		$warning = $this->TwitterBootstrap->label("Message", "warning");
		$this->assertEquals(sprintf($expected, " warning"), $warning);
		// Red label
		$important = $this->TwitterBootstrap->label("Message", "important");
		$this->assertEquals(sprintf($expected, " important"), $important);
		// Blue label
		$notice = $this->TwitterBootstrap->label("Message", "notice");
		$this->assertEquals(sprintf($expected, " notice"), $notice);
	}

	/**
	 * Test the cases when the label method is passed invalid values for style 
	 * 
	 * @access public
	 * @return void
	 */
	public function testInvalidLabel() {
		$expected = sprintf($this->validLabel, "");

		// Returns default label when passed invalid string
		$invalid_string = $this->TwitterBootstrap->label("Message", "invalid");
		$this->assertEquals($expected, $invalid_string);
		// Returns default label when passed invalid int
		$invalid_int = $this->TwitterBootstrap->label("Message", 12);
		$this->assertEquals($expected, $invalid_int);
	}

	/**
	 * Test the cases of valid form buttons 
	 * 
	 * @access public
	 * @return void
	 */
	public function testValidButtons() {
		$expected = $this->validButton;

		$default = $this->TwitterBootstrap->button("Submit");
		$this->assertEquals(sprintf($expected, ""), $default);
	}

}
