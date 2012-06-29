<?php

App::uses('Controller', 'Controller');
App::uses('Helper', 'View');
App::uses('AppHelper', 'View/Helper');
App::uses('BootstrapFormHelper', 'TwitterBootstrap.View/Helper');
App::uses('HtmlHelper', 'View/Helper');
App::uses('FormHelper', 'View/Helper');
App::uses('ClassRegistry', 'Utility');
App::uses('Folder', 'Utility');

if (!defined('FULL_BASE_URL')) {
	define('FULL_BASE_URL', 'http://cakephp.org');
}

class TestBootstrapFormController extends Controller {

	public $name = 'TheTest';

	public $uses = null;
}

class Contact extends CakeTestModel {

	public $primaryKey = 'id';

	public $useTable = false;

	public $name = 'Contact';

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

class TestBootstrapFormHelper extends BootstrapFormHelper {

	public function parseAttributes($options, $exclude = null, $insertBefore = ' ', $insertAfter = null) {
		return $this->_parseAttributes($options, $exclude, $insertBefore, $insertAfter);
	}

	public function getAttribute($attribute) {
		if (!isset($this->{$attribute})) {
			return null;
		}
		return $this->{$attribute};
	}

	public function _flash_content($key) {
		return "Flash content";
	}
}

/**
 * HtmlHelperTest class
 *
 * @package       Cake.Test.Case.View.Helper
 */
class BootstrapFormHelperTest extends CakeTestCase {

	public $Html = null;

	public $validLabel = '<span class="label%s">Message</span>';

	public $validButton = '<button class="btn%s" type="submit">Submit</button>';

	public function setUp() {
		parent::setUp();
		$this->View = $this->getMock('View', array('addScript'), array(new TestBootstrapFormController()));

		$this->Bootstrap = new TestBootstrapFormHelper($this->View);
		$this->Bootstrap->Form = new FormHelper($this->View);
		$this->Bootstrap->request = new CakeRequest(null, false);
		$this->Bootstrap->request->webroot = '';

		$this->Form = &$this->Bootstrap->Form;
		$this->Form->Html = new HtmlHelper($this->View);
		$this->Form->request = new CakeRequest('contacts/add', false);
		$this->Form->request->here = '/contacts/add';
		$this->Form->request['action'] = 'add';
		$this->Form->request->webroot = '';
		$this->Form->request->base = '';

		ClassRegistry::addObject('Contact', new Contact());

		Configure::write('Asset.timestamp', false);
	}

	public function tearDown() {
		parent::tearDown();
		unset($this->Bootstrap, $this->View);
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
		$default = $this->Bootstrap->button("Submit");
		$this->assertEquals(sprintf($expected, ""), $default);
		// Primary button
		$primary = $this->Bootstrap->button("Submit", array("style" => "primary"));
		$this->assertEquals(sprintf($expected, " btn-primary"), $primary);
		// Info button
		$info = $this->Bootstrap->button("Submit", array("style" => "info"));
		$this->assertEquals(sprintf($expected, " btn-info"), $info);
		// Success button
		$success = $this->Bootstrap->button("Submit", array("style" => "success"));
		$this->assertEquals(sprintf($expected, " btn-success"), $success);
		// Warning button
		$success = $this->Bootstrap->button("Submit", array("style" => "warning"));
		$this->assertEquals(sprintf($expected, " btn-warning"), $success);
		// Danger button
		$danger = $this->Bootstrap->button("Submit", array("style" => "danger"));
		$this->assertEquals(sprintf($expected, " btn-danger"), $danger);
		// Inverse button
		$danger = $this->Bootstrap->button("Submit", array("style" => "inverse"));
		$this->assertEquals(sprintf($expected, " btn-inverse"), $danger);
	}

