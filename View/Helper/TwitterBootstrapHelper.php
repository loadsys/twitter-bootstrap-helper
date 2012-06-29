<?php

class TwitterBootstrapHelper extends AppHelper {

	public $helpers = array(
		"TwitterBootstrap.Bootstrap",
		"TwitterBootstrap.BootstrapHtml",
		"TwitterBootstrap.BootstrapForm"
	);

	public function basic_input($field, $options = array()) {
		return $this->BootstrapForm->basic_input($field, $options);
	}

	public function _parse_input_options($field, $options = array()) {
		return $this->BootstrapForm->_parse_input_options($field, $options);
	}

	public function _construct_label($options, $basic = true) {
		return $this->BootstrapForm->_construct_label($options, $basic);
	}

	public function _construct_input($options) {
		return $this->BootstrapForm->_construct_input($options);
	}

	public function _constuct_input_and_addon($options) {
		return $this->BootstrapForm->_constuct_input_and_addon($options);
	}

	public function _handle_input_addon($options) {
		return $this->BootstrapForm->_handle_input_addon($options);
	}

	public function input_addon($content, $input, $type = "append") {
		return $this->BootstrapForm->input_addon($content, $input, $type);
	}

	public function search($name = null, $options = array()) {
		return $this->BootstrapForm->search($name, $options);
	}

	public function input($field, $options = array()) {
		return $this->BootstrapForm->input($field, $options);
	}

	public function _combine_input($options) {
		return $this->BootstrapForm->_combine_input($options);
	}

	public function _help_markup($options) {
		return $this->BootstrapForm->_help_markup($options);
	}

	public function radio($field, $options = array()) {
		return $this->BootstrapForm->radio($field, $options);
	}

	public function button($value = "Submit", $options = array()) {
		return $this->BootstrapForm->button($value, $options);
	}

	public function button_dropdown($value = "", $options = array()) {
		return $this->BootstrapHtml->buttonDropdown($value, $options);
	}

	public function button_link($title, $url, $opt = array(), $confirm = false) {
		return $this->BootstrapHtml->buttonLink($title, $url, $opt, $confirm);
	}

	public function button_form($title, $url, $opt = array(), $confirm = false) {
		return $this->BootstrapForm->buttonForm($title, $url, $opt, $confirm);
	}

	public function button_options($options) {
		return $this->BootstrapForm->button_options($options);
	}

	public function breadcrumbs($options = array()) {
		return $this->BootstrapHtml->breadcrumbs($options);
	}

	public function add_crumb($title, $url, $options = array()) {
		return $this->BootstrapHtml->addCrumb($title, $url, $options);
	}

	public function label($message = "", $style = "", $options = array()) {
		return $this->Bootstrap->label($message, $style, $options);
	}

	public function badge($num = 0, $style = "", $options = array()) {
		return $this->Bootstrap->badge($num, $style, $options);
	}

	public function icon($name, $color = "black") {
		return $this->Bootstrap->icon($name, $color);
	}

	public function progress($options = array()) {
		return $this->Bootstrap->progress($options);
	}

	public function alert($content, $options = array()) {
		return $this->Bootstrap->alert($content, $options);
	}

	public function flash($key = "flash", $options = array()) {
		return $this->Bootstrap->flash($key, $options);
	}

	public function flashes($options = array()) {
		return $this->Bootstrap->flashes($options);
	}

	public function _flash_content($key = "flash") {
		return $this->Bootstrap->_flash_content($key);
	}

	public function block($message = null, $options = array()) {
		return $this->Bootstrap->block($message, $options);
	}

	public function page_header($title){
		return $this->Bootstrap->pageHeader($title);
	}

}
