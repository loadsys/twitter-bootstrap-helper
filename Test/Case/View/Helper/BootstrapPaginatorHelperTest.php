<?php

App::uses('View', 'View');
App::uses('HtmlHelper', 'View/Helper');
App::uses('JsHelper', 'View/Helper');
App::uses('BootstrapPaginatorHelper', 'TwitterBootstrap.View/Helper');
App::uses('FormHelper', 'View/Helper');

if (!defined('FULL_BASE_URL')) {
	define('FULL_BASE_URL', 'http://cakephp.org');
}

class BootstrapPaginatorHelperTest extends CakeTestCase {

	public $BootstrapPaginator;
	public $View;

	public function setUp() {
		$controller = null;
		$this->View = new View($controller);
		$this->BootstrapPaginator = new BootstrapPaginatorHelper($this->View);
		$this->BootstrapPaginator->Js = $this->getMock('PaginatorHelper', array(), array($this->View));
		$this->BootstrapPaginator->request = new CakeRequest(null, false);
		$this->BootstrapPaginator->request->addParams(array(
			'paging' => array(
				'Article' => array(
					'page' => 2,
					'current' => 9,
					'count' => 62,
					'prevPage' => false,
					'nextPage' => true,
					'pageCount' => 7,
					'order' => null,
					'limit' => 20,
					'options' => array(
						'page' => 1,
						'conditions' => array()
					),
					'paramType' => 'named'
				)
			)
		));
		$this->BootstrapPaginator->Html = new HtmlHelper($this->View);

		Configure::write('Routing.prefixes', array());
		Router::reload();
	}

	public function tearDown() {
		unset($this->View, $this->Paginator);
	}	

	public function testNext() {
		$expected = array(
			'a' => array('href' => '/index/page:3', 'rel' => 'next'),
			'&gt;',
			'/a'
		);
		$this->assertTags($this->BootstrapPaginator->next(), $expected);
	}

	public function testNextWhenOnLastPage() {
		$this->BootstrapPaginator->request->params['paging']['Article']['nextPage'] = false;
		$expected = array(
			'a' => array('href' => '#', 'rel' => 'next', 'class' => 'disabled'),
			'&gt;',
			'/a'
		);
		$this->assertTags($this->BootstrapPaginator->next(), $expected);
		$this->BootstrapPaginator->request->params['paging']['Article']['nextPage'] = true;
	}

	public function testPrev() {
		$this->BootstrapPaginator->request->params['paging']['Article']['prevPage'] = true;
		$expected = array(
			'a' => array('href' => '/index/page:1', 'rel' => 'prev'),
			'&lt;',
			'/a'
		);
		$this->assertTags($this->BootstrapPaginator->prev(), $expected);
		$this->BootstrapPaginator->request->params['paging']['Article']['prevPage'] = false;
	}

	public function testPrevWhenOnFirstPage() {
		$expected = array(
			'a' => array('href' => '#', 'rel' => 'prev', 'class' => 'disabled'),
			'&lt;',
			'/a'
		);
		$this->assertTags($this->BootstrapPaginator->prev(), $expected);
	}

	public function testFirst() {
		$expected = array(
			'a' => array('href' => '/index/page:1', 'rel' => 'first'),
			'&lt;&lt;',
			'/a'
		);
		$this->assertTags($this->BootstrapPaginator->first(), $expected);
	}

	public function testFirstWhenOnFirstPage() {

	}

	public function testLast() {
		$expected = array(
			'a' => array('href' => '/index/page:7', 'rel' => 'last'),
			'&gt;&gt;',
			'/a'
		);
		$this->assertTags($this->BootstrapPaginator->last(), $expected);
	}

	public function testLastWhenOnLastPage() {

	}

	public function testNumbers() {
		$expected = '<span><a href="/index/page:1">1</a></a></span><span><a href="#" class="active">2</a></span><span><a href="/index/page:3">3</a></a></span><span><a href="/index/page:4">4</a></a></span><span><a href="/index/page:5">5</a></a></span><span><a href="/index/page:6">6</a></a></span><span><a href="/index/page:7">7</a></a></span>';
		$this->assertEquals($expected, $this->BootstrapPaginator->numbers());
	}

	public function testPagination() {
		$expected = '<div class="pagination"><ul><li><a href="#" class="disabled" rel="prev">&lt;</a></li><li><a href="/index/page:1">1</a></a></li><li><a href="#" class="active">2</a></li><li><a href="/index/page:3">3</a></a></li><li><a href="/index/page:4">4</a></a></li><li><a href="/index/page:5">5</a></a></li><li><a href="/index/page:6">6</a></a></li><li><a href="/index/page:7">7</a></a></li><li><a href="/index/page:3" rel="next">&gt;</a></li></ul></div>';
		$this->assertEquals($this->BootstrapPaginator->pagination(), $expected);
	}

	public function testPaginationAlignment() {
		$expected = '<div class="pagination pagination-centered"><ul><li><a href="#" class="disabled" rel="prev">&lt;</a></li><li><a href="/index/page:1">1</a></a></li><li><a href="#" class="active">2</a></li><li><a href="/index/page:3">3</a></a></li><li><a href="/index/page:4">4</a></a></li><li><a href="/index/page:5">5</a></a></li><li><a href="/index/page:6">6</a></a></li><li><a href="/index/page:7">7</a></a></li><li><a href="/index/page:3" rel="next">&gt;</a></li></ul></div>';
		$result = $this->BootstrapPaginator->pagination(array('align' => 'centered'));
		$this->assertEquals($expected, $result);
	}

	public function testPaginationWithFirstAndLast() {
		$expected = '<div class="pagination"><ul><li><a href="/index/page:1" rel="first">&lt;&lt;</a></li><li><a href="#" class="disabled" rel="prev">&lt;</a></li><li><a href="/index/page:1">1</a></a></li><li><a href="#" class="active">2</a></li><li><a href="/index/page:3">3</a></a></li><li><a href="/index/page:4">4</a></a></li><li><a href="/index/page:5">5</a></a></li><li><a href="/index/page:6">6</a></a></li><li><a href="/index/page:7">7</a></a></li><li><a href="/index/page:3" rel="next">&gt;</a></li><li><a href="/index/page:7" rel="last">&gt;&gt;</a></li></ul></div>';
		$result = $this->BootstrapPaginator->pagination(array('full' => true));
		$this->assertEquals($expected, $result);
	}

	public function testPager() {
		$expected = '<ul class="pager"><li><a href="#" class="disabled" rel="prev">&larr; Older</a></li><li><a href="/index/page:3" rel="next">Newer &rarr;</a></li></ul>';
		$this->assertEquals($this->BootstrapPaginator->pager(), $expected);
	}

	public function testPagerAligned() {
		$expected = '<ul class="pager"><li class="previous"><a href="#" class="disabled" rel="prev">&larr; Older</a></li><li class="next"><a href="/index/page:3" rel="next">Newer &rarr;</a></li></ul>';
		$result = $this->BootstrapPaginator->pager(array('align' => true));
		$this->assertEquals($result, $expected);
	}
}
