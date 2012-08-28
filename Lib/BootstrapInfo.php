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
		"auth"      => "error"
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
				$main = '';
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
			case 'progress':
				$main = 'progress';
				$prefix = 'progress-';
				break;
			default:
				$prefix = '';
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

	public function progress($options) {
		$style = isset($options['style']) ? $options['style'] : '';
		$klass = isset($options['class']) ? $options['class'] : '';
		if (isset($options["striped"]) && $options["striped"]) {
			$klass .= " progress-striped";
		}
		if (isset($options["active"]) && $options["active"]) {
			$klass .= " active";
		}
		debug($klass);
		return $this->stylesFor('progress', $style, $klass);
	}

	public function _filter($str = '') {
		return implode(' ', array_filter(array_unique(explode(' ', $str))));
	}
}

