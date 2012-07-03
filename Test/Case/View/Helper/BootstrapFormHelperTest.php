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
}

/**
 * HtmlHelperTest class
 *
 * @package       Cake.Test.Case.View.Helper
 */
class BootstrapFormHelperTest extends CakeTestCase {

	public $BootstrapForm;
	public $View;

	public $validLabel = '<span class="label%s">Message</span>';

	public $validButton = '<button class="btn%s" type="submit">Submit</button>';

	public function setUp() {
		parent::setUp();
		$this->View = $this->getMock('View', array('addScript'), array(new TestBootstrapFormController()));

		$this->BootstrapForm = new TestBootstrapFormHelper($this->View);
		$this->BootstrapForm->request = new CakeRequest('contacts/add', false);
		$this->BootstrapForm->request->here = '/contacts/add';
		$this->BootstrapForm->request['action'] = 'add';
		$this->BootstrapForm->request->webroot = '';
		$this->BootstrapForm->request->base = '';

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
		$default = $this->BootstrapForm->button("Submit");
		$this->assertEquals(sprintf($expected, ""), $default);
		// Primary button
		$primary = $this->BootstrapForm->button("Submit", array("style" => "primary"));
		$this->assertEquals(sprintf($expected, " btn-primary"), $primary);
		// Info button
		$info = $this->BootstrapForm->button("Submit", array("style" => "info"));
		$this->assertEquals(sprintf($expected, " btn-info"), $info);
		// Success button
		$success = $this->BootstrapForm->button("Submit", array("style" => "success"));
		$this->assertEquals(sprintf($expected, " btn-success"), $success);
		// Warning button
		$success = $this->BootstrapForm->button("Submit", array("style" => "warning"));
		$this->assertEquals(sprintf($expected, " btn-warning"), $success);
		// Danger button
		$danger = $this->BootstrapForm->button("Submit", array("style" => "danger"));
		$this->assertEquals(sprintf($expected, " btn-danger"), $danger);
		// Inverse button
		$danger = $this->BootstrapForm->button("Submit", array("style" => "inverse"));
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
		$mini = $this->BootstrapForm->button("Submit", array("size" => "mini"));
		$this->assertEquals(sprintf($expected, " btn-mini"), $mini);
		// Small button
		$small = $this->BootstrapForm->button("Submit", array("size" => "small"));
		$this->assertEquals(sprintf($expected, " btn-small"), $small);
		// Large button
		$large = $this->BootstrapForm->button("Submit", array("size" => "large"));
		$this->assertEquals(sprintf($expected, " btn-large"), $large);
		// Mixed button
		$mixed = $this->BootstrapForm->button(
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
		$disabled = $this->BootstrapForm->button("Submit", array("disabled" => true));
		$this->assertEquals(sprintf($expected, " disabled"), $disabled);
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
		$invalid_size = $this->BootstrapForm->button("Submit", array("size" => "invalid"));
		$this->assertEquals(sprintf($expected, ""), $invalid_size);
		// Invalid style button
		$invalid_style = $this->BootstrapForm->button("Submit", array("style" => "invalid"));
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

		$result = $this->BootstrapForm->buttonForm("Link Text", "/home");
		$this->assertTags($result, $expected);

		$expected['a']['class'] = 'preg:/btn btn-small/';
		$result = $this->BootstrapForm->buttonForm(
			"Link Text",
			"/home",
			array("size" => "small")
		);
		$this->assertTags($result, $expected);

		$expected['a']['class'] = 'preg:/btn btn-danger/';
		$result = $this->BootstrapForm->buttonForm(
			"Link Text",
			"/home",
			array("style" => "danger")
		);
		$this->assertTags($result, $expected);

		$expected['a']['class'] = 'preg:/btn btn-success btn-large/';
		$result = $this->BootstrapForm->buttonForm(
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
		$this->BootstrapForm->create("Contact");
		$input = $this->BootstrapForm->input("name");
		$this->BootstrapForm->end();
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
		$this->BootstrapForm->create("Contact");
		$input = $this->BootstrapForm->input("name", array("class" => "custom-class"));
		$this->BootstrapForm->end();
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
		$this->BootstrapForm->create("Contact");
		$input = $this->BootstrapForm->input("name", array(
			"input" => $this->BootstrapForm->text("name")
		));
		$this->BootstrapForm->end();
		$this->assertTags($input, $expected);
		$this->BootstrapForm->create("Contact");
		$input = $this->BootstrapForm->input(array(
			"field" => "name",
			"input" => $this->BootstrapForm->text("name")
		));
		$this->BootstrapForm->end();
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
		$this->BootstrapForm->create("Contact");
		$input = $this->BootstrapForm->input("name", array("label" => "Contact Name"));
		$this->BootstrapForm->end();
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
		$this->BootstrapForm->create("Contact");
		$input = $this->BootstrapForm->input("name", array("append" => "A"));
		$this->BootstrapForm->end();
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
		$this->BootstrapForm->create("Contact");
		$input = $this->BootstrapForm->input("name", array(
			"append" => $this->BootstrapForm->button("Go", array("type" => "button"))
		));
		$this->BootstrapForm->end();
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
		$this->BootstrapForm->create("Contact");
		$input = $this->BootstrapForm->input("name", array(
			"append" => $this->BootstrapForm->checkbox("confirm", array("hiddenField" => false))
		));
		$this->BootstrapForm->end();
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
		$this->BootstrapForm->create("Contact");
		$input = $this->BootstrapForm->input("name", array("prepend" => "P"));
		$this->BootstrapForm->end();
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
		$this->BootstrapForm->create("Contact");
		$input = $this->BootstrapForm->input("name", array(
			"prepend" => $this->BootstrapForm->button("Go", array("type" => "button"))
		));
		$this->BootstrapForm->end();
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
		$this->BootstrapForm->create("Contact");
		$input = $this->BootstrapForm->input("name", array(
			"prepend" => $this->BootstrapForm->checkbox("confirm", array("hiddenField" => false))
		));
		$this->BootstrapForm->end();
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
		$this->BootstrapForm->create("Contact");
		$input = $this->BootstrapForm->input("name", array(
			"prepend" => "P",
			"append" => "A"
		));
		$this->BootstrapForm->end();
		$this->assertTags($input, $expected);
	}
}
