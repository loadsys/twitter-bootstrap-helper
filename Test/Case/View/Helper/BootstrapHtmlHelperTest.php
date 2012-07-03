<?php

App::uses('Controller', 'Controller');
App::uses('Helper', 'View');
App::uses('AppHelper', 'View/Helper');
App::uses('BootstrapHtmlHelper', 'TwitterBootstrap.View/Helper');

if (!defined('FULL_BASE_URL')) {
	define('FULL_BASE_URL', 'http://cakephp.org');
}

class TestBootstrapHtmlController extends Controller {
	public $name = 'TestBootstrap';
	public $uses = null;
}

class TestBootstrapHtmlHelper extends BootstrapHtmlHelper {
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

class BootstrapHtmlHelperTest extends CakeTestCase {

	public $BootstrapHtml;
	public $View;

	public function setUp() {
		parent::setUp();
		$this->View = $this->getMock('View', array('append'), array(new TestBootstrapHtmlController()));
		$this->BootstrapHtml = new TestBootstrapHtmlHelper($this->View);
		Configure::write('Asset.timestamp', false);
	}

	public function tearDown() {
		parent::tearDown();
		unset($this->Bootstrap, $this->View);
	}

	public function testButtonDropDownMenus() {
		$expected = array(
			"div" => array("class" => "btn-group"),
			array("button" => array(
				"class" => "btn dropdown-toggle", "data-toggle" => "dropdown"
			)),
			"Button Text",
			"span" => array("class" => "caret"),
			"/span",
			array("/button" => true),
			"ul" => array("class" => "dropdown-menu"),
			array("li" => true),
			array("a" => array("href" => "#")),
			"Link 1",
			array("/a" => true),
			array("/li" => true),
			array("li" => true),
			array("a" => array("href" => "#")),
			"Link 2",
			array("/a" => true),
			array("/li" => true),
			"/ul",
			"/div"
		);
		$button = $this->BootstrapHtml->buttonDropdown(
			"Button Text",
			array(
				"links" => array(
					array("Link 1", "#"),
					array("Link 2", "#")
				)
			)
		);
		$this->assertTags($button, $expected);
	}

	public function testButtonDropDownMenusSkipInvalidLinks() {
		$expected = array(
			"div" => array("class" => "btn-group"),
			array("button" => array(
				"class" => "btn dropdown-toggle", "data-toggle" => "dropdown"
			)),
			"Button Text",
			"span" => array("class" => "caret"),
			"/span",
			array("/button" => true),
			"ul" => array("class" => "dropdown-menu"),
			array("li" => true),
			array("a" => array("href" => "#")),
			"Link 1",
			array("/a" => true),
			array("/li" => true),
			array("li" => true),
			array("a" => array("href" => "#")),
			"Link 2",
			array("/a" => true),
			array("/li" => true),
			"/ul",
			"/div"
		);
		$button = $this->BootstrapHtml->buttonDropdown(
			"Button Text",
			array(
				"links" => array(
					array("Link 1", "#"),
					$this->BootstrapHtml->link("Link 2", "#"),
					array("key" => "value"),
					array("Link 3", "key" => "value")
				)
			)
		);
		$this->assertTags($button, $expected);
	}

	public function testSplitButtonDropDownMenus() {
		$expected = array(
			"div" => array("class" => "btn-group"),
			array("button" => array(
				"class" => "btn"
			)),
			"Button Text",
			array("/button" => true),
			array("button" => array(
				"class" => "btn dropdown-toggle", "data-toggle" => "dropdown"
			)),
			"span" => array("class" => "caret"),
			"/span",
			array("/button" => true),
			"ul" => array("class" => "dropdown-menu"),
			array("li" => true),
			array("a" => array("href" => "#")),
			"Link 1",
			array("/a" => true),
			array("/li" => true),
			array("li" => true),
			array("a" => array("href" => "#")),
			"Link 2",
			array("/a" => true),
			array("/li" => true),
			"/ul",
			"/div"
		);
		$button = $this->BootstrapHtml->buttonDropdown(
			"Button Text",
			array(
				"split" => true,
				"links" => array(
					array("Link 1", "#"),
					array("Link 2", "#")
				)
			)
		);
		$this->assertTags($button, $expected);
	}

