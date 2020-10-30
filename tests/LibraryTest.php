<?php

use Agrism\PhpHtml\Builder\Attribute;
use Agrism\PhpHtml\Builder\Content;
use Agrism\PhpHtml\Builder\Element;
use Agrism\PhpHtml\Table\Table;
use PHPUnit\Framework\TestCase;

class LibraryTest extends TestCase
{
	public function testOne()
	{
		$tag = Element::factory('div');
		$result = $tag->addAttribute(new Attribute('foo', 'bar'))
			->addAttribute(new Attribute('name', '123'))
			->setSelfClosing(false)
			->addContent(
				Element::factory('ppp')
					->setTagName('p')
					->addContent(
						Element::factory('i')
							->addContent(
								Element::factory()->addValue('uuuuu')
							)
							->addContent(
								Element::factory('input')->setSelfClosing(1)
									->addAttribute(Attribute::factory('type', 'text'))
									->addAttribute(Attribute::factory('value', "12'3456789"))
									->addAttribute(Attribute::factory('placeholder', 'phone'))
							)
					)
			)
			->render()
			->getPrintableOutput();

		$this->assertEquals('<div foo="bar" name="123"><p><i>uuuuu<input type="text" value="12\'3456789" placeholder="phone"/></i></p></div>',
			$result);
	}

	public function testInsertingTwoTimesSameContentObject()
	{
		$html = Element::factory('html');

		$table = Element::factory('table')
			->addAttribute(Attribute::factory('border')->setValue(1))
			->addContent(
				Element::factory('tr')->addContent(
					Element::factory('td')
						->addContent(
							Element::factory()
								->addValue('A')
								->addValue('B')
								->addValue('C')
						)
						->addContent(
							Element::factory('table')
								->addAttribute(Attribute::factory('border', 3))
								->addAttribute(Attribute::factory('style', 'background-color:red;'))
								->addContent(
									Element::factory('tr')
										->addContent(
											Element::factory('td')
												->addContent(
													Element::factory()->addValue(5)
												)
										)
										->addContent(
											Element::factory('td')
												->addAttribute(Attribute::factory('style', 'background-color:blue;'))
												->addContent(
													Element::factory()->addValue(15)
												)
										)
								)
						)
				)
			);

		$html
			->addContent($table)
			->addContent($table)
			->render()
			->doNothing();

		$resultShouldBe = '<html><table border="1"><tr><td>ABC<table border="3" style="background-color:red;"><tr><td>5</td><td style="background-color:blue;">15</td></tr></table></td></tr></table><table border="1"><tr><td>ABC<table border="3" style="background-color:red;"><tr><td>5</td><td style="background-color:blue;">15</td></tr></table></td></tr></table></html>';

		$this->assertEquals($resultShouldBe, $html->getPrintableOutput());
	}

	public function testTableHelper()
	{
		$actual = Table::factory()
			->addAttribute('border', 13)
			->addRows([
				['p1', 'p2', 'p3'],
				['p11', 'p22', 'p33'],
			], ['style' => 'background-color:yellowgreen;'])
			->addHead(['title1', 'title2', 'title3'], ['border' => 1, 'style' => 'background-color:brown;'])
			->addHead(['title11', 'title22', 'title33'], ['border' => 1, 'style' => 'background-color:blue;'])
			->addRow(['a', 'b', 'c'], ['style' => 'background-color:red;'])
			->addRow(['a1', 'b1', 'c1'], ['style' => 'background-color:yellow;font-size:28px;color:blue;text-align:right'])
			->addRow(['a2', 'b2', 'c2'])
			->getOutput();

		$expected = '<table border="13"><thead><tr border="1" style="background-color:brown;"><th>title1</th><th>title2</th><th>title3</th></tr><tr border="1" style="background-color:blue;"><th>title11</th><th>title22</th><th>title33</th></tr></thead><tbody><tr style="background-color:yellowgreen;"><td>p1</td><td>p2</td><td>p3</td></tr><tr style="background-color:yellowgreen;"><td>p11</td><td>p22</td><td>p33</td></tr><tr style="background-color:red;"><td>a</td><td>b</td><td>c</td></tr><tr style="background-color:yellow;font-size:28px;color:blue;text-align:right"><td>a1</td><td>b1</td><td>c1</td></tr><tr><td>a2</td><td>b2</td><td>c2</td></tr></tbody></table>';

		$this->assertEquals($expected, $actual);
	}

	public function testTableWithNestedTable()
	{
		$nestedTable = Table::factory()
			->addAttribute('border', 13)
			->addRow(['A', 'B'])
			->getOutput();

		$actual = Table::factory()
			->addAttribute('border', 1)
			->addRow([1,2,3, $nestedTable])
			->getOutput();

		$expected = '<table border="1"><thead></thead><tbody><tr><td>1</td><td>2</td><td>3</td><td><table border="13"><thead></thead><tbody><tr><td>A</td><td>B</td></tr></tbody></table></td></tr></tbody></table>';

		$this->assertEquals($expected, $actual);
	}
}