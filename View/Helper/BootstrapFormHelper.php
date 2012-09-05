<?php

App::uses("FormHelper", "View/Helper");
require_once(dirname(__FILE__) . '/../../Lib/BootstrapInfo.php');

class BootstrapFormHelper extends FormHelper {

	/**
	 * Overwriting default constructor to assign an instance of the
	 * BootstrapInfo class.
	 *
	 * @access public
	 * @param View $View
	 * @param array $options
	 */
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
		$type = '';
		$klass = isset($opt['class']) ? $opt['class'] : '';
		if (isset($opt["formType"])) {
			$type = $opt["formType"];
			unset($opt["formType"]);
		}
		$opt['class'] = $this->BootstrapInfo->stylesFor('form', $type, $klass);
		return parent::create($model, $opt);
	}

	/**
	 * Copy of the core form helper that is modified to work with bootstrap
	 * markup and styles
	 *
	 * @access public
	 * @param string $fieldName
	 * @param array $options
	 * @return string
	 */
	public function input($fieldName, $options = array()) {
		// $this->setEntity($fieldName);
		// $defaults = array(
		// 	'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
		// 	'div'    => array(
		// 		'class' => 'control-group'
		// 	),
		// 	'error'   => array(
		// 		'attributes' => array(
		// 			'class' =>'help-inline',
		// 			'wrap'  => 'span'
		// 		)
		// 	),
		// 	'help' => '',
		// );
		// $options = array_merge($defaults, $options);
		// if (!empty($options['help'])) {
		// 	$options['after'] = '<span class="help-block">' . $options['help'] . '</span>' . $options['after'];
		// }
		// $modelKey = $this->model();
		// $fieldKey = $this->field();
		// if ($this->_introspectModel($modelKey, 'validates', $fieldKey)) {
		// 	$options['label'] = $this->addClass($options['div'], 'notice');
		// }
		// return parent::input($fieldName, $options);

		$this->setEntity($fieldName);

		$options = array_merge(
			array('before' => null, 'between' => null, 'after' => null, 'format' => null),
			$this->_inputDefaults,
			$options
		);

		$modelKey = $this->model();
		$fieldKey = $this->field();

		if (!isset($options['type'])) {
			$magicType = true;
			$options['type'] = 'text';
			if (isset($options['options'])) {
				$options['type'] = 'select';
			} elseif (in_array($fieldKey, array('psword', 'passwd', 'password'))) {
				$options['type'] = 'password';
			} elseif (isset($options['checked'])) {
				$options['type'] = 'checkbox';
			} elseif ($fieldDef = $this->_introspectModel($modelKey, 'fields', $fieldKey)) {
				$type = $fieldDef['type'];
				$primaryKey = $this->fieldset[$modelKey]['key'];
			}

			if (isset($type)) {
				$map = array(
					'string' => 'text', 'datetime' => 'datetime',
					'boolean' => 'checkbox', 'timestamp' => 'datetime',
					'text' => 'textarea', 'time' => 'time',
					'date' => 'date', 'float' => 'number',
					'integer' => 'number'
				);

				if (isset($this->map[$type])) {
					$options['type'] = $this->map[$type];
				} elseif (isset($map[$type])) {
					$options['type'] = $map[$type];
				}
				if ($fieldKey == $primaryKey) {
					$options['type'] = 'hidden';
				}
				if (
					$options['type'] === 'number' &&
					$type === 'float' &&
					!isset($options['step'])
				) {
					$options['step'] = 'any';
				}
			}
			if (preg_match('/_id$/', $fieldKey) && $options['type'] !== 'hidden') {
				$options['type'] = 'select';
			}

			if ($modelKey === $fieldKey) {
				$options['type'] = 'select';
				if (!isset($options['multiple'])) {
					$options['multiple'] = 'multiple';
				}
			}
		}
		$types = array('checkbox', 'radio', 'select');

		if (
			(!isset($options['options']) && in_array($options['type'], $types)) ||
			(isset($magicType) && $options['type'] == 'text')
		) {
			$varName = Inflector::variable(
				Inflector::pluralize(preg_replace('/_id$/', '', $fieldKey))
			);
			$varOptions = $this->_View->getVar($varName);
			if (is_array($varOptions)) {
				if ($options['type'] !== 'radio') {
					$options['type'] = 'select';
				}
				$options['options'] = $varOptions;
			}
		}

		$autoLength = (!array_key_exists('maxlength', $options) && isset($fieldDef['length']));
		if ($autoLength && $options['type'] == 'text') {
			$options['maxlength'] = $fieldDef['length'];
		}
		if ($autoLength && $fieldDef['type'] == 'float') {
			$options['maxlength'] = array_sum(explode(',', $fieldDef['length'])) + 1;
		}

		$divOptions = array();
		$div = $this->_extractOption('div', $options, true);
		unset($options['div']);

		if (!empty($div)) {
			$divOptions['class'] = 'input';
			$divOptions = $this->addClass($divOptions, $options['type']);
			if (is_string($div)) {
				$divOptions['class'] = $div;
			} elseif (is_array($div)) {
				$divOptions = array_merge($divOptions, $div);
			}
			if ($this->_introspectModel($modelKey, 'validates', $fieldKey)) {
				$divOptions = $this->addClass($divOptions, 'required');
			}
			$divOptions = $this->addClass($divOptions, 'control-group');
			if (!isset($divOptions['tag'])) {
				$divOptions['tag'] = 'div';
			}
		}

		$label = null;
		if (isset($options['label']) && $options['type'] !== 'radio') {
			$label = $options['label'];
			unset($options['label']);
		}

		if ($options['type'] === 'radio') {
			$label = false;
			if (isset($options['options'])) {
				$radioOptions = (array)$options['options'];
				unset($options['options']);
			}
		}

		if ($label !== false) {
			if (is_string($label)) {
				$label = array('text' => $label);
			}
			$label['class'] = 'control-label';
			$label = parent::_inputLabel($fieldName, $label, $options);
		}

		$error = $this->_extractOption('error', $options, null);
		unset($options['error']);

		$selected = $this->_extractOption('selected', $options, null);
		unset($options['selected']);

		if (isset($options['rows']) || isset($options['cols'])) {
			$options['type'] = 'textarea';
		}

		if ($options['type'] === 'datetime' || $options['type'] === 'date' || $options['type'] === 'time' || $options['type'] === 'select') {
			$options += array('empty' => false);
		}
		if ($options['type'] === 'datetime' || $options['type'] === 'date' || $options['type'] === 'time') {
			$dateFormat = $this->_extractOption('dateFormat', $options, 'MDY');
			$timeFormat = $this->_extractOption('timeFormat', $options, 12);
			unset($options['dateFormat'], $options['timeFormat']);
		}

		$type = $options['type'];
		$out = array_merge(
			array('before' => null, 'label' => null, 'between' => null, 'input' => null, 'after' => null, 'error' => null),
			array('before' => $options['before'], 'label' => $label, 'between' => $options['between'], 'after' => $options['after'])
		);
		$format = null;
		if (is_array($options['format']) && in_array('input', $options['format'])) {
			$format = $options['format'];
		}
		unset($options['type'], $options['before'], $options['between'], $options['after'], $options['format']);

		switch ($type) {
			case 'hidden':
				$input = $this->hidden($fieldName, $options);
				$format = array('input');
				unset($divOptions);
			break;
			case 'checkbox':
				$input = $this->checkbox($fieldName, $options);
				$format = $format ? $format : array('before', 'input', 'between', 'label', 'after', 'error');
			break;
			case 'radio':
				if (isset($out['between'])) {
					$options['between'] = $out['between'];
					$out['between'] = null;
				}
				$input = $this->radio($fieldName, $radioOptions, $options);
			break;
			case 'file':
				$input = $this->file($fieldName, $options);
			break;
			case 'select':
				$options += array('options' => array(), 'value' => $selected);
				$list = $options['options'];
				unset($options['options']);
				$input = $this->select($fieldName, $list, $options);
			break;
			case 'time':
				$options['value'] = $selected;
				$input = $this->dateTime($fieldName, null, $timeFormat, $options);
			break;
			case 'date':
				$options['value'] = $selected;
				$input = $this->dateTime($fieldName, $dateFormat, null, $options);
			break;
			case 'datetime':
				$options['value'] = $selected;
				$input = $this->dateTime($fieldName, $dateFormat, $timeFormat, $options);
			break;
			case 'textarea':
				$input = $this->textarea($fieldName, $options + array('cols' => '30', 'rows' => '6'));
			break;
			case 'url':
				$input = $this->text($fieldName, array('type' => 'url') + $options);
			break;
			default:
				$input = $this->{$type}($fieldName, $options);
		}

		if ($type != 'hidden' && $error !== false) {
			$errMsg = $this->error($fieldName, $error);
			if ($errMsg) {
				$divOptions = $this->addClass($divOptions, 'error');
				$out['error'] = $errMsg;
			}
		}

		$out['input'] = $this->Html->tag('div', $input, array('class' => 'controls'));
		$format = $format ? $format : array('before', 'label', 'between', 'input', 'after', 'error');
		$output = '';
		foreach ($format as $element) {
			$output .= $out[$element];
			unset($out[$element]);
		}

		if (!empty($divOptions['tag'])) {
			$tag = $divOptions['tag'];
			unset($divOptions['tag']);
			$output = $this->Html->tag($tag, $output, $divOptions);
		}
		return $output;
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
	 * Creates a button wrapped in a form to submit data put, post or delete
	 *
	 * @access public
	 * @param string $title
	 * @param mixed $url
	 * @param array $options
	 * @return string
	 */
	public function postButton($title, $url, $options = array()) {
		$options = $this->BootstrapInfo->button($options);
		return parent::postButton($title, $url, $options);
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

}