	public function testButtonDropDownMenusStyles() {
		$expected = array(
			"div" => array("class" => "btn-group"),
			array("button" => array(
				"class" => "btn btn-primary dropdown-toggle", "data-toggle" => "dropdown"
			)),
			"Button Text",
			"span" => array("class" => "caret"),
			"/span",
			array("/button" => true),
			"ul" => array("class" => "dropdown-menu"),
			array("li" => true),
			array("a" => array("href" => "#")),
			"Link 1",
			array("/a" => true),
			array("/li" => true),
			array("li" => true),
			array("a" => array("href" => "#")),
			"Link 2",
			array("/a" => true),
			array("/li" => true),
			"/ul",
			"/div"
		);
		$button = $this->BootstrapHtml->buttonDropdown(
			"Button Text",
			array(
				"style" => "primary",
				"links" => array(
					array("Link 1", "#"),
					array("Link 2", "#")
				)
			)
		);
		$this->assertTags($button, $expected);
	}

	public function testButtonDropDownMenusSizes() {
		$expected = array(
			"div" => array("class" => "btn-group"),
			array("button" => array(
				"class" => "btn btn-large dropdown-toggle", "data-toggle" => "dropdown"
			)),
			"Button Text",
			"span" => array("class" => "caret"),
			"/span",
			array("/button" => true),
			"ul" => array("class" => "dropdown-menu"),
			array("li" => true),
			array("a" => array("href" => "#")),
			"Link 1",
			array("/a" => true),
			array("/li" => true),
			array("li" => true),
			array("a" => array("href" => "#")),
			"Link 2",
			array("/a" => true),
			array("/li" => true),
			"/ul",
			"/div"
		);
		$button = $this->BootstrapHtml->buttonDropdown(
			"Button Text",
			array(
				"size" => "large",
				"links" => array(
					array("Link 1", "#"),
					array("Link 2", "#")
				)
			)
		);
		$this->assertTags($button, $expected);
	}

	public function testButtonDropDownMenusWithDivider() {
		$expected = array(
			"div" => array("class" => "btn-group"),
			array("button" => array(
				"class" => "btn btn-danger dropdown-toggle", "data-toggle" => "dropdown"
			)),
			"Button Text",
			"span" => array("class" => "caret"),
			"/span",
			array("/button" => true),
			"ul" => array("class" => "dropdown-menu"),
			array("li" => true),
			array("a" => array("href" => "#")),
			"Link 1",
			array("/a" => true),
			array("/li" => true),
			array("li" => array("class" => "divider")),
			array("/li" => true),
			array("li" => true),
			array("a" => array("href" => "#")),
			"Link 2",
			array("/a" => true),
			array("/li" => true),
			"/ul",
			"/div"
		);
		$button = $this->BootstrapHtml->buttonDropdown(
			"Button Text",
			array(
				"style" => "danger",
				"links" => array(
					array("Link 1", "#"),
					null,
					array("Link 2", "#")
				)
			)
		);
		$this->assertTags($button, $expected);
	}

	public function testButtonDropUpMenus() {
		$expected = array(
			"div" => array("class" => "btn-group dropup"),
			array("button" => array(
				"class" => "btn btn-danger dropdown-toggle", "data-toggle" => "dropdown"
			)),
			"Button Text",
			"span" => array("class" => "caret"),
			"/span",
			array("/button" => true),
			"ul" => array("class" => "dropdown-menu"),
			array("li" => true),
			array("a" => array("href" => "#")),
			"Link 1",
			array("/a" => true),
			array("/li" => true),
			array("li" => array("class" => "divider")),
			array("/li" => true),
			array("li" => true),
			array("a" => array("href" => "#")),
			"Link 2",
			array("/a" => true),
			array("/li" => true),
			"/ul",
			"/div"
		);
		$button = $this->BootstrapHtml->buttonDropdown(
			"Button Text",
			array(
				"style" => "danger",
				"dropup" => true,
				"links" => array(
					array("Link 1", "#"),
					null,
					array("Link 2", "#")
				)
			)
		);
		$this->assertTags($button, $expected);
	}

	public function testButtonDropDownRightMenus() {
		$expected = array(
			"div" => array("class" => "btn-group"),
			array("button" => array(
				"class" => "btn btn-warning dropdown-toggle", "data-toggle" => "dropdown"
			)),
			"Button Text",
			"span" => array("class" => "caret"),
			"/span",
			array("/button" => true),
			"ul" => array("class" => "dropdown-menu pull-right"),
			array("li" => true),
			array("a" => array("href" => "#")),
			"Link 1",
			array("/a" => true),
			array("/li" => true),
			array("li" => array("class" => "divider")),
			array("/li" => true),
			array("li" => true),
			array("a" => array("href" => "#")),
			"Link 2",
			array("/a" => true),
			array("/li" => true),
			"/ul",
			"/div"
		);
		$button = $this->BootstrapHtml->buttonDropdown(
			"Button Text",
			array(
				"style" => "warning",
				"right" => true,
				"links" => array(
					array("Link 1", "#"),
					null,
					array("Link 2", "#")
				)
			)
		);
		$this->assertTags($button, $expected);
	}

