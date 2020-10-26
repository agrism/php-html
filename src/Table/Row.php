<?php


namespace Agrism\PhpHtml\Table;


use Agrism\PhpHtml\Builder\Attribute;
use Agrism\PhpHtml\Builder\Element;
use Agrism\PhpHtml\Table\Traits\Factory;

class Row
{
	use Factory;

	/*** @var Cell[] */
	private $cells = [];
	/*** @var Attribute[] */
	private $attributes = [];

	/**
	 * @param  Cell  $cell
	 * @return $this
	 */
	public function addCell(Cell $cell): self
	{
		$this->cells[] = $cell;

		return $this;
	}


	public function addAttribute(Attribute $attribute): self
	{
		$this->attributes[] = $attribute;

		return $this;
	}

	/*** @return Cell[] */
	public function getCells(): array
	{
		return $this->cells;
	}

	/*** @return Element */
	public function getElement(): Element
	{
		$row =  Element::factory()->setTagName('tr');

		foreach ($this->cells as $cell){
			$row->addContent($cell->getElement());
		}

		foreach ($this->attributes as $attribute){
			$row->addAttribute($attribute);
		}

		return $row;
	}

}