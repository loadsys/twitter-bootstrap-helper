<?php
/**
 * Helper that captures the Session flash and renders it in proper html
 * for the twitter bootstrap alert-message styles.
 *
 * @author Joey Trapp
 *
 */
class TwitterBootstrapHelper extends AppHelper {

	/**
	 * Helpers available in this helper
	 *
	 * @var array
	 * @access public
	 */
	public $helpers = array("Form", "Html", "Session");

	/**
	 * basic_input 
	 * 
	 * @param mixed $field 
	 * @param array $options 
	 * @access public
	 * @return void
	 */
	public function basic_input($field, $options = array()) {
		$options = $this->_parse_input_options($field, $options);
		if (!isset($options["field"])) { return ""; }
		$options["label"] = $this->_construct_label($options);
		$options["input"] = $this->_construct_input($options);
		return $options["label"] . $options["input"];
	}

	/**
	 * _parse_input_options 
	 * 
	 * @param mixed $field 
	 * @param array $options 
	 * @access public
	 * @return void
	 */
	public function _parse_input_options($field, $options = array()) {
		if (is_array($field)) {
			$options = $field;
		} else {
			$options["field"] = $field;
		}
		$defaults = array(
			"type" => "",
			"help_inline" => "",
			"help_block" => "",
			"label" => "",
			"append" => false,
			"prepend" => false,
			"state" => false
		);
		return array_merge($defaults, $options);
	}

	/**
	 * _construct_label 
	 * 
	 * @param mixed $options 
	 * @access public
	 * @return void
	 */
	public function _construct_label($options, $basic = true) {
		if ($options["label"] === false) { return ""; }
		if (in_array($options["type"], array("checkbox"))) {
			$opt = $options;
			$opt["type"] = "";
			$input = $this->_construct_input($opt);
			$options["label"] = $this->Form->label(
				$options["field"],
				$input . $options["label"],
				"checkbox"
			);
		} else {
			$class = (!$basic) ? "control-label" : null;
			if (!empty($options["label"])) {
				$options["label"] = $this->Form->label(
					$options["field"],
					$options["label"],
					array("class" => $class)
				);
			} else {
				$options["label"] = $this->Form->label(
					$options["field"],
					null,
					array("class" => $class)
				);
			}
		}
		return $options["label"];
	}

	/**
	 * _construct_input 
	 * 
	 * @param mixed $options 
	 * @access public
	 * @return void
	 */
	public function _construct_input($options) {
		if (in_array($options["type"], array("checkbox"))) {
			$options["input"] = "";
		} 
		if (isset($options["input"])) { return $options["input"]; }
		$options["input"] = $this->Form->input($options["field"], array(
			"div" => false,
			"label" => false
		));
		return $options["input"];
	}

	/**
	 * _constuct_input_and_addon 
	 * 
	 * @param mixed $options 
	 * @access public
	 * @return void
	 */
	public function _constuct_input_and_addon($options) {
		if (isset($options["input"])) { return $options["input"]; }
		$options["input"] = $this->_construct_input($options);
		$options["input"] = $this->_handle_input_addon($options);
		return $options["input"];
	}

	/**
	 * _handle_input_addon 
	 * 
	 * @param mixed $options 
	 * @access public
	 * @return void
	 */
	public function _handle_input_addon($options) {
		$input = $options["input"];
		if ($options["append"]) {
			$input = $this->input_addon($options["append"], $input, "append");
		} elseif ($options["prepend"]) {
			$input = $this->input_addon($options["prepend"], $input, "prepend");
		}
		return $input;
	}
	
	/**
	 * input_addon 
	 * 
	 * @param mixed $content 
	 * @param mixed $input 
	 * @param string $type 
	 * @access public
	 * @return void
	 */
	public function input_addon($content, $input, $type = "append") {
		$tag = (strpos("input", $content) !== false) ? "label" : "span";
		$addon = $this->Html->tag($tag, $content, array("class" => "add-on"));
		return $this->Html->tag(
			"div",
			$input . $content,
			array("class" => "input-{$type}")
		);
	}

	/**
	 * search 
	 * 
	 * @param mixed $name 
	 * @param array $options 
	 * @access public
	 * @return void
	 */
	public function search($name = null, $options = array()) {
		$class = "search-query";
		if (!$name) {
			$name = "search";
		}
		if (isset($options["class"])) {
			$options["class"] .= " {$class}";
		} else {
			$options["class"] = $class;
		}
		return $this->Form->text($name, $options);
	}
	
