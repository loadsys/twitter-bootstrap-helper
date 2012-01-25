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
	 * Takes an array of options to output markup that works with
	 * twitter bootstrap forms.
	 *
	 * @param array $options
	 * @access public
	 * @return string
	 */
	public function input($field, $options = array()) {
		if (is_array($field)) {
			$options = $field;
		} else {
			$options["field"] = $field;
		}
		if (!isset($options['input']) || !isset($options['field'])) { return ''; }
		$out = $help_inline = $help_block = '';
		$options = array_merge(array('type' => '', 'help_inline' => '', 'help_block' => '', 'label' => ''), $options);
		if (!empty($options['label'])) {
			$options['label'] = $this->Form->label($options['field'], $options['label']);
		} else {
			$options['label'] = $this->Form->label($options['field']);
		}
		list($help_inline, $help_block) = $this->_help_markup($options);
		if ($this->Form->error($options['field'])) {
			$options['type'] = 'error';
			$help_block = $this->Html->tag("span", $this->Form->error($options['field']), array("class" => "help-block"));
		}
		$options["input"] = $this->_combine_input($options);
		$input = $this->Html->tag("div", $options['input'].$help_inline.$help_block, array("class" => "input"));
		return $this->Html->tag("div", $options['type'].$options['label'].$input, array("class" => "clearfix"));
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
		$input = $options["input"];
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
				$help_markup[$help] = $this->Html->tag("span", $options[$help], array("class" => $help_class)); 
			}
		}
		return $help_markup;
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
			$options["field"] = $field;
		} else {
			$options = $field;
		}
		if (!isset($options["options"]) || !isset($options["field"])) { return ""; }
		$opt = $options["options"];
		unset($options["options"]);
		$inputs = "";
		foreach ($opt as $key => $val) {
			$input = $this->Form->radio(
				$options["field"],
				array($key => $val),
				array("label" => false)
			);
			$id = array();
			preg_match_all("/id=\"[a-zA-Z0-9_-]*\"/", $input, $id);
			if (isset($id[0][1]) && !empty($id[0][1])) {
				$id = $id[0][1];
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
		$style = isset($options["style"]) ? $options["style"] : "";
		$size = isset($options["size"]) ? $options["size"] : "";
		$disabled = isset($options["disabled"]) ? (bool)$options["disabled"] : false;
		$class = "btn";
		if (!empty($style)) { $class .= " {$style}"; }
		if (!empty($size)) { $class .= " {$size}"; }
		if ($disabled) { $class .= " disabled"; }
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
		$valid = array("success", "important", "warning", "notice");
		if (!empty($style) && in_array($style, $valid)) {
			$class .= " {$style}";
		}
		if (isset($options["class"]) && !empty($options["class"])) {
			$options["class"] = $class . " " . $options["class"];
		} else {
			$options["class"] = $class;
		}
		return $this->Html->tag("span", $message, $options);
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
		$content = $this->Session->flash($key, array("element" => null));
		if (empty($content)) { return ''; }
		$tag = '<div class="alert-message%s">';
		if (isset($options['closable']) && $options['closable']) {
			$tag .= '<a href="#" class="close">';
		}
		$tag .= '<p>%s</p>';
		if (isset($options['closable']) && $options['closable']) {
			$tag .= '</a>';
		}
		$tag .= '</div>';
		$type = " warning";
		if (in_array($key, array("info", "success", "error"))) {
			$type = " $key";
		}
		if (strtolower($key) === "auth") {
			$type = " error";
		}
		return sprintf($tag, $type, $content);
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
	 * Displays the alert-message.block-messgae div's from the twitter
	 * bootstrap.
	 *
	 * @param string $message
	 * @param array $links
	 * @param array $options
	 * @access public
	 * @return string
	 */
	public function block($message = null, $links = array(), $options = array()) {
		$defaults = array("type" => "warning", "closable" => false);
		$options = array_merge($defaults, $options);
		$wrap = '<div class="alert-message block-message '.$options["type"].'">%s%s</div>';
		$links_wrap = '<div class="alert-actions">%s</div>';
		return sprintf($wrap, $message, sprintf($links_wrap, implode("", $links)));
	}

}