	/**
	 * testValidButtonSizes
	 *
	 * @access public
	 * @return void
	 */
	public function testValidButtonSizes() {
		$expected = $this->validButton;
		// Mini button
		$mini = $this->Bootstrap->button("Submit", array("size" => "mini"));
		$this->assertEquals(sprintf($expected, " btn-mini"), $mini);
		// Small button
		$small = $this->Bootstrap->button("Submit", array("size" => "small"));
		$this->assertEquals(sprintf($expected, " btn-small"), $small);
		// Large button
		$large = $this->Bootstrap->button("Submit", array("size" => "large"));
		$this->assertEquals(sprintf($expected, " btn-large"), $large);
		// Mixed button
		$mixed = $this->Bootstrap->button(
			"Submit",
			array("style" => "primary", "size" => "small")
		);
		$this->assertEquals(sprintf($expected, " btn-primary btn-small"), $mixed);
	}

	/**
	 * testValidDisabledButton
	 *
	 * @access public
	 * @return void
	 */
	public function testValidDisabledButton() {
		$expected = $this->validButton;
		$disabled = $this->Bootstrap->button("Submit", array("disabled" => true));
		$this->assertEquals(sprintf($expected, " btn-disabled"), $disabled);
	}

	/**
	 * testInvalidButtonStylesAndSizes
	 *
	 * @access public
	 * @return void
	 */
	public function testInvalidButtonStylesAndSizes() {
		$expected = $this->validButton;
		// Invalid size button
		$invalid_size = $this->Bootstrap->button("Submit", array("size" => "invalid"));
		$this->assertEquals(sprintf($expected, ""), $invalid_size);
		// Invalid style button
		$invalid_style = $this->Bootstrap->button("Submit", array("style" => "invalid"));
		$this->assertEquals(sprintf($expected, ""), $invalid_style);
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
				'href' => '#',
				'onclick' => 'preg:/document\.(.)+\.submit\(\); event\.returnValue = false; return false;/',
				'class' => 'preg:/btn/'
			),
			'Link Text',
			'/a'
		);

		$result = $this->Bootstrap->button_form("Link Text", "/home");
		$this->assertTags($result, $expected);

		$expected['a']['class'] = 'preg:/btn btn-small/';
		$result = $this->Bootstrap->button_form(
			"Link Text",
			"/home",
			array("size" => "small")
		);
		$this->assertTags($result, $expected);

		$expected['a']['class'] = 'preg:/btn btn-danger/';
		$result = $this->Bootstrap->button_form(
			"Link Text",
			"/home",
			array("style" => "danger")
		);
		$this->assertTags($result, $expected);

