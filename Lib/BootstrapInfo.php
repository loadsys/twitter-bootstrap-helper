<?php

class BootstrapInfo {

	public $styleMap = array(
		"primary"   => "primary",
		"success"   => "success",
		"link"      => "link",
		"important" => "important",
		"danger"    => "danger",
		"warning"   => "warning",
		"error"     => "error",
		"info"      => "info",
		"inverse"   => "inverse",
		"flash"     => "warning",
		"auth"      => "error",
		"centered"  => "centered",
		"center"    => "centered",
		"right"     => "right"
	);

	public $sizeMap = array(
		"mini"    => "mini",
		"small"   => "small",
		"medium"  => "medium",
		"large"   => "large",
		"xlarge"  => "xlarge",
		"xxlarge" => "xxlarge"
	);

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

	public function progress($options = array()) {
		$style = isset($options['style']) ? $options['style'] : '';
		$klass = isset($options['class']) ? $options['class'] : '';
		if (isset($options["striped"]) && $options["striped"]) {
			$klass .= " progress-striped";
		}
		if (isset($options["active"]) && $options["active"]) {
			$klass .= " active";
		}
		return $this->stylesFor('progress', $style, $klass);
	}

	public function button($options = array()) {
		$klass = isset($options['class']) ? $options['class'] : '';
		$style = isset($options["style"]) ? $options["style"] : "";
		$size = isset($options["size"]) ? $options["size"] : "";
		$disabled = false;
		if (isset($options["disabled"])) {
			$disabled = (bool)$options["disabled"];
		}
		if ($disabled) { $klass .= " disabled"; }
		unset($options["style"]);
		unset($options["size"]);
		unset($options["disabled"]);
		$options['class'] = $this->sizesFor('button', $size, $this->stylesFor('button', $style, $klass));
		return $options;
	}

	public function _filter($str = '') {
		return implode(' ', array_filter(array_unique(explode(' ', $str))));
	}
}

