<?php

require_once(dirname(__FILE__) . '/../../../Lib/BootstrapInfo.php');

class BootstrapInfoTest extends CakeTestCase {

	public function setUp() {
		$this->BootstrapInfo = new BootstrapInfo();
	}

	public function testStylesForAlert() {
		$expected = 'alert';
		$result = $this->BootstrapInfo->stylesFor('alert');
		$this->assertEqual($result, $expected);
		$expected = 'alert alert-success';
		$result = $this->BootstrapInfo->stylesFor('alert', 'success');
		$this->assertEqual($result, $expected);
		$expected = 'alert alert-info';
		$result = $this->BootstrapInfo->stylesFor('alert', 'info');
		$this->assertEqual($result, $expected);
		$expected = 'alert alert-error';
		$result = $this->BootstrapInfo->stylesFor('alert', 'error');
		$this->assertEqual($result, $expected);
	}


	public function testStylesForBadge() {
		$expected = 'badge';
		$result = $this->BootstrapInfo->stylesFor('badge');
		$this->assertEqual($result, $expected);
		$expected = 'badge badge-success';
		$result = $this->BootstrapInfo->stylesFor('badge', 'success');
		$this->assertEqual($result, $expected);
		$expected = 'badge badge-info';
		$result = $this->BootstrapInfo->stylesFor('badge', 'info');
		$this->assertEqual($result, $expected);
		$expected = 'badge badge-error';
		$result = $this->BootstrapInfo->stylesFor('badge', 'error');
		$this->assertEqual($result, $expected);
		$expected = 'badge badge-warning';
		$result = $this->BootstrapInfo->stylesFor('badge', 'warning');
		$this->assertEqual($result, $expected);
		$expected = 'badge badge-inverse';
		$result = $this->BootstrapInfo->stylesFor('badge', 'inverse');
		$this->assertEqual($result, $expected);
	}

	public function testStylesForButton() {
		$expected = 'btn';
		$result = $this->BootstrapInfo->stylesFor('button');
		$this->assertEqual($result, $expected);
		$expected = 'btn btn-success';
		$result = $this->BootstrapInfo->stylesFor('button', 'success');
		$this->assertEqual($result, $expected);
		$expected = 'btn btn-info';
		$result = $this->BootstrapInfo->stylesFor('button', 'info');
		$this->assertEqual($result, $expected);
		$expected = 'btn btn-primary';
		$result = $this->BootstrapInfo->stylesFor('button', 'primary');
		$this->assertEqual($result, $expected);
		$expected = 'btn btn-danger';
		$result = $this->BootstrapInfo->stylesFor('button', 'danger');
		$this->assertEqual($result, $expected);
		$expected = 'btn btn-warning';
		$result = $this->BootstrapInfo->stylesFor('button', 'warning');
		$this->assertEqual($result, $expected);
		$expected = 'btn btn-inverse';
		$result = $this->BootstrapInfo->stylesFor('button', 'inverse');
		$this->assertEqual($result, $expected);
		$expected = 'btn btn-link';
		$result = $this->BootstrapInfo->stylesFor('button', 'link');
		$this->assertEqual($result, $expected);
	}

	public function testStylesForIcon() {
		try {
			$result = $this->BootstrapInfo->stylesFor('icon');
		} catch (Exception $e) {
			$this->assertEqual($e->getMessage(), "Must give an icon to render");
		}
		$expected = 'icon icon-glass';
		$result = $this->BootstrapInfo->stylesFor('icon', 'glass');
		$this->assertEqual($result, $expected);
	}

	public function testStylesForLabel() {
		$expected = 'label';
		$result = $this->BootstrapInfo->stylesFor('label');
		$this->assertEqual($result, $expected);
		$expected = 'label label-success';
		$result = $this->BootstrapInfo->stylesFor('label', 'success');
		$this->assertEqual($result, $expected);
		$expected = 'label label-info';
		$result = $this->BootstrapInfo->stylesFor('label', 'info');
		$this->assertEqual($result, $expected);
		$expected = 'label label-warning';
		$result = $this->BootstrapInfo->stylesFor('label', 'warning');
		$this->assertEqual($result, $expected);
		$expected = 'label label-important';
		$result = $this->BootstrapInfo->stylesFor('label', 'important');
		$this->assertEqual($result, $expected);
		$expected = 'label label-inverse';
		$result = $this->BootstrapInfo->stylesFor('label', 'inverse');
		$this->assertEqual($result, $expected);
	}

	public function testStylesForProgress() {
		$expected = 'progress';
		$result = $this->BootstrapInfo->stylesFor('progress');
		$this->assertEqual($result, $expected);
		$expected = 'progress progress-success';
		$result = $this->BootstrapInfo->stylesFor('progress', 'success');
		$this->assertEqual($result, $expected);
		$expected = 'progress progress-info';
		$result = $this->BootstrapInfo->stylesFor('progress', 'info');
		$this->assertEqual($result, $expected);
		$expected = 'progress progress-warning';
		$result = $this->BootstrapInfo->stylesFor('progress', 'warning');
		$this->assertEqual($result, $expected);
		$expected = 'progress progress-danger';
		$result = $this->BootstrapInfo->stylesFor('progress', 'danger');
		$this->assertEqual($result, $expected);
	}

	public function testSizesForButton() {
		$expected = 'btn';
		$result = $this->BootstrapInfo->sizesFor('button');
		$this->assertEqual($result, $expected);
		$expected = 'btn btn-mini';
		$result = $this->BootstrapInfo->sizesFor('button', 'mini');
		$this->assertEqual($result, $expected);
		$expected = 'btn btn-small';
		$result = $this->BootstrapInfo->sizesFor('button', 'small');
		$this->assertEqual($result, $expected);
		$expected = 'btn btn-large';
		$result = $this->BootstrapInfo->sizesFor('button', 'large');
		$this->assertEqual($result, $expected);
	}

	public function testSizesForInput() {
		$expected = '';
		$result = $this->BootstrapInfo->sizesFor('input');
		$this->assertEqual($result, $expected);
		$expected = 'input-mini';
		$result = $this->BootstrapInfo->sizesFor('input', 'mini');
		$this->assertEqual($result, $expected);
		$expected = 'input-small';
		$result = $this->BootstrapInfo->sizesFor('input', 'small');
		$this->assertEqual($result, $expected);
		$expected = 'input-medium';
		$result = $this->BootstrapInfo->sizesFor('input', 'medium');
		$this->assertEqual($result, $expected);
		$expected = 'input-large';
		$result = $this->BootstrapInfo->sizesFor('input', 'large');
		$this->assertEqual($result, $expected);
		$expected = 'input-xlarge';
		$result = $this->BootstrapInfo->sizesFor('input', 'xlarge');
		$this->assertEqual($result, $expected);
		$expected = 'input-xxlarge';
		$result = $this->BootstrapInfo->sizesFor('input', 'xxlarge');
		$this->assertEqual($result, $expected);
	}

	public function testFilter() {
		$start = "btn btn-success btn btn-small";
		$expected = "btn btn-success btn-small";
		$this->assertEqual($this->BootstrapInfo->_filter($start), $expected);
	}
}