	public function testButtonDropUpRightMenus() {
		$expected = array(
			"div" => array("class" => "btn-group dropup"),
			array("button" => array(
				"class" => "btn btn-warning dropdown-toggle", "data-toggle" => "dropdown"
			)),
			"Button Text",
			"span" => array("class" => "caret"),
			"/span",
			array("/button" => true),
			"ul" => array("class" => "dropdown-menu pull-right"),
			array("li" => true),
			array("a" => array("href" => "#")),
			"Link 1",
			array("/a" => true),
			array("/li" => true),
			array("li" => array("class" => "divider")),
			array("/li" => true),
			array("li" => true),
			array("a" => array("href" => "#")),
			"Link 2",
			array("/a" => true),
			array("/li" => true),
			"/ul",
			"/div"
		);
		$button = $this->BootstrapHtml->buttonDropdown(
			"Button Text",
			array(
				"style" => "warning",
				"right" => true,
				"dropup" => true,
				"links" => array(
					array("Link 1", "#"),
					null,
					array("Link 2", "#")
				)
			)
		);
		$this->assertTags($button, $expected);
	}

	public function testValidButtonLinks() {
		$expected = array(
			'a' => array(
				'href' => '/home',
				'class' => 'preg:/btn/'
			),
			'preg:/Link Text/',
			'/a'
		);
		$result = $this->BootstrapHtml->buttonLink("Link Text", "/home");
		$this->assertTags($result, $expected);

		$result = $this->BootstrapHtml->buttonLink(
			"Link Text",
			"/home",
			array("size" => "large")
		);
		$expected["a"]["class"] = 'preg:/btn btn-large/';
		$this->assertTags($result, $expected);

		$result = $this->BootstrapHtml->buttonLink(
			"Link Text",
			"/home",
			array("style" => "info")
		);
		$expected["a"]["class"] = 'preg:/btn btn-info/';
		$this->assertTags($result, $expected);

		$result = $this->BootstrapHtml->buttonLink(
			"Link Text",
			"/home",
			array("style" => "info", "size" => "mini")
		);
		$expected["a"]["class"] = 'preg:/btn btn-info btn-mini/';
		$this->assertTags($result, $expected);

		$result = $this->BootstrapHtml->buttonLink(
			"Link Text",
			"/home",
			array("style" => "info", "size" => "small", "class" => "some-class")
		);
		$expected["a"]["class"] = 'preg:/some-class btn btn-info btn-small/';
		$this->assertTags($result, $expected);

		$result = $this->BootstrapHtml->buttonLink(
			"Link Text",
			"/home",
			array("style" => "info", "size" => "small", "disabled" => true)
		);
		$expected["a"]["class"] = 'preg:/btn btn-info btn-small disabled/';
		$this->assertTags($result, $expected);
	}

	public function testBreadCrumbs() {
		$expected = array(
			"ul" => array("class" => "breadcrumb"),
			array("li" => true),
			array("a" => array("href" => "/")), "Home", "/a",
			array("span" => array("class" => "divider")),
			"preg:/\//",
			"/span",
			"/li",
			array("li" => array("class" => "active")),
			array("a" => array("href" => "/sub")), "Subpage", "/a",
			"/li",
			"/ul"
		);
		$this->BootstrapHtml->addCrumb("Home", "/");
		$this->BootstrapHtml->addCrumb("Subpage", "/sub");
		$results = $this->BootstrapHtml->breadcrumbs();
		$this->assertTags($results, $expected);
	}

	public function testBreadCrumbsWithOptions() {
		$expected = array(
			"ul" => array("class" => "custom-class breadcrumb"),
			array("li" => true),
			array("a" => array("href" => "/")), "Home", "/a",
			array("span" => array("class" => "divider")),
			"preg:/%/",
			"/span",
			"/li",
			array("li" => array("class" => "active")),
			array("a" => array("href" => "/sub")), "Subpage", "/a",
			"/li",
			"/ul"
		);
		$this->BootstrapHtml->addCrumb("Home", "/");
		$this->BootstrapHtml->addCrumb("Subpage", "/sub");
		$results = $this->BootstrapHtml->breadcrumbs(array(
			"class" => "custom-class",
			"divider" => "%"
		));
		$this->assertTags($results, $expected);
	}

}
