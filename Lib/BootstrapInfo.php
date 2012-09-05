<?php

class BootstrapInfo {

	public $styleMap = array(
		"primary"    => "primary",
		"success"    => "success",
		"link"       => "link",
		"important"  => "important",
		"danger"     => "danger",
		"warning"    => "warning",
		"error"      => "error",
		"info"       => "info",
		"inverse"    => "inverse",
		"flash"      => "warning",
		"auth"       => "error",
		"centered"   => "centered",
		"center"     => "centered",
		"right"      => "right",
		"search"     => "search",
		"inline"     => "inline",
		"horizontal" => "horizontal",
		"vertical"   => "vertical"
	);

	public $sizeMap = array(
		"mini"    => "mini",
		"small"   => "small",
		"medium"  => "medium",
		"large"   => "large",
		"xlarge"  => "xlarge",
		"xxlarge" => "xxlarge"
	);

	/**
	 * For elements that have special bootstrap styles.
	 * @access public
	 * @param [type] $type [description]
	 * @param [type] $style [description]
	 * @param [type] $klass [description]
	 * @return [type] [description]
	 */
	public function stylesFor($type, $style = null, $klass = null) {
		$prefix = $s = $main = '';
		switch ($type) {
			case 'alert':
				$main = 'alert';
				$prefix = 'alert-';
				break;
			case 'badge':
				$main = 'badge';
				$prefix = 'badge-';
				break;
			case 'button':
				$main = 'btn';
				$prefix = 'btn-';
				break;
			case 'form':
				$prefix = 'form-';
				break;
			case 'icon':
				$prefix = 'icon-';
				if (!$style) {
					throw new Exception("Must give an icon to render");
				}
				$s = $prefix . $style;
				$style = null;
				break;
			case 'label':
				$main = 'label';
				$prefix = 'label-';
				break;
			case 'pager':
				$main = 'pager';
				break;
			case 'pagination':
				$main = 'pagination';
				$prefix = 'pagination-';
				break;
			case 'progress':
				$main = 'progress';
				$prefix = 'progress-';
				break;
		}

		if ($style && isset($this->styleMap[$style])) {
			$s = $prefix . $this->styleMap[$style];
		}

		$str = trim(implode(' ', array_filter(array($main, $s, $klass))));
		return $this->_filter($str);
	}

	/**
	 * For the elements that can have a defined size, this method will return the
	 * classes they need to have their sizes.
	 *
	 * @access public
	 * @param string $type
	 * @param string $size
	 * @param string $klass
	 * @return string
	 */
	public function sizesFor($type, $size = null, $klass = null) {
		$prefix = $s = $main = '';
		switch ($type) {
			case 'input':
				$main = '';
				$prefix = 'input-';
				break;
			case 'button':
				$main = "btn";
				$prefix = "btn-";
				break;
			default:
				$prefix = '';
		}

		if ($size && isset($this->sizeMap[$size])) {
			$s = $prefix . $this->sizeMap[$size];
		}

		$str = trim(implode(' ', array_filter(array($main, $s, $klass))));
		return $this->_filter($str);
	}

	/**
	 * Method for setting the class string for the bootstrap progress. Takes the
	 * array of options and sets the $options['class'] and returns the options.
	 *
	 * @access public
	 * @param array $options
	 * @return array
	 */
	public function progress($options = array()) {
		$style = $klass = '';
		if (isset($options["style"]) && $options["style"]) {
			$style = $options['style'];
			unset($options['style']);
		}
		$klass = isset($options['class']) ? $options['class'] : '';
		if (isset($options["striped"]) && $options["striped"]) {
			$klass .= " progress-striped";
			unset($options['striped']);
		}
		if (isset($options["active"]) && $options["active"]) {
			$klass .= " active";
			unset($options['active']);
		}
		$options['class'] = $this->stylesFor('progress', $style, $klass);
		return $options;
	}

	/**
	 * Method for setting the class string for a bootstrap button. Takes the
	 * array of options and sets the $options['class'] and returns the options.
	 *
	 * @access public
	 * @param array $options
	 * @return array
	 */
	public function button($options = array()) {
		$style = $size = '';
		$klass = isset($options['class']) ? $options['class'] : "";
		if (isset($options["style"])) {
			$style = $options["style"];
			unset($options['style']);
		}
		if (isset($options["size"])) {
			$size = $options["size"];
			unset($options['size']);
		}
		$disabled = false;
		if (isset($options["disabled"])) {
			$disabled = (bool)$options["disabled"];
			unset($options["disabled"]);
		}
		if ($disabled) { $klass .= " disabled"; }
		$options['class'] = $this->sizesFor('button', $size, $this->stylesFor('button', $style, $klass));
		return $options;
	}

	/**
	 * Breaks a string up by spaces and removes duplicate stings and double
	 * spaces and returns the array imploded by a single space
	 *
	 * @access public
	 * @param string $str
	 * @return string
	 */
	public function _filter($str = '') {
		return implode(' ', array_filter(array_unique(explode(' ', $str))));
	}
}