	/**
	 * Takes an array of options to output markup that works with
	 * twitter bootstrap forms.
	 *
	 * @param array $options
	 * @access public
	 * @return string
	 */
	public function input($field, $options = array()) {
		$options = $this->_parse_input_options($field, $options);
		if (!isset($options['field'])) { return ''; }
		$out = $help_inline = $help_block = '';
		/*$model = $this->Form->defaultModel;
		if (strpos(".", $options["field"]) !== false) {
			$split = explode(".", $options["field"]);
			$model = $split[0];
		} else {
			$options["field"] = "{$model}.{$options["field"]}";
		}*/
		if ($options['label'] === false) {
			$options['label'] = '';
		} else if (!empty($options['label'])) {
			$options['label'] = $this->Form->label(
				$options['field'],
				$options['label'],
				"control-label"
			);
		} else {
			$options['label'] = $this->Form->label(
				$options['field'],
				null,
				"control-label"
			);
		}
		list($help_inline, $help_block) = $this->_help_markup($options);
		if ($this->Form->error($options['field'])) {
			$options['state'] = 'error';
			$help_block = $this->Html->tag(
				"span",
				$this->Form->error($options['field']),
				array("class" => "help-block")
			);
		}
		$options["input"] = $this->_combine_input($options);
		$input = $this->Html->tag(
			"div",
			$options['input'].$help_inline.$help_block,
			array("class" => "controls")
		);
		$wrap_class = "control-group";
		if ($options["state"] !== false) {
			$wrap_class = "{$wrap_class} {$options["state"]}";
		}
		return $this->Html->tag(
			"div",
			$options['type'].$options['label'].$input,
			array("class" => $wrap_class)
		);
	}

	/**
	 * Takes the array of options and will apply the append or prepend bits
	 * from the options and returns the input string. 
	 * 
	 * @param mixed $input 
	 * @param string $type 
	 * @access public
	 * @return string
	 */
	public function _combine_input($options) {
		$combine_markup = array("append" => "", "prepend" => "");
		if (isset($options["input"])) {
			$input = $options["input"];
		} else {
			$opt = array("div" => false, "label" => false, "error" => false);
			if (isset($options["type"])) {
				$opt["type"] = $options["type"];
			}
			$input = $this->Form->input($options["field"], $opt);
		}
		foreach (array_keys($combine_markup) as $combine) {
			if (isset($options[$combine]) && !empty($options[$combine])) {
				$_tag = (strpos("input", $options[$combine]) !== false) ? "label" : "span";
				$content = $this->Html->tag($_tag, $options[$combine], array("class" => "add-on"));
				$combine_markup[$combine] = $content;
			}
		}
		if (!empty($combine_markup["append"])) {
			$input = $this->Html->tag("div", $options[$combine].$content, array("class" => "input-append"));
		}
		if (empty($combine_markup["append"]) && !empty($combine_markup["prepend"])) {
			$input = $this->Html->tag("div", $content.$options[$combine], array("class" => "input-prepend"));
		}
		return $input;
	}

	/**
	 * Takes the options from the input method and returns an array of the
	 * inline help and inline block content wrapped in the appropriate markup. 
	 * 
	 * @param mixed $options 
	 * @access public
	 * @return string
	 */
	public function _help_markup($options) {
		$help_markup = array("help_inline" => "", "help_block" => "");
		foreach (array_keys($help_markup) as $help) {
			if (isset($options[$help]) && !empty($options[$help])) {
				$help_class = str_replace("_", "-", $help);
				$help_markup[$help] = $this->Html->tag(
					"span",
					$options[$help],
					array("class" => $help_class)
				); 
			}
		}
		return array_values($help_markup);
	}