		$expected['a']['class'] = 'preg:/btn btn-success btn-large/';
		$result = $this->Bootstrap->button_form(
			"Link Text",
			"/home",
			array("style" => "success", "size" => "large")
		);
		$this->assertTags($result, $expected);
	}

	/**
	 * testInputWithOnlyField
	 *
	 * @access public
	 * @return void
	 */
	public function testInputWithOnlyField() {
		$expected = array(
			array('div' => array("class" => "control-group")),
			"label" => array("for" => "ContactName", "class" => "control-label"), "Name", "/label",
			array("div" => array("class" => "controls")),
			"input" => array(
				"name" => "data[Contact][name]", "maxlength" => 255, "type" => "text", "id" => "ContactName"
			),
			"/div",
			"/div"
		);
		$this->Form->create("Contact");
		$input = $this->Bootstrap->input("name");
		$this->Form->end();
		$this->assertTags($input, $expected);
	}

	/**
	 * testInputWithInputClassDefined
	 *
	 * @access public
	 * @return void
	 */
	public function testInputWithInputClassDefined() {
		$expected = array(
			array('div' => array("class" => "control-group")),
			"label" => array("for" => "ContactName", "class" => "control-label"), "Name", "/label",
			array("div" => array("class" => "controls")),
			"input" => array(
				"name" => "data[Contact][name]",
				"maxlength" => 255,
				"type" => "text",
				"id" => "ContactName",
				"class" => "custom-class"
			),
			"/div",
			"/div"
		);
		$this->Form->create("Contact");
		$input = $this->Bootstrap->input("name", array("class" => "custom-class"));
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
			array('div' => array("class" => "control-group")),
			"label" => array("for" => "ContactName", "class" => "control-label"), "Name", "/label",
			array("div" => array("class" => "controls")),
			"input" => array(
				"name" => "data[Contact][name]", "type" => "text", "id" => "ContactName"
			),
			"/div",
			"/div"
		);
		$this->Form->create("Contact");
		$input = $this->Bootstrap->input("name", array(
			"input" => $this->Form->text("name")
		));
		$this->Form->end();
		$this->assertTags($input, $expected);
		$this->Form->create("Contact");
		$input = $this->Bootstrap->input(array(
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
			array("div" => array("class" => "control-group")),
			"label" => array("for" => "ContactName", "class" => "control-label"), "Contact Name", "/label",
			array("div" => array("class" => "controls")),
			"input" => array(
				"name" => "data[Contact][name]", "maxlength" => 255, "type" => "text", "id" => "ContactName"
			),
			"/div",
			"/div"
		);
		$this->Form->create("Contact");
		$input = $this->Bootstrap->input("name", array("label" => "Contact Name"));
		$this->Form->end();
		$this->assertTags($input, $expected);
	}

	/**
	 * testInputWithAppendAddon
	 *
	 * @access public
	 * @return void
	 */
	public function testInputWithAppendAddon() {
		$expected = array(
			array("div" => array("class" => "control-group")),
			"label" => array("for" => "ContactName", "class" => "control-label"), "Name", "/label",
			array("div" => array("class" => "controls")),
			array("div" => array("class" => "input-append")),
			"input" => array(
				"name" => "data[Contact][name]", "maxlength" => 255, "type" => "text", "id" => "ContactName"
			),
			"span" => array("class" => "add-on"), "A", "/span",
			"/div",
			"/div",
			"/div"
		);
		$this->Form->create("Contact");
		$input = $this->Bootstrap->input("name", array("append" => "A"));
		$this->Form->end();
		$this->assertTags($input, $expected);
	}

	/**
	 * testInputWithAppendButtonAddon
	 *
	 * @access public
	 * @return void
	 */
	public function testInputWithAppendButtonAddon() {
		$expected = array(
			array("div" => array("class" => "control-group")),
			"label" => array("for" => "ContactName", "class" => "control-label"), "Name", "/label",
			array("div" => array("class" => "controls")),
			array("div" => array("class" => "input-append")),
			"input" => array(
				"name" => "data[Contact][name]", "maxlength" => 255, "type" => "text", "id" => "ContactName"
			),
			"button" => array("class" => "btn", "type" => "button"), "Go", "/button",
			"/div",
			"/div",
			"/div"
		);
		$this->Form->create("Contact");
		$input = $this->Bootstrap->input("name", array(
			"append" => $this->Bootstrap->button("Go", array("type" => "button"))
		));
		$this->Form->end();
		$this->assertTags($input, $expected);
	}

	/**
	 * testInputWithAppendInputAddon
	 *
	 * @access public
	 * @return void
	 */
	public function testInputWithAppendInputAddon() {
		$expected = array(
			array("div" => array("class" => "control-group")),
			array("label" => array("for" => "ContactName", "class" => "control-label")),
				"Name",
			"/label",
			array("div" => array("class" => "controls")),
			array("div" => array("class" => "input-append")),
			array("input" => array(
				"name" => "data[Contact][name]",
				"maxlength" => 255,
				"type" => "text",
				"id" => "ContactName"
			)),
			array("label" => array("class" => "add-on")),
				array("input" => array(
					"type" => "checkbox",
					"name" => "data[Contact][confirm]",
					"value" => "1",
					"id" => "ContactConfirm"
				)),
			"/label",
			"/div",
			"/div",
			"/div"
		);
		$this->Form->create("Contact");
		$input = $this->Bootstrap->input("name", array(
			"append" => $this->Form->checkbox("confirm", array("hiddenField" => false))
		));
		$this->Form->end();
		$this->assertTags($input, $expected);
	}

	/**
	 * testInputWithPrependAddon
	 *
	 * @access public
	 * @return void
	 */
	public function testInputWithPrependAddon() {
		$expected = array(
			array("div" => array("class" => "control-group")),
			"label" => array("for" => "ContactName", "class" => "control-label"), "Name", "/label",
			array("div" => array("class" => "controls")),
			array("div" => array("class" => "input-prepend")),
			"span" => array("class" => "add-on"), "P", "/span",
			"input" => array(
				"name" => "data[Contact][name]", "maxlength" => 255, "type" => "text", "id" => "ContactName"
			),
			"/div",
			"/div",
			"/div"
		);
		$this->Form->create("Contact");
		$input = $this->Bootstrap->input("name", array("prepend" => "P"));
		$this->Form->end();
		$this->assertTags($input, $expected);
	}

	/**
	 * testInputWithAppendInputAddon
	 *
	 * @access public
	 * @return void
	 */
	public function testInputWithPrependButtonAddon() {
		$expected = array(
			array("div" => array("class" => "control-group")),
			"label" => array("for" => "ContactName", "class" => "control-label"), "Name", "/label",
			array("div" => array("class" => "controls")),
			array("div" => array("class" => "input-prepend")),
			"button" => array("class" => "btn", "type" => "button"), "Go", "/button",
			"input" => array(
				"name" => "data[Contact][name]", "maxlength" => 255, "type" => "text", "id" => "ContactName"
			),
			"/div",
			"/div",
			"/div"
		);
		$this->Form->create("Contact");
		$input = $this->Bootstrap->input("name", array(
			"prepend" => $this->Bootstrap->button("Go", array("type" => "button"))
		));
		$this->Form->end();
		$this->assertTags($input, $expected);
	}

	/**
	 * testInputWithPrependInputAddon
	 *
	 * @access public
	 * @return void
	 */
	public function testInputWithPrependInputAddon() {
		$expected = array(
			array("div" => array("class" => "control-group")),
			array("label" => array("for" => "ContactName", "class" => "control-label")),
				"Name",
			"/label",
			array("div" => array("class" => "controls")),
			array("div" => array("class" => "input-prepend")),
			array("label" => array("class" => "add-on")),
				array("input" => array(
					"type" => "checkbox",
					"name" => "data[Contact][confirm]",
					"value" => "1",
					"id" => "ContactConfirm"
				)),
			"/label",
			array("input" => array(
				"name" => "data[Contact][name]",
				"maxlength" => 255,
				"type" => "text",
				"id" => "ContactName"
			)),
			"/div",
			"/div",
			"/div"
		);
		$this->Form->create("Contact");
		$input = $this->Bootstrap->input("name", array(
			"prepend" => $this->Form->checkbox("confirm", array("hiddenField" => false))
		));
		$this->Form->end();
		$this->assertTags($input, $expected);
	}

	/**
	 * testInputWithBothAppendAndPrepend
	 *
	 * @access public
	 * @return void
	 */
	public function testInputWithBothAppendAndPrepend() {
		$expected = array(
			array("div" => array("class" => "control-group")),
			"label" => array("for" => "ContactName", "class" => "control-label"), "Name", "/label",
			array("div" => array("class" => "controls")),
			array("div" => array("class" => "input-append input-prepend")),
			array("span" => array("class" => "add-on")), "P", "/span",
			"input" => array(
				"name" => "data[Contact][name]", "maxlength" => 255, "type" => "text", "id" => "ContactName"
			),
			array("span" => array("class" => "add-on")), "A", "/span",
			"/div",
			"/div",
			"/div"
		);
		$this->Form->create("Contact");
		$input = $this->Bootstrap->input("name", array(
			"prepend" => "P",
			"append" => "A"
		));
		$this->Form->end();
		$this->assertTags($input, $expected);
	}
}
