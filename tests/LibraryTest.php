<?php

use Agrism\PhpHtml\Builder\Attribute;
use Agrism\PhpHtml\Builder\Content;
use Agrism\PhpHtml\Builder\Element;
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
}