<?php

App::uses('Controller', 'Controller');
App::uses('Helper', 'View');
App::uses('AppHelper', 'View/Helper');
App::uses('BootstrapHelper', 'TwitterBootstrap.View/Helper');

if (!defined('FULL_BASE_URL')) {
	define('FULL_BASE_URL', 'http://cakephp.org');
}

class TestBootstrapController extends Controller {
	public $name = 'TestBootstrap';
	public $uses = null;
}

class TestBootstrapHelper extends BootstrapHelper {
	/**
	 * expose a method as public
	 */
	public function parseAttributes($options, $exclude = null, $insertBefore = ' ', $insertAfter = null) {
		return $this->_parseAttributes($options, $exclude, $insertBefore, $insertAfter);
	}

	/**
	 * Get a protected attribute value
	 */
	public function getAttribute($attribute) {
		if (!isset($this->{$attribute})) {
			return null;
		}
		return $this->{$attribute};
	}

	/**
	 * Overwriting method to return a static string.
	 */
	public function _flash_content($key) {
		return "Flash content";
	}
}

class BootstrapHelperTest extends CakeTestCase {

	public $Bootstrap;
	public $View;

	public function setUp() {
		parent::setUp();
		$this->View = $this->getMock('View', array('append'), array(new TestBootstrapController()));
		$this->Bootstrap = new TestBootstrapHelper($this->View);
		Configure::write('Asset.timestamp', false);
	}

	public function tearDown() {
		parent::tearDown();
		unset($this->Bootstrap, $this->View);
	}

	public function testPageHeader() {
		$expected = array(
			array("div" => array("class" => "page-header")),
			array("h1" => true), "Page Header", "/h1",
			"/div"
		);
		$header = $this->Bootstrap->pageHeader("Page Header");
		$this->assertTags($header, $expected);
	}

	public function testValidLabels() {
		$expected = array(
			"span" => array("class" => "label"),
			"Message",
			"/span"
		);
		$default = $this->Bootstrap->label("Message");
		$this->assertTags($default, $expected);
		$expected = array(
			"span" => array("class" => "label label-success"),
			"Message",
			"/span"
		);
		$success = $this->Bootstrap->label("Message", "success");
		$this->assertTags($success, $expected);
		$expected = array(
			"span" => array("class" => "label label-warning"),
			"Message",
			"/span"
		);
		$warning = $this->Bootstrap->label("Message", "warning");
		$this->assertTags($warning, $expected);
		$expected = array(
			"span" => array("class" => "label label-important"),
			"Message",
			"/span"
		);
		$important = $this->Bootstrap->label("Message", "important");
		$this->assertTags($important, $expected);
		$expected = array(
			"span" => array("class" => "label label-info"),
			"Message",
			"/span"
		);
		$notice = $this->Bootstrap->label("Message", "info");
		$this->assertTags($notice, $expected);
		$expected = array(
			"span" => array("class" => "label label-inverse"),
			"Message",
			"/span"
		);
		$inverse = $this->Bootstrap->label("Message", "inverse");
		$this->assertTags($inverse, $expected);
	}

	public function testValidLabelsWithCustomClass() {
		$expected = array(
			"span" => array("class" => "label custom-class"),
			"Message",
			"/span"
		);
		$default = $this->Bootstrap->label("Message", null, array("class" => "custom-class"));
		$this->assertTags($default, $expected);
		$expected = array(
			"span" => array("class" => "label label-success custom-class"),
			"Message",
			"/span"
		);
		$success = $this->Bootstrap->label("Message", "success", array("class" => "custom-class"));
		$this->assertTags($success, $expected);
		$expected = array(
			"span" => array("class" => "label label-warning custom-class"),
			"Message",
			"/span"
		);
		$warning = $this->Bootstrap->label("Message", "warning", array("class" => "custom-class"));
		$this->assertTags($warning, $expected);
		$expected = array(
			"span" => array("class" => "label label-important custom-class"),
			"Message",
			"/span"
		);
		$important = $this->Bootstrap->label("Message", "important", array("class" => "custom-class"));
		$this->assertTags($important, $expected);
		$expected = array(
			"span" => array("class" => "label label-info custom-class"),
			"Message",
			"/span"
		);
		$notice = $this->Bootstrap->label("Message", "info", array("class" => "custom-class"));
		$this->assertTags($notice, $expected);
		$expected = array(
			"span" => array("class" => "label label-inverse custom-class"),
			"Message",
			"/span"
		);
		$inverse = $this->Bootstrap->label("Message", "inverse", array("class" => "custom-class"));
		$this->assertTags($inverse, $expected);
	}

