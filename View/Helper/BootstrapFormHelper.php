<?php

App::uses("FormHelper", "View/Helper");
require_once(dirname(__FILE__) . '/../../Lib/BootstrapInfo.php');

class BootstrapFormHelper extends FormHelper {

	/**
	 * Options used internally. Don't send any of these options along to FormHelper
	 *
	 * @var array
	 * @access private
	 */
	private $__dontSendToFormHelper = array(
		'help_inline',
		'help_block',
		'label',
		'div',
		'error',
		'checkbox_label',
		'append',
		'prepend',
		'field'
	);

	public function __construct(View $View, $options = array()) {
		parent::__construct($View, $options);
		$this->BootstrapInfo = new BootstrapInfo();
	}

	/**
	 * Wrapping create to allow formType option.
	 *
	 * @access public
	 * @param mixed $model
	 * @param array $opt
	 * @return string
	 */
	public function create($model = null, $opt = array()) {
		$valid = array("vertical", "inline", "search", "horizontal");
		$klass = null;
		if (isset($opt["formType"]) && in_array($opt["formType"], $valid)) {
			$klass = "form-{$opt["formType"]}";
			unset($opt["formType"]);
		}
		if ($klass) {
			$opt["class"] = isset($opt["class"]) ? $opt["class"] . " {$klass}" : $klass;
		}
		return parent::create($model, $opt);
	}

	public function input($fieldName, $opt = array()) {
		return parent::input($fieldName, $opt);
	}

	/**
	 * Wraps the form button method and just applies the Bootstrap classes to
	 * the button before passing the options on to the FormHelper button method.
	 *
	 * @param string $title
	 * @param array $options
	 * @access public
	 * @return string
	 */
	public function button($title, $options = array()) {
		$options = $this->BootstrapInfo->button($options);
		return parent::button($title, $options);
	}

	/**
	 * Passing submit options through _buttonOptions before passing along
	 * to parent::submit()
	 *
	 * @access public
	 * @param mixed $caption
	 * @param array $options
	 * @return string
	 */
	public function submit($caption = null, $options = array()) {
		$options = $this->BootstrapInfo->button($options);
		return parent::submit($caption, $options);
	}

}
