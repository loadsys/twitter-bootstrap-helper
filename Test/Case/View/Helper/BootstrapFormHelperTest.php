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
		unset($this->BootstrapForm, $this->View);
	}

	/**
	 * test cases for BootstrapForm->create function
	 * @return void
	 */
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

	/**
	 * test cases for BootstrapForm->validButtonStyles function
	 * @return void
	 */
	public function testValidButtonStyles() {
		$expected = array(
			'button' => array('class' => 'btn', 'type' => 'submit'),
			'Submit',
			'/button'
		);
		$default = $this->BootstrapForm->button("Submit");
		$this->assertTags($default, $expected);
		$primary = $this->BootstrapForm->button("Submit", array("style" => "primary"));
		$expected['button']['class'] = 'btn btn-primary';
		$this->assertTags($primary, $expected);
	}

	/**
	 * test cases for BootstrapForm->validButtonSizes function
	 * @return void
	 */
	public function testValidButtonSizes() {
		$expected = array(
			'button' => array('class' => 'btn btn-mini', 'type' => 'submit'),
			'Submit',
			'/button'
		);
		$mini = $this->BootstrapForm->button("Submit", array("size" => "mini"));
		$this->assertTags($mini, $expected);
	}

	/**
	 * test cases for BootstrapForm->validButtonStylesAndSizes function
	 * @return void
	 */
	public function testValidButtonStylesAndSizes() {
		$expected = array(
			'button' => array('class' => 'btn btn-small btn-primary', 'type' => 'submit'),
			'Submit',
			'/button'
		);
		$mixed = $this->BootstrapForm->button(
			"Submit",
			array("style" => "primary", "size" => "small")
		);
		$this->assertTags($mixed, $expected);
	}

	/**
	 * test cases for BootstrapForm->validDisabledButton function
	 * @return void
	 */
	public function testValidDisabledButton() {
		$expected = array(
			'button' => array('class' => 'btn disabled', 'type' => 'submit'),
			'Submit',
			'/button'
		);
		$disabled = $this->BootstrapForm->button("Submit", array("disabled" => true));
		$this->assertTags($disabled, $expected);
	}

	/**
	 * test cases for BootstrapForm->invalidButtonStylesAndSizes function
	 * @return void
	 */
	public function testInvalidButtonStylesAndSizes() {
		$expected = array(
			'button' => array('class' => 'btn', 'type' => 'submit'),
			'Submit',
			'/button'
		);
		$invalid_size = $this->BootstrapForm->button("Submit", array("size" => "invalid"));
		$this->assertTags($invalid_size, $expected);
		$invalid_style = $this->BootstrapForm->button("Submit", array("style" => "invalid"));
		$this->assertTags($invalid_style, $expected);
	}

	/**
	 * test cases for BootstrapForm->validButtonForm function
	 * @return void
	 */
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

		$expected['button']['class'] = 'preg:/btn btn-large btn-success/';
		$result = $this->BootstrapForm->postButton(
			"Link Text",
			"/home",
			array("style" => "success", "size" => "large")
		);
		$this->assertTags($result, $expected);
	}

	/**
	 * test cases for BootstrapForm->validSubmit
	 * @return void
	 */
	public function testValidSubmit() {
		$expected = array(
			"div" => array("class" => "submit"),
			"input" => array("type" => "submit", "value" => "Submit", "class" => "btn"),
			"/div"
		);
		$default = $this->BootstrapForm->submit("Submit");
		$this->assertTags($default, $expected);
		$primary = $this->BootstrapForm->submit("Submit", array("style" => "primary"));
		$expected["input"]["class"] = "btn btn-primary";
		$this->assertTags($primary, $expected);
		$mini = $this->BootstrapForm->submit("Submit", array("size" => "mini"));
		$expected["input"]["class"] = "btn btn-mini";
		$this->assertTags($mini, $expected);
		$expected["input"]["class"] = "btn btn-small btn-primary";
		$mixed = $this->BootstrapForm->submit(
			"Submit",
			array("style" => "primary", "size" => "small")
		);
		$this->assertTags($mixed, $expected);
	}

	/**
	 * test the BootstrapForm->button call
	 * @return void
	 */
	public function testButton() {
		$expected = array(
			'button' => array('class' => 'preg:/btn/'),
				'Title',
			'/button',
		);
		// Default Button
		$button = $this->BootstrapForm->button('Title');
		$this->assertTags($button, $expected);

		$expected['button']['data-test-value'] = 'test';
		$attrbuted = $this->BootstrapForm->button('Title', array('data-test-value' => 'test'));
		$this->assertTags($attrbuted, $expected);
	}

	/**
	 * test the BoostrapForm->checkbox call
	 * @return void
	 */
	public function testCheckbox() {
		$expected = array(
			'label' => array('class' => 'checbox'),
			'input' => array('type' => 'checkbox'),
			'/input',
			'Form Label',
			'/label',
		);

		$checkbox = $this->BootstrapForm->checkbox('NoModel.form_label');
		$this->assertTags($checkbox, $expected);

		$expected['input']['data-test-value'] = 'test';
		$attrbuted = $this->BootstrapForm->checkbox('NoModel.form_label', array('data-test-value' => 'test'));
		$this->assertTags($attrbuted, $expected);
	}

	/**
	 * test cases for BootstrapForm->dateTime
	 * @return void
	 */
	public function testDateTime() {
		$expected = array(

		);
	}

	/**
	 * test cases for BootstrapForm->day
	 * @return void
	 */
	public function testDay() {
		$expected = array(
			'input' => array('type' => 'select'),
				'option' => array(),
			'/input'
		);

		$day = $this->BootstrapForm->day('NoModel.day');
		$this->assertTags($day, $expected);
	}

	/**
	 * test cases for BootstrapForm->end
	 * @return void
	 */
	public function testEnd() {
		$expected = array(
		);
	}

	/**
	 * test cases for BootstrapForm->error
	 * @return void
	 */
	public function testError() {
		$expected = array(
		);
	}

	/**
	 * test cases for BootstrapForm->file
	 * @return void
	 */
	public function testFile() {
		$expected = array(
			'label' => array('class' => 'file'),
			'input' => array('type' => 'file'),
			'Form Label',
			'/label',
		);
	}

	/**
	 * test cases for BootstrapForm->hidden
	 * @return void
	 */
	public function testHidden() {
		$expected = array(
			'input' => array('type' => 'hidden'),
		);

		$hidden = $this->BootstrapForm->hidden('NoModel.id');
		$this->assertTags($hidden, $expected);

		$expected['input']['data-test-value'] = 'test';
		$attrbuted = $this->BootstrapForm->hidden('NoModel.id', array('data-test-value' => 'test'));
		$this->assertTags($attrbuted, $expected);

	}

	/**
	 * test cases for BootstrapForm->hour
	 * @return void
	 */
	public function testHour() {
		$expected = array(
			'input' => array('type' => 'select'),
			'/input'
		);

		$hour = $this->BootstrapForm->hour('NoModel.hour');
		$this->assertTags($hour, $expected);
	}

	/**
	 * test cases for BootstrapForm->input
	 * @return void
	 */
	public function testInput() {
		$expectedTextInput = array(
			'label' => array(),
			'Label Name',
			'/label',
			'input' => array('type' => 'text'),
		);

		$text = $this->BootstrapForm->input('Contact.name');
		$this->assertTags($text, $expectedTextInput);

		$expectedEmailInput = array(
			'label' => array(),
			'Label Name',
			'/label',
			'input' => array('type' => 'email'),
		);

		$email = $this->BootstrapForm->input('Contact.email');
		$this->assertTags($email, $expectedEmailInput);


	}

	/**
	 * test cases for BootstrapForm->inputs
	 * @return void
	 */
	public function testInputs() {
		$expected = array(
		);
	}

	/**
	 * test cases for BootstrapForm->isFieldError
	 * @return void
	 */
	public function testIsFieldError() {
		$expected = array(
		);
	}

	/**
	 * test cases for BootstrapForm->label
	 * @return void
	 */
	public function testLabel() {
		$expected = array(
			'label' => array('for' => 'NoModelLabelText'),
			'Label Text',
			'/label',
		);

		$label = $this->BootstrapForm->label('NoModel.label_text');
		$this->assertTags($label, $expected);

		$expected['Label Text'] = 'Custom Text';
		$customText = $this->BootstrapForm->label('NoModel.label_text', 'Custom Text');
		$this->assertTags($customText, $expected);

		$expected['label']['data-test-value'] = 'test';
		$attributed = $this->BootstrapForm->label(
			'NoModel.label_text',
			'Custom Text',
			array('data-test-value' => 'test')
		);
		$this->assertTags($attributed, $expected);
	}

	/**
	 * test cases for BootstrapForm->meridan
	 * @return void
	 */
	public function testMeridan() {
		$expected = array(
			'input' => array('type' => 'select'),
				'option' => array(''),
				'/option',
			'/input',
		);

		$meridan = $this->BootstrapForm->meridan('NoModel.meridan');
		$this->assertTags($meridan, $expected);
	}

	/**
	 * test cases for BootstrapForm->minute
	 * @return void
	 */
	public function testMinute() {
		$expected = array(
			'input' => array('type' => 'select'),
				'option' => array(''),
				'/option',
			'/input',
		);

		$minute = $this->BootstrapForm->minute('NoModel.minute');
		$this->assertTags($minute, $expected);
	}

	/**
	 * test cases for BootstrapForm->month
	 * @return void
	 */
	public function testMonth() {
		$expected = array(
			'input' => array('type' => 'select'),
				'option' => array(''),
				'/option',
			'/input',
		);

		$month = $this->BootstrapForm->month('NoModel.month');
		$this->assertTags($month, $expected);
	}

	/**
	 * test cases for BootstrapForm->postButton
	 * @return void
	 */
	public function testPostButton() {
		$expected = array(
		);
	}

	/**
	 * test cases for BootstrapForm->postLink
	 * @return void
	 */
	public function testPostLink() {
		$expected = array(
		);
	}

	/**
	 * test cases for BootstrapForm->radio
	 * @return void
	 */
	public function testRadio() {
		$expected = array(
			'label' => array('class' => 'preg:/radio/'),
			'input' => array('type' => 'radio', 'name' => "NoModelRadioOption", 'value' => 'option1'),
			'/label',
		);

		$radio = $this->BootstrapForm->radio('NoModel.radio_option', array('option1'));
		$this->assertTags($radio, $expected);
	}

	/**
	 * test cases for BootstrapForm->secure
	 * @return void
	 */
	public function testSecure() {
		$expected = array(
			'input' => array('type' => 'hidden'),
		);
	}

	/**
	 * test cases for BootstrapForm->select
	 * @return void
	 */
	public function testSelect() {
		$expected = array(
			'select' => array(),
				'option' => array('value' => 1),
					'test',
				'/option',
			'/select',
		);

		$select = $this->BootstrapForm->select('NoModel.select', array(1 => 'test'));
		$this->assertTags($select, $expected);
	}

	/**
	 * test cases for BootstrapForm->submit
	 * @return void
	 */
	public function testSubmit() {
		$expected = array(
			'button' => array('type' => 'submit', 'class' => 'preg:/btn/'),
			'Submit',
			'/button',
		);

		$submit = $this->BootstrapForm->submit('Submit');
		$this->assertTags($submit, $expected);

		$expected['button']['type'] = 'reset';
		$resetButton = $this->BootstrapForm->submit('Submit', array('type' => 'reset'));
		$this->assertTags($resetButton, $expected);
	}

	/**
	 * test cases for BootstrapForm->tagsInvalid
	 * @return void
	 */
	public function testTagsInvaild() {
		$expected = array(
		);
	}

	/**
	 * test cases for BootstrapForm->textarea
	 * @return void
	 */
	public function testTextarea() {
		$expected = array(
			'textarea' => array(),
			'/textarea',
		);

		$textarea = $this->BootstrapForm->textarea('NoModel.textarea');
		$this->assertTags($textarea, $expected);

		$expected['textarea']['data-test-value'] = 'test';
		$options = $this->BootstrapForm->textarea('NoModel.textarea', array('data-test-value' => 'test'));
		$thsi->assertTags($options, $expected);
	}

	/**
	 * test cases for BootstrapForm->unlockField
	 * @return void
	 */
	public function testUnlockField() {
		$expected = array(
		);
	}

	/**
	 * test cases for BootstrapForm->year function
	 * @return void
	 */
	public function testYear() {
		$expected = array(
			'input' => array('type' => 'select'),
				'option' => array(''),
				'/option',
			'/input',
		);

		$year = $this->BootstrapForm->year('NoModel.year');
		$this->assertTags($year, $expected);

		$minYear = $this->BootstrapForm->year('NoModel.year', 2000);
		$this->assertTags($minYear, $expected);

		$maxYear = $this->BootstrapForm->year('NoModel.year', null, 2030);
		$this->assertTags($maxYear, $expected);

		$attributed = $this->BootstrapForm->year('NoModel.year', null, null, array());
		$this->assertTags($attributed, $expected);
	}

}