	/**
	 * Outputs a list of radio form elements with the proper
	 * markup for twitter bootstrap styles 
	 * 
	 * @param array $options 
	 * @access public
	 * @return string
	 */
	public function radio($field, $options = array()) {
		if (is_array($field)) {
			$options = $field;
		} else {
			$options["field"] = $field;
		}
		if (!isset($options["options"]) || !isset($options["field"])) { return ""; }
		$opt = $options["options"];
		unset($options["options"]);
		$inputs = "";
		$hiddenField = (isset($options['hiddenField']) && $options['hiddenField']);
		foreach ($opt as $key => $val) {
			$input = $this->Form->radio(
				$options["field"],
				array($key => $val),
				array("label" => false, 'hiddenField' => $hiddenField)
			);
			$id = array();
			preg_match_all("/id=\"[a-zA-Z0-9_-]*\"/", $input, $id);
			if (!empty($id[0])) {
				$id = end($id[0]);
				$id = substr($id, 4);
				$id = substr($id, 0, -1);
				$input = $this->Html->tag("label", $input, array("for" => $id));
			}
			$inputs .= $this->Html->tag("li", $input);
		}
		$options["input"] = $this->Html->tag("ul", $inputs, array("class" => "inputs-list"));
		return $this->input($options);
	}

	/**
	 * Wraps the form button method and just applies the Bootstrap classes to the button
	 * before passing the options on to the FormHelper button method. 
	 * 
	 * @param string $value 
	 * @param array $options 
	 * @access public
	 * @return string
	 */
	public function button($value = "Submit", $options = array()) {
		$options = $this->button_options($options);
		return $this->Form->button($value, $options);
	}

	/**
	 * Wraps the html link method and applies the Bootstrap classes to the options array
	 * before passing it on to the html link method. 
	 * 
	 * @param mixed $title 
	 * @param mixed $url 
	 * @param array $options 
	 * @param mixed $confirm 
	 * @access public
	 * @return string
	 */
	public function button_link($title, $url, $options = array(), $confirm = false) {
		$options = $this->button_options($options);
		return $this->Html->link($title, $url, $options, $confirm);
	}

	/**
	 * Wraps the postLink method to create post links that use the bootstrap button
	 * styles. 
	 * 
	 * @param mixed $title 
	 * @param mixed $url 
	 * @param array $options 
	 * @param mixed $confirm 
	 * @access public
	 * @return string
	 */
	public function button_form($title, $url, $options = array(), $confirm = false) {
		$options = $this->button_options($options);
		return $this->Form->postLink($title, $url, $options, $confirm);
	}

	/**
	 * Takes the array of options from $this->button or $this->button_link and returns
	 * the modified array with the bootstrap classes 
	 * 
	 * @param mixed $options 
	 * @access public
	 * @return string
	 */
	public function button_options($options) {
		$valid_styles = array("danger", "info", "primary", "warning", "success");
		$valid_sizes = array("small", "large");
		$style = isset($options["style"]) ? $options["style"] : "";
		$size = isset($options["size"]) ? $options["size"] : "";
		$disabled = isset($options["disabled"]) ? (bool)$options["disabled"] : false;
		$class = "btn";
		if (!empty($style) && in_array($style, $valid_styles)) {
			$class .= " btn-{$style}";
		}
		if (!empty($size) && in_array($size, $valid_sizes)) { $class .= " {$size}"; }
		if ($disabled) { $class .= " btn-disabled"; }
		unset($options["style"]);
		unset($options["size"]);
		unset($options["disabled"]);
		$options["class"] = isset($options["class"]) ? $options["class"] . " " . $class : $class;
		return $options;
	}

	/**
	 * Delegates to the HtmlHelper::getCrumbList() method and sets the proper class for the
	 * breadcrumbs class. 
	 * 
	 * @param array $options 
	 * @access public
	 * @return string
	 */
	public function breadcrumbs($options = array()) {
		return $this->getCrumbList(array_merge(array("class" => "breadcrumb"), $options));
	}

	/**
	 * Delegates to the HtmlHelper::addCrumb() method. 
	 * 
	 * @param mixed $title 
	 * @param mixed $link 
	 * @param array $options 
	 * @access public
	 * @return string
	 */
	public function add_crumb($title, $url, $options = array()) {
		return $this->Html->addCrumb($title, $url, $options);
	}