	public function testInvalidLabel() {
		$expected = array("span" => array("class" => "label"), "Message", "/span");
		// Returns default label when passed invalid string
		$invalid_string = $this->Bootstrap->label("Message", "invalid");
		$this->assertTags($invalid_string, $expected);
		// Returns default label when passed invalid int
		$invalid_int = $this->Bootstrap->label("Message", 12);
		$this->assertTags($invalid_int, $expected);
	}

	public function testValidBadge() {
		$expected = array("span" => array("class" => "badge"), 1, "/span");
		$badge = $this->Bootstrap->badge(1);
		$this->assertTags($badge, $expected);

		$expected = array("span" => array("class" => "badge badge-success"), 1, "/span");
		$badge = $this->Bootstrap->badge(1, "success");
		$this->assertTags($badge, $expected);

		$expected = array("span" => array("class" => "badge badge-warning"), 1, "/span");
		$badge = $this->Bootstrap->badge(1, "warning");
		$this->assertTags($badge, $expected);

		$expected = array("span" => array("class" => "badge badge-important"), 1, "/span");
		$badge = $this->Bootstrap->badge(1, "important");
		$this->assertTags($badge, $expected);

		$expected = array("span" => array("class" => "badge badge-info"), 1, "/span");
		$badge = $this->Bootstrap->badge(1, "info");
		$this->assertTags($badge, $expected);

		$expected = array("span" => array("class" => "badge badge-inverse"), 1, "/span");
		$badge = $this->Bootstrap->badge(1, "inverse");
		$this->assertTags($badge, $expected);
	}

	public function testValidBadgeWithCustomClass() {
		$expected = array(
			"span" => array("class" => "badge custom-class"),
			1,
			"/span"
		);
		$badge = $this->Bootstrap->badge(1, null, array("class" => "custom-class"));
		$this->assertTags($badge, $expected);

		$expected = array(
			"span" => array("class" => "badge badge-success custom-class"),
			1,
			"/span"
		);
		$badge = $this->Bootstrap->badge(1, "success", array("class" => "custom-class"));
		$this->assertTags($badge, $expected);

		$expected = array(
			"span" => array("class" => "badge badge-warning custom-class"),
			1,
			"/span"
		);
		$badge = $this->Bootstrap->badge(1, "warning", array("class" => "custom-class"));
		$this->assertTags($badge, $expected);

		$expected = array(
			"span" => array("class" => "badge badge-important custom-class"),
			1,
			"/span"
		);
		$badge = $this->Bootstrap->badge(1, "important", array("class" => "custom-class"));
		$this->assertTags($badge, $expected);

		$expected = array(
			"span" => array("class" => "badge badge-info custom-class"),
			1,
			"/span"
		);
		$badge = $this->Bootstrap->badge(1, "info", array("class" => "custom-class"));
		$this->assertTags($badge, $expected);

		$expected = array(
			"span" => array("class" => "badge badge-inverse custom-class"),
			1,
			"/span"
		);
		$badge = $this->Bootstrap->badge(1, "inverse", array("class" => "custom-class"));
		$this->assertTags($badge, $expected);
	}

	public function testInvalidBadge() {
		$expected = array("span" => array("class" => "badge"), 1, "/span");
		$badge = $this->Bootstrap->badge(1, "invalid");
		$this->assertTags($badge, $expected);
	}

	public function testProgressBar() {
		$expected = array(
			array("div" => array("class" => "progress")),
			array("div" => array("class" => "bar", "style" => "width: 60%;")),
			array("/div" => true),
			array("/div" => true)
		);
		$progress = $this->Bootstrap->progress(array("width" => 60));
		$this->assertTags($progress, $expected);

		$expected = array(
			array("div" => array("class" => "progress progress-info progress-striped")),
			array("div" => array("class" => "bar", "style" => "width: 60%;")),
			array("/div" => true),
			array("/div" => true)
		);
		$progress = $this->Bootstrap->progress(array(
			"width" => 60,
			"style" => "info",
			"striped" => true
		));
		$this->assertTags($progress, $expected);

		$expected = array(
			array("div" => array("class" => "progress progress-success progress-striped active")),
			array("div" => array("class" => "bar", "style" => "width: 60%;")),
			array("/div" => true),
			array("/div" => true)
		);
		$progress = $this->Bootstrap->progress(array(
			"width" => 60,
			"style" => "success",
			"striped" => true,
			"active" => true
		));
		$this->assertTags($progress, $expected);

		$expected = array(
			array("div" => array("class" => "progress progress-warning")),
			array("div" => array("class" => "bar", "style" => "width: 60%;")),
			array("/div" => true),
			array("/div" => true)
		);
		$progress = $this->Bootstrap->progress(array(
			"width" => 60,
			"style" => "warning"
		));
		$this->assertTags($progress, $expected);

		$expected = array(
			array("div" => array("class" => "progress progress-danger")),
			array("div" => array("class" => "bar", "style" => "width: 60%;")),
			array("/div" => true),
			array("/div" => true)
		);
		$progress = $this->Bootstrap->progress(array(
			"width" => 60,
			"style" => "danger"
		));
		$this->assertTags($progress, $expected);
	}

