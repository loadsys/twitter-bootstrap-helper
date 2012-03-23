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

class Contact extends CakeTestModel {

	/**
	 * primaryKey property
	 *
	 * @var string 'id'
	 */
	public $primaryKey = 'id';

	/**
	 * useTable property
	 *
	 * @var bool false
	 */
	public $useTable = false;

	/**
	 * name property
	 *
	 * @var string 'Contact'
	 */
	public $name = 'Contact';
	
	/**
	 * Default schema
	 *
	 * @var array
	 */
	protected $_schema = array(
		'id' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => '8'),
		'name' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'email' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'phone' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'password' => array('type' => 'string', 'null' => '', 'default' => '', 'length' => '255'),
		'published' => array('type' => 'date', 'null' => true, 'default' => null, 'length' => null),
		'created' => array('type' => 'date', 'null' => '1', 'default' => '', 'length' => ''),
		'updated' => array('type' => 'datetime', 'null' => '1', 'default' => '', 'length' => null),
		'age' => array('type' => 'integer', 'null' => '', 'default' => '', 'length' => null)
	);

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

	/**
	 * Overwriting method to return a static string.
	 *
	 * @param string $key
	 * @return string
	 */
	public function _flash_content($key) {
		return "Flash content";
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
		$this->TwitterBootstrap->Form = new FormHelper($this->View);
		$this->TwitterBootstrap->request = new CakeRequest(null, false);
		$this->TwitterBootstrap->request->webroot = '';

		$this->Form = &$this->TwitterBootstrap->Form;
		$this->Form->Html = new HtmlHelper($this->View);
		$this->Form->request = new CakeRequest('contacts/add', false);
		$this->Form->request->here = '/contacts/add';
		$this->Form->request['action'] = 'add';
		$this->Form->request->webroot = '';
		$this->Form->request->base = '';		

		ClassRegistry::addObject('Contact', new Contact());		

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
	 * testValidLabels 
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
	 * testInvalidLabel 
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
	 * testValidButtonStyles 
	 * 
	 * @access public
	 * @return void
	 */
	public function testValidButtonStyles() {
		$expected = $this->validButton;
		// Default button
		$default = $this->TwitterBootstrap->button("Submit");
		$this->assertEquals(sprintf($expected, ""), $default);
		// Primary button
		$primary = $this->TwitterBootstrap->button("Submit", array("style" => "primary"));
		$this->assertEquals(sprintf($expected, " primary"), $primary);
		// Info button
		$info = $this->TwitterBootstrap->button("Submit", array("style" => "info"));
		$this->assertEquals(sprintf($expected, " info"), $info);
		// Success button
		$success = $this->TwitterBootstrap->button("Submit", array("style" => "success"));
		$this->assertEquals(sprintf($expected, " success"), $success);
		// Danger button
		$danger = $this->TwitterBootstrap->button("Submit", array("style" => "danger"));
		$this->assertEquals(sprintf($expected, " danger"), $danger);
	}

	/**
	 * testValidButtonSizes 
	 * 
	 * @access public
	 * @return void
	 */
	public function testValidButtonSizes() {
		$expected = $this->validButton;
		// Small button
		$small = $this->TwitterBootstrap->button("Submit", array("size" => "small"));
		$this->assertEquals(sprintf($expected, " small"), $small);
		// Large button
		$large = $this->TwitterBootstrap->button("Submit", array("size" => "large"));
		$this->assertEquals(sprintf($expected, " large"), $large);
		// Mixed button
		$mixed = $this->TwitterBootstrap->button(
			"Submit",
			array("style" => "primary", "size" => "small")
		);
		$this->assertEquals(sprintf($expected, " primary small"), $mixed);
	}

	public function testInvalidButtonStylesAndSizes() {
		$expected = $this->validButton;
		// Invalid size button
		$invalid_size = $this->TwitterBootstrap->button("Submit", array("size" => "invalid"));
		$this->assertEquals(sprintf($expected, ""), $invalid_size);
		// Invalid style button
		$invalid_style = $this->TwitterBootstrap->button("Submit", array("style" => "invalid"));
		$this->assertEquals(sprintf($expected, ""), $invalid_style);
	}

	/**
	 * testValidButtonLinks 
	 * 
	 * @access public
	 * @return void
	 */
	public function testValidButtonLinks() {
		$expected = array(
			'a' => array(
				'href' => '/home',
				'class' => 'preg:/btn/'
			),
			'preg:/Link Text/',
			'/a'
		);
		$result = $this->TwitterBootstrap->button_link("Link Text", "/home");
		$this->assertTags($result, $expected);

		$result = $this->TwitterBootstrap->button_link(
			"Link Text",
			"/home",
			array("size" => "large")
		);
		$expected["a"]["class"] = 'preg:/btn large/';
		$this->assertTags($result, $expected);

		$result = $this->TwitterBootstrap->button_link(
			"Link Text",
			"/home",
			array("style" => "info")
		);
		$expected["a"]["class"] = 'preg:/btn info/';
		$this->assertTags($result, $expected);

		$result = $this->TwitterBootstrap->button_link(
			"Link Text",
			"/home",
			array("style" => "info", "size" => "small")
		);
		$expected["a"]["class"] = 'preg:/btn info small/';
		$this->assertTags($result, $expected);

		$result = $this->TwitterBootstrap->button_link(
			"Link Text",
			"/home",
			array("style" => "info", "size" => "small", "class" => "some-class")
		);
		$expected["a"]["class"] = 'preg:/some-class btn info small/';
		$this->assertTags($result, $expected);
	}

	/**
	 * testValidButtonForm 
	 * 
	 * @access public
	 * @return void
	 */
	public function testValidButtonForm() {
		$expected = array(
			'form' => array(
				'method' => 'post', 'action', 'name' => 'preg:/post_\w+/',
				'id' => 'preg:/post_\w+/', 'style' => 'display:none;'
			),
			'input' => array('type' => 'hidden', 'name' => '_method', 'value' => 'POST'),
			'/form',
			'a' => array(
				'href' => '#', 'onclick' => 'preg:/document\.(.)+\.submit\(\); event\.returnValue = false; return false;/',
				'class' => 'preg:/btn/'
			),
			'Link Text',
			'/a'
		);		

		$result = $this->TwitterBootstrap->button_form("Link Text", "/home");
		$this->assertTags($result, $expected);

		$expected['a']['class'] = 'preg:/btn small/';
		$result = $this->TwitterBootstrap->button_form(
			"Link Text",
			"/home",
			array("size" => "small")
		);
		$this->assertTags($result, $expected);

		$expected['a']['class'] = 'preg:/btn danger/';
		$result = $this->TwitterBootstrap->button_form(
			"Link Text",
			"/home",
			array("style" => "danger")
		);
		$this->assertTags($result, $expected);

		$expected['a']['class'] = 'preg:/btn success large/';
		$result = $this->TwitterBootstrap->button_form(
			"Link Text",
			"/home",
			array("style" => "success", "size" => "large")
		);
		$this->assertTags($result, $expected);
	}

	/**
	 * testValidFlash 
	 * 
	 * @access public
	 * @return void
	 */
	public function testValidFlash() {
		$expected = array(
			'div' => array('class' => 'alert-message warning'),
			array('p' => true), 'Flash content', '/p',
			'/div'
		);

		$result = $this->TwitterBootstrap->flash();
		$this->assertTags($result, $expected);

		$result = $this->TwitterBootstrap->flash("flash");
		$this->assertTags($result, $expected);

		$result = $this->TwitterBootstrap->flash("warning");
		$this->assertTags($result, $expected);

		$expected['div']['class'] = 'alert-message info'; 
		$result = $this->TwitterBootstrap->flash("info");
		$this->assertTags($result, $expected);

		$expected['div']['class'] = 'alert-message success'; 
		$result = $this->TwitterBootstrap->flash("success");
		$this->assertTags($result, $expected);

		$expected['div']['class'] = 'alert-message error'; 
		$result = $this->TwitterBootstrap->flash("error");
		$this->assertTags($result, $expected);

		$expected['div']['class'] = 'alert-message error'; 
		$result = $this->TwitterBootstrap->flash("auth");
		$this->assertTags($result, $expected);
	}

	/**
	 * testClosableFlash 
	 * 
	 * @access public
	 * @return void
	 */
	public function testClosableFlash() {
		$expected = array(
			'div' => array('class' => 'alert-message warning'),
			'a' => array("href" => "#", "class" => "close"), 'preg:/x/', '/a',
			array('p' => true), 'Flash content', '/p',
			'/div'
		);

		$result = $this->TwitterBootstrap->flash("flash", array("closable" => true));
		$this->assertTags($result, $expected);

		$expected['div']['class'] = 'alert-message info'; 
		$result = $this->TwitterBootstrap->flash("info", array("closable" => true));
		$this->assertTags($result, $expected);
	}

	/**
	 * testInvalidFlash 
	 * 
	 * @access public
	 * @return void
	 */
	public function testInvalidFlash() {
		$expected = array(
			'div' => array('class' => 'alert-message warning invalid'),
			array('p' => true), 'Flash content', '/p',
			'/div'
		);

		$result = $this->TwitterBootstrap->flash("invalid");
		$this->assertTags($result, $expected);
	}

	/**
	 * testFlashes 
	 * 
	 * @access public
	 * @return void
	 */
	public function testFlashes() {
		$keys = array("info", "success", "error", "warning", "warning");
		$tmpl = '<div class="alert-message %s"><p>Flash content</p></div>';

		$expected = '';
		foreach ($keys as $key) {
			$expected .= sprintf($tmpl, $key);
		}
		$flashes = $this->TwitterBootstrap->flashes();
		$this->assertEquals($flashes, $expected);

		$keys[] = "error";
		$expected = '';
		foreach ($keys as $key) {
			$expected .= sprintf($tmpl, $key);
		}
		$flashes = $this->TwitterBootstrap->flashes(array("auth" => true));
		$this->assertEquals($flashes, $expected);
	}

	/**
	 * testValidBlock 
	 * 
	 * @access public
	 * @return void
	 */
	public function testValidBlock() {
		$expected = array(
			'div' => array('class' => 'alert-message block-message warning'),
			'Message content',
			'/div'
		);

		$result = $this->TwitterBootstrap->block("Message content");
		$this->assertTags($result, $expected);

		$expected['div']['class'] = 'alert-message block-message info';
		$result = $this->TwitterBootstrap->block(
			"Message content",
			array("style" => "info")
		);
		$this->assertTags($result, $expected);

		$expected['div']['class'] = 'alert-message block-message success';
		$result = $this->TwitterBootstrap->block(
			"Message content",
			array("style" => "success")
		);
		$this->assertTags($result, $expected);

		$expected['div']['class'] = 'alert-message block-message error';
		$result = $this->TwitterBootstrap->block(
			"Message content",
			array("style" => "error")
		);
		$this->assertTags($result, $expected);

		$expected['div']['class'] = 'alert-message block-message warning';
		$result = $this->TwitterBootstrap->block(
			"Message content",
			array("style" => "warning")
		);
		$this->assertTags($result, $expected);
	}

	/**
	 * testBlocksWithLinks 
	 * 
	 * @access public
	 * @return void
	 */
	public function testBlocksWithLinks() {
		$expected = '<div class="alert-message block-message warning">Message content<div class="alert-actions"><a href="#" class="btn small">Link Text</a></div></div>';
		$result = $this->TwitterBootstrap->block(
			"Message content",
			array("links" => array(
				$this->TwitterBootstrap->button_link("Link Text", "#", array("size" => "small"))
			))
		);
		$this->assertEquals($result, $expected);
	}

	/**
	 * testClosableBlock 
	 * 
	 * @access public
	 * @return void
	 */
	public function testClosableBlock() {
		$expected = '<div class="alert-message block-message info"><a href="#" class="close">x</a>Message content</div>';
		$result = $this->TwitterBootstrap->block(
			"Message content",
			array("closable" => true, "style" => "info")
		);
		$this->assertEquals($result, $expected);
	}

	/**
	 * testInputWithOnlyField 
	 * 
	 * @access public
	 * @return void
	 */
	public function testInputWithOnlyField() {
		$expected = array(
			array('div' => array("class" => "clearfix")),
			"label" => array("for" => "ContactName"), "Name", "/label",
			array("div" => array("class" => "input")),
			"input" => array(
				"name" => "data[Contact][name]", "maxlength" => 255, "type" => "text", "id" => "ContactName"
			),
			"/div",
			"/div"
		);
		$this->Form->create("Contact");
		$input = $this->TwitterBootstrap->input("name");
		$this->Form->end();
		$this->assertTags($input, $expected);
	}

	/**
	 * testInputWithOnlyFieldAndInput 
	 * 
	 * @access public
	 * @return void
	 */
	public function testInputWithOnlyFieldAndInput() {
		$expected = array(
			array('div' => array("class" => "clearfix")),
			"label" => array("for" => "ContactName"), "Name", "/label",
			array("div" => array("class" => "input")),
			"input" => array(
				"name" => "data[Contact][name]", "type" => "text", "id" => "ContactName"
			),
			"/div",
			"/div"
		);
		$this->Form->create("Contact");
		$input = $this->TwitterBootstrap->input("name", array(
			"input" => $this->Form->text("name")
		));
		$this->Form->end();
		$this->assertTags($input, $expected);
		$this->Form->create("Contact");
		$input = $this->TwitterBootstrap->input(array(
			"field" => "name",
			"input" => $this->Form->text("name")
		));
		$this->Form->end();
		$this->assertTags($input, $expected);
	}

	/**
	 * testInputWithDefinedLabel 
	 * 
	 * @access public
	 * @return void
	 */
	public function testInputWithDefinedLabel() {
		$expected = array(
			array("div" => array("class" => "clearfix")),
			"label" => array("for" => "ContactName"), "Contact Name", "/label",
			array("div" => array("class" => "input")),
			"input" => array(
				"name" => "data[Contact][name]", "maxlength" => 255, "type" => "text", "id" => "ContactName"
			),
			"/div",
			"/div"
		);
		$this->Form->create("Contact");
		$input = $this->TwitterBootstrap->input("name", array("label" => "Contact Name"));
		$this->Form->end();
		$this->assertTags($input, $expected);
	}

}
