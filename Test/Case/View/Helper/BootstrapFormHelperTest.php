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

	public function testCreate() {
		$expected = array(
			"form" => array(
				"action" => "/contacts/add",
				"id" => "ContactAddForm",
				"method" => "post",
				"accept-charset" => "utf-8"
			),
			"div" => array("style" => "display:none;"),
			"input" => array("type" => "hidden", "name" => "_method", "value" => "POST"),
			"/div"
		);
		$form = $this->BootstrapForm->create("Contact");
		$this->assertTags($form, $expected);

		$expected["form"]["class"] = "form-vertical";
		$form = $this->BootstrapForm->create("Contact", array("formType" => "vertical"));
		$this->assertTags($form, $expected);

		$expected["form"]["class"] = "some-class form-vertical";
		$form = $this->BootstrapForm->create("Contact", array(
			"class"    => "some-class",
			"formType" => "vertical"
		));
		$this->assertTags($form, $expected);

		$expected["form"]["class"] = "form-inline";
		$form = $this->BootstrapForm->create("Contact", array("formType" => "inline"));
		$this->assertTags($form, $expected);

		$expected["form"]["class"] = "form-search";
		$form = $this->BootstrapForm->create("Contact", array("formType" => "search"));
		$this->assertTags($form, $expected);

		$expected["form"]["class"] = "form-horizontal";
		$form = $this->BootstrapForm->create("Contact", array("formType" => "horizontal"));
		$this->assertTags($form, $expected);
	}

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

	public function testValidDisabledButton() {
		$expected = $this->validButton;
		$disabled = $this->BootstrapForm->button("Submit", array("disabled" => true));
		$this->assertEquals(sprintf($expected, " disabled"), $disabled);
	}

	public function testInvalidButtonStylesAndSizes() {
		$expected = $this->validButton;
		// Invalid size button
		$invalid_size = $this->BootstrapForm->button("Submit", array("size" => "invalid"));
		$this->assertEquals(sprintf($expected, ""), $invalid_size);
		// Invalid style button
		$invalid_style = $this->BootstrapForm->button("Submit", array("style" => "invalid"));
		$this->assertEquals(sprintf($expected, ""), $invalid_style);
	}

	public function testValidButtonForm() {
		$expected = array(
			'form' => array(
				'method' => 'post',
				'action' => "/home",
				'style' => 'display:none;',
				'accept-charset' => 'utf-8'
			),
			'div' => array("style" => "display:none;"),
			'input' => array('type' => 'hidden', 'name' => '_method', 'value' => 'POST'),
			"/div",
			'button' => array('class' => 'preg:/btn/', 'type' => 'submit'),
			'Link Text',
			'/button',
			'/form'
		);

		$result = $this->BootstrapForm->postButton("Link Text", "/home");
		$this->assertTags($result, $expected);

		$expected['button']['class'] = 'preg:/btn btn-small/';
		$result = $this->BootstrapForm->postButton(
			"Link Text",
			"/home",
			array("size" => "small")
		);
		$this->assertTags($result, $expected);

		$expected['button']['class'] = 'preg:/btn btn-danger/';
		$result = $this->BootstrapForm->postButton(
			"Link Text",
			"/home",
			array("style" => "danger")
		);
		$this->assertTags($result, $expected);

		$expected['button']['class'] = 'preg:/btn btn-success btn-large/';
		$result = $this->BootstrapForm->postButton(
			"Link Text",
			"/home",
			array("style" => "success", "size" => "large")
		);
		$this->assertTags($result, $expected);
	}

}
