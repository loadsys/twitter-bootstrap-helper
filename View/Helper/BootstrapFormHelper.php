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

	public function checkbox($fieldName, $options = array()) {
		return parent::checkbox($fieldName, $options);
	}

	public function dateTime($fieldName, $dateFormat = 'DMY', $timeFormat = '12', $attributes = array()) {
		return parent::dateTime($fieldName, $dateFormat, $timeFormat, $attributes);
	}

	public function day($fieldName = null, $attributes = array()) {
		return parent::day($fieldName, $attributes);
	}

	public function end($options = null) {
		return parent::end($options);
	}

	public function error($field, $text = null, $options = array()) {
		return parent::error($field, $text, $options);
	}

	public function file($fieldName, $options = array()) {
		return parent::file($fieldName, $options);
	}

	public function hidden($fieldName, $options = array()) {
		return parent::hidden($fieldName, $options);
	}

	public function hour($fieldName, $format24Hours = false, $attributes = array()) {
		return parent::hour($fieldName, $format24Hours, $attributes);
	}

	public function inputs($fields = null, $blacklist = null) {
		return parent::inputs($fields, $blacklist);
	}

	public function isFieldError($field) {
		return parent::isFieldError($field);
	}

	public function label($fieldName = null, $text = null, $options = array()) {
		return parent::label($fieldName, $text, $options);
	}

	public function meridan($fieldName, $attributes = array()) {
		return parent::meridan($fieldName, $attributes);
	}

	public function minute($fieldName, $attributes = array()) {
		return parent::minute($fieldName, $attributes);
	}

	public function month($fieldName, $attributes = array()) {
		return parent::month($fieldName, $attributes);
	}

	public function radio($fieldName, $options = array(), $attributes = array()) {
		return parent::radio($fieldName, $options, $attributes);
	}

	public function secure($fields = array()) {
		return parent::secure($fields);
	}

	public function select($fieldName, $options = array()) {
		return parent::select($fieldName, $options);
	}

}
