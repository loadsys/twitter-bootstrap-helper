<?php

App::uses("HtmlHelper", "View/Helper");

class BootstrapHtmlHelper extends HtmlHelper {

	public $helpers = array("Html");

	/**
	 * Builds a button dropdown menu with the $value as the button text and the
	 * "links" option as the dropdown items
	 * @param  string $value
	 * @param  array  $options
	 * @return string
	 */
	public function buttonDropdown($value = "", $options = array()) {
		$_links = isset($options["links"]) ? $options["links"] : array();
		$split = isset($options["split"]) ? (bool)$options["split"] : false;
		$options = $this->buttonOptions($options);
		$links = "";
		foreach ($_links as $link) {
			if (is_array($link)) {
				$title = $url = $opt = $confirm = null;
				if (isset($link[0])) {
					$title = $link[0];
				} else {
					continue;
				}
				if (isset($link[1])) {
					$url = $link[1];
				} else {
					continue;
				}
				$opt = isset($link[2]) ? $link[2] : array();
				$confirm = isset($link[3]) ? $link[3] : false;
				$l = "<li>".$this->link($title, $url, $opt, $confirm)."</li>";
				$links .= $l;
			} elseif (is_string($link)) {
				$links .= "<li>{$link}</li>";
			} else {
				$links .= '<li class="divider"></li>';
			}
		}
		if ($split) {
			$button = $this->tag(
				"button",
				$value,
				array(
					"class" => $options["class"]
				)
			);
			$button .= $this->tag(
				"button",
				"\n" . '<span class="caret"></span>',
				array(
					"class" => $options["class"] . " dropdown-toggle",
					"data-toggle" => "dropdown"
				)
			);
		} else {
			$button = $this->tag(
				"button",
				$value . ' <span class="caret"></span>',
				array(
					"class" => $options["class"] . " dropdown-toggle",
					"data-toggle" => "dropdown"
				)
			);
		}
		$group_class = "btn-group";
		$ul_class = "dropdown-menu";
		if (isset($options["dropup"]) && $options["dropup"]) {
			$group_class .= " dropup";
		}
		if (isset($options["right"]) && $options["right"]) {
			$ul_class .= " pull-right";
		}
		$links = $this->tag("ul", $links, array("class" => $ul_class));
		return $this->tag(
			"div",
			$button . $links,
			array("class" => $group_class)
		);
	}

	/**
	 * Wraps the html link method and applies the Bootstrap classes to the
	 * options array before passing it on to the html link method.
	 *
	 * @param mixed $title
	 * @param mixed $url
	 * @param array $options
	 * @param mixed $confirm
	 * @access public
	 * @return string
	 */
	public function buttonLink($title, $url, $opt = array(), $confirm = false) {
		$opt = $this->buttonOptions($opt);
		return $this->link($title, $url, $opt, $confirm);
	}

	/**
	 * Takes the array of options from $this->button or $this->button_link
	 * and returns the modified array with the bootstrap classes
	 *
	 * @param mixed $options
	 * @access public
	 * @return string
	 */
	public function buttonOptions($options) {
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

	/**
	 * Delegates to the HtmlHelper::getCrumbList() method and sets the proper
	 * class for the breadcrumbs class.
	 *
	 * @param array $options
	 * @access public
	 * @return string
	 */
	public function breadcrumbs($options = array()) {
		$crumbs = $this->getCrumbs("%%");
		$crumbs = explode("%%", $crumbs);
		$out = "";
		$divider = "/";
		if (isset($options["class"])) {
			$options["class"] .= " breadcrumb";
		} else {
			$options["class"] = "breadcrumb";
		}
		if (isset($options["divider"])) {
			$divider = $options["divider"];
			unset($options["divider"]);
		}
		for ($i = 0; $i < count($crumbs); $i += 1) {
			$opt = array();
			$d = $this->tag("span", $divider, array("class" => "divider"));
			if (!isset($crumbs[$i + 1])) {
				$opt["class"] = "active";
				$d = "";
			}
			$out .= $this->tag("li", $crumbs[$i] . $d, $opt);
		}
		return $this->tag("ul", $out, $options);
	}

}
