<?php


namespace Agrism\PhpHtml\Table;


use Agrism\PhpHtml\Builder\Element;
use Agrism\PhpHtml\Table\Traits\Factory;

class Cell
{
	use Factory;

	/*** @var mixed */
	private $content;

	private $cellType = 'td';

	/**
	 * @param  Element  $content
	 * @return $this
	 */
	public function addContent(Element $content): self
	{
		$this->content[] = $content;

		return $this;
	}

	/*** @return mixed */
	public function getContent()
	{
		return $this->content;
	}

	/*** @return $this */
	public function setCellTypeToHead(): self
	{
		$this->cellType = 'th';

		return $this;
	}

	/*** @return Element */
	public function getElement(): Element
	{
		$element = Element::factory($this->cellType);

		foreach ($this->content as $content) {
			$element->addContent(
				$content
			);
		}

		return $element;
	}
}