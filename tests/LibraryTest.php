<?php

use Agrism\PhpHtml\Attribute;
use Agrism\PhpHtml\Content;
use Agrism\PhpHtml\Element;
use PHPUnit\Framework\TestCase;

class LibraryTest extends TestCase
{
	public function testAbilityToExecuteNativeMethodsFromMainObject()
	{

		$tag = Element::factory('div');
		$result = $tag->setAttribute(new Attribute('foo', 'bar'))
			->setAttribute(new Attribute('name', '123'))
			->setSelfClosing(false)
			->setContent(
				Element::factory()
					->setTagName('p')
					->setContent(
						Element::factory('i')
							->setContent(
								Content::factory()->setValue('uuuuu')
							)
							->setContent(
								Element::factory('input')->setSelfClosing(1)
									->setAttribute(Attribute::factory('type', 'text'))
									->setAttribute(Attribute::factory('value', "12'3456789"))
									->setAttribute(Attribute::factory('placeholder', 'phone'))
							)
					)
			)
			->render()
			->getPrintableOutput();

		$this->assertEquals('<div foo="bar" name="123"><p><i>uuuuu<input type="text" value="12\'3456789" placeholder="phone"/></i></p></div>', $result);

	}
}