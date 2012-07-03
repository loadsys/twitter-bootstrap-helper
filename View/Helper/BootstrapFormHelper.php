<?php

App::uses("FormHelper", "View/Helper");

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
		$options = $this->_buttonOptions($options);
		return parent::button($title, $options);
	}

	/**
	 * Takes the array of options from $this->button or $this->button_link
	 * and returns the modified array with the bootstrap classes
	 *
	 * @param mixed $options
	 * @access protected
	 * @return string
	 */
	protected function _buttonOptions($options) {
		$valid_styles = array(
			"danger", "info", "primary",
			"warning", "success", "inverse"
		);
		$valid_sizes = array("mini", "small", "large");
		$style = isset($options["style"]) ? $options["style"] : "";
		$size = isset($options["size"]) ? $options["size"] : "";
		$disabled = false;
		if (isset($options["disabled"])) {
			$disabled = (bool)$options["disabled"];
		}
		$class = "btn";
		if (!empty($style) && in_array($style, $valid_styles)) {
			$class .= " btn-{$style}";
		}
		if (!empty($size) && in_array($size, $valid_sizes)) {
			$class .= " btn-{$size}";
		}
		if ($disabled) { $class .= " disabled"; }
		unset($options["style"]);
		unset($options["size"]);
		unset($options["disabled"]);
		if (isset($options["class"])) {
			$options["class"] = $options["class"] . " " . $class;
		} else {
			$options["class"] = $class;
		}
		return $options;
	}

}
