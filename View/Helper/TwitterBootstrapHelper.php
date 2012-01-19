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
	public function input($options = array()) {
		if (!isset($options['input']) || !isset($options['field'])) { return ''; }
		$out = $help_inline = $help_block = '';
		$options = array_merge(array('type' => '', 'help_inline' => '', 'help_block' => '', 'label' => ''), $options);
		if (!empty($options['label'])) {
			$options['label'] = $this->Form->label($options['field'], $options['label']);
		} else {
			$options['label'] = $this->Form->label($options['field']);
		}
		if (!empty($options['help_inline'])) {
			$help_inline = $this->Html->tag("span", $options['help_inline'], array("class" => "help-inline"));
		}
		if (!empty($options['help_block'])) {
			$help_block = $this->Html->tag("span", $options['help_block'], array("class" => "help-block"));
		}
		if ($this->Form->error($options['field'])) {
			$options['type'] = 'error';
			$help_block = $this->Html->tag("span", $this->Form->error($options['field']), array("class" => "help-block"));
		}
		if (isset($options['append'])) {
			$_tag = (strpos("input", $options["append"]) !== false) ? "label" : "span";
			$append_text = $this->Html->tag($_tag, $options["append"], array("class" => "add-on"));
			$options['input'] = $this->Html->tag("div", $options["input"].$append_text, array("class" => "input-append"));
		}
		if (isset($options['prepend'])) {
			$_tag = (strpos("input", $options["prepend"]) !== false) ? "label" : "span";
			$prepend_text = $this->Html->tag($_tag, $options["prepend"], array("class" => "add-on"));
			$options['input'] = $this->Html->tag("div", $options["input"].$prepend_text, array("class" => "input-append"));
		}
		$input = $this->Html->tag("div", $options['input'].$help_inline.$help_block, array("class" => "input");
		return $this->Html->tag("div", $options['type'].$options['label'].$input, array("class" => "clearfix");
	}

	/**
	 * Outputs a list of radio form elements with the proper
	 * markup for twitter bootstrap styles 
	 * 
	 * @param array $options 
	 * @access public
	 * @return string
	 */
	public function radio($options = array()) {
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
		return $this->Html->postLink($title, $url, $options, $confirm);
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
		if (!empty($style)) {
			$class .= " {$style}";
		}
		$options = Set::merge(array("class" => $class));
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
			$options["keys"] = array("info", "success", "error", "warning", "auth", "flash");
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