	/**
	 * Creates a Bootstrap label with $messsage and optionally the $type. Any
	 * options that could get passed to HtmlHelper::tag can be passed in the
	 * third param.
	 * 
	 * @param string $message 
	 * @param string $type 
	 * @param array $options
	 * @access public
	 * @return string
	 */
	public function label($message = "", $style = "", $options = array()) {
		$class = "label";
		$valid = array("success", "important", "warning", "info");
		if (!empty($style) && in_array($style, $valid)) {
			$class .= " label-{$style}";
		}
		if (isset($options["class"]) && !empty($options["class"])) {
			$options["class"] = $class . " " . $options["class"];
		} else {
			$options["class"] = $class;
		}
		return $this->Html->tag("span", $message, $options);
	}

	/**
	 * Takes the name of an icon and returns the i tag with the appropriately
	 * named class. The second param will switch between black and white 
	 * icon sets.
	 * 
	 * @param mixed $name 
	 * @access public
	 * @return void
	 */
	public function icon($name, $color = "black") {
		$class = "icon-{$name}";
		if ($color === "white") {
			$class = "{$class} icon-white";
		}
		return $this->Html->tag("i", array("class" => $class));
	}

	/**
	 * Renders alert markup and takes a style and closable option 
	 * 
	 * @param mixed $content 
	 * @param array $options 
	 * @access public
	 * @return void
	 */
	public function alert($content, $options = array()) {
		$close = "";
		if (isset($options['closable']) && $options['closable']) {
			$close = '<a class="close">&times;</a>';
		}
		$style = isset($options["style"]) ? $options["style"] : "warning";
		$types = array("info", "success", "error", "warning");
		if ($style === "flash") {
			$style = "warning";
		}
		if (strtolower($style) === "auth") {
			$style = "error";
		}
		if (!in_array($style, array_merge($types, array("auth", "flash")))) {
			$class = "alert {$style}";
		} else {
			$class = "alert alert-{$style}";
		}
		return $this->Html->tag(
			'div',
			"{$close}{$content}",
			array("class" => $class)
		);
	}
	
	/**
	 * Captures the Session flash if it is set and renders it in the proper
	 * markup for the twitter bootstrap styles. The default key of "flash",
	 * gets translated to the warning styles. Other valid $keys are "info",
	 * "success", "error". The $key "auth" with use the error styles because
	 * that is when the auth form fails.
	 *
	 * @param string $key
	 * @param $options
	 * @access public
	 * @return string
	 */
	public function flash($key = "flash", $options = array()) {
		$content = $this->_flash_content($key);
		if (empty($content)) { return ''; }
		$close = false;
		if (isset($options['closable']) && $options['closable']) {
			$close = true;
		}
		return $this->alert($content, array("style" => $key, "closable" => $close));
	}
	
	/**
	 * By default it checks $this->flash() for 5 different keys of valid
	 * flash types and returns the string.
	 *
	 * @param array $options
	 * @access public
	 * @return string
	 */
	public function flashes($options = array()) {
		if (!isset($options["keys"]) || !$options["keys"]) {
			$options["keys"] = array("info", "success", "error", "warning", "flash");
		}
		if (isset($options["auth"]) && $options["auth"]) {
			$options["keys"][] = "auth";
			unset($options["auth"]);
		}
		$keys = $options["keys"];
		unset($options["keys"]);
		$out = '';
		foreach($keys as $key) {
			$out .= $this->flash($key, $options);
		}
		return $out;
	}

	/**
	 * Returns the content from SessionHelper::flash() for the passed in
	 * $key. 
	 * 
	 * @param string $key 
	 * @access public
	 * @return void
	 */
	public function _flash_content($key = "flash") {
		return $this->Session->flash($key, array("element" => null));
	}
	
	/**
	 * Displays the alert-message.block-messgae div's from the twitter
	 * bootstrap.
	 *
	 * @param string $message
	 * @param array $links
	 * @param array $options
	 * @access public
	 * @return string
	 */
	public function block($message = null, $options = array()) {
		$style = "";
		$valid = array("success", "info", "error");
		if (isset($options["style"]) && in_array($options["style"], $valid)) {
			$style = "alert-{$options["style"]}";
		}
		$class = "alert alert-block {$style}";
		$close = $heading = "";
		if (isset($options["closable"]) && $options["closable"]) {
			$close = '<a class="close">&times;</a>';
		}
		if (isset($options["heading"]) && !empty($options["heading"])) {
			$heading = $this->Html->tag("h4", $options["heading"], array("class" => "alert-heading"));
		}
		return $this->Html->tag("div", $close.$heading.$message, array("class" => $class));
	}

}