	public function testIcon() {
		$expected = '<i class="icon-test"></i>';
		$result = $this->Bootstrap->icon("test");
		$this->assertEquals($result, $expected);

		$expected = '<i class="icon-test icon-white"></i>';
		$result = $this->Bootstrap->icon("test", "white");
		$this->assertEquals($result, $expected);
	}

	public function testValidFlash() {
		$expected = array(
			'div' => array('class' => 'alert alert-warning'),
			'Flash content',
			'/div'
		);

		$result = $this->Bootstrap->flash();
		$this->assertTags($result, $expected);

		$result = $this->Bootstrap->flash("flash");
		$this->assertTags($result, $expected);

		$result = $this->Bootstrap->flash("warning");
		$this->assertTags($result, $expected);

		$expected['div']['class'] = 'alert alert-info';
		$result = $this->Bootstrap->flash("info");
		$this->assertTags($result, $expected);

		$expected['div']['class'] = 'alert alert-success';
		$result = $this->Bootstrap->flash("success");
		$this->assertTags($result, $expected);

		$expected['div']['class'] = 'alert alert-error';
		$result = $this->Bootstrap->flash("error");
		$this->assertTags($result, $expected);

		$expected['div']['class'] = 'alert alert-error';
		$result = $this->Bootstrap->flash("auth");
		$this->assertTags($result, $expected);
	}

	public function testClosableFlash() {
		$expected = array(
			'div' => array('class' => 'alert alert-warning'),
			'a' => array("data-dismiss" => "alert", "class" => "close"), 'preg:/&times;/', '/a',
			'Flash content',
			'/div'
		);

		$result = $this->Bootstrap->flash("flash", array("closable" => true));
		$this->assertTags($result, $expected);

		$expected['div']['class'] = 'alert alert-info';
		$result = $this->Bootstrap->flash("info", array("closable" => true));
		$this->assertTags($result, $expected);
	}

	public function testInvalidFlash() {
		$expected = array(
			'div' => array('class' => 'alert alert-warning invalid'),
			'Flash content',
			'/div'
		);

		$result = $this->Bootstrap->flash("invalid");
		$this->assertTags($result, $expected);
	}

	public function testFlashes() {
		$keys = array("info", "success", "error", "warning", "warning");
		$tmpl = '<div class="alert alert-%s">Flash content</div>';

		$expected = '';
		foreach ($keys as $key) {
			$expected .= sprintf($tmpl, $key);
		}
		$flashes = $this->Bootstrap->flashes();
		$this->assertEquals($flashes, $expected);

		$keys[] = "error";
		$expected = '';
		foreach ($keys as $key) {
			$expected .= sprintf($tmpl, $key);
		}
		$flashes = $this->Bootstrap->flashes(array("auth" => true));
		$this->assertEquals($flashes, $expected);
	}

	public function testValidBlock() {
		$expected = array(
			'div' => array('class' => 'alert alert-block'),
			'Message content',
			'/div'
		);

		$result = $this->Bootstrap->block("Message content");
		$this->assertTags($result, $expected);

		$expected['div']['class'] = 'alert alert-block alert-info';
		$result = $this->Bootstrap->block(
			"Message content",
			array("style" => "info")
		);
		$this->assertTags($result, $expected);

		$expected['div']['class'] = 'alert alert-block alert-success';
		$result = $this->Bootstrap->block(
			"Message content",
			array("style" => "success")
		);
		$this->assertTags($result, $expected);

		$expected['div']['class'] = 'alert alert-block alert-error';
		$result = $this->Bootstrap->block(
			"Message content",
			array("style" => "error")
		);
		$this->assertTags($result, $expected);

		$expected['div']['class'] = 'alert alert-block';
		$result = $this->Bootstrap->block(
			"Message content",
			array("style" => "warning")
		);
		$this->assertTags($result, $expected);

		$expected = array(
			'div' => array('class' => 'alert alert-block'),
			'h4' => array('class' => 'alert-heading'), 'Block Heading', '/h4',
			'Message content',
			'/div'
		);
		$result = $this->Bootstrap->block(
			"Message content",
			array("heading" => "Block Heading")
		);
		$this->assertTags($result, $expected);
	}

	public function testClosableBlock() {
		$expected = '<div class="alert alert-block alert-info"><a class="close" data-dismiss="alert">&times;</a>Message content</div>';
		$result = $this->Bootstrap->block(
			"Message content",
			array("closable" => true, "style" => "info")
		);
		$this->assertEquals($result, $expected);
	}

}
