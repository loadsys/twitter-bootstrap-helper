<?php

App::uses('PaginatorHelper', 'View/Helper');
require_once(dirname(__FILE__) . '/../../Lib/BootstrapInfo.php');

class BootstrapPaginatorHelper extends PaginatorHelper {

	public $helpers = array('Html');

	public function __construct(View $View, $options = array()) {
		parent::__construct($View, $options);
		$this->BootstrapInfo = new BootstrapInfo();
	}

	public function next($text = '&gt;', $opt = array(), $disabledText = '&gt;', $disabledOpt = array()) {
		$opt['tag'] = $disabledOpt['tag'] = 'span';
		$opt['escape'] = $disabledOpt['escape'] = false;
		$next = parent::next($text, $opt, $disabledText, $disabledOpt);
		$next = str_replace(array('<span class="next">', '</span>'), '', $next);
		if (!parent::hasNext()) {
			$next = '<a href="#" class="disabled" rel="next">' . trim($next) . '</a>';
		}
		return $next;
	}

	public function prev($text = '&lt;', $opt = array(), $disabledText = '&lt;', $disabledOpt = array()) {
		$opt['tag'] = $disabledOpt['tag'] = 'span';
		$opt['escape'] = $disabledOpt['escape'] = false;
		$prev = parent::prev($text, $opt, $disabledText, $disabledOpt);
		$prev = str_replace(array('<span class="prev">', '</span>'), '', $prev);
		if (!parent::hasPrev()) {
			$prev = '<a href="#" class="disabled" rel="prev">' . trim($prev) . '</a>';
		}
		return $prev;
	}

	public function first($text = '&lt;&lt;', $options = array()) {
		$options['escape'] = false;
		return str_replace(array('<span>', '</span>'), '', parent::first($text, $options));
	}

	public function last($text = '&gt;&gt;', $options = array()) {
		$options['escape'] = false;
		return str_replace(array('<span>', '</span>'), '', parent::last($text, $options));
	}

	public function numbers($options = array()) {
		$options['separator'] = '';
		$options['currentClass'] = 'active';
		$numbers = parent::numbers($options);
		return str_replace(
			array('<span class="active">', '</span>'),
			array('<span><a href="#" class="active">', '</a></span>'),
			$numbers
		);
	}	

	public function pagination($options = array()) {
		$klass = isset($options['class']) ? $options['class'] : '';
		$align = $full = null;
		if (isset($options['align'])) {
			$align = $options['align'];
			unset($options['align']);
		}
		if (isset($options['full'])) {
			$full = $options['full'];
			unset($options['full']);
		}
		$options['class'] = $this->BootstrapInfo->stylesFor('pagination', $align, $klass);
		$pages = '';
		if ($full) { $pages .= '<li>' . $this->first() . '</li>'; }
		$pages .= '<li>' . $this->prev() . '</li>';
		$numbers = $this->numbers();
		$pages .= str_replace(array('<span>', '</span>'), array('<li>', '</li>'), $numbers);
		$pages .= '<li>' . $this->next() . '</li>';
		if ($full) { $pages .= '<li>' . $this->last() . '</li>'; }
		return $this->Html->tag('div', "<ul>{$pages}</ul>", $options);
	}

	public function pager($options = array()) {
		$klass = isset($options['class']) ? $options['class'] : '';
		$options['class'] = $this->BootstrapInfo->stylesFor('pager', '', $klass);
		$align = false;
		$newer = 'Newer &rarr;';
		$older = '&larr; Older';
		if (isset($options['newer'])) {
			$newer = $options['newer'];
			unset($options['newer']);
		}
		if (isset($options['older'])) {
			$older = $options['older'];
			unset($options['older']);
		}
		if (isset($options['align'])) {
			$align = $options['align'];
			unset($options['align']);
		}
		$prev = '<li';
		if ($align) { $prev .= ' class="previous"'; }
		$prev .= '>' . $this->prev($older, array(), $older, array()) . '</li>';
		$next = '<li';
		if ($align) { $next .= ' class="next"'; }
		$next .= '>' . $this->next($newer, array(), $newer, array()) . '</li>';
		return $this->Html->tag('ul', $prev . $next, $options);
	}

}

