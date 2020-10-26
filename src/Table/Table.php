<?php


namespace Agrism\PhpHtml\Table;

use Agrism\PhpHtml\Builder\Attribute;
use Agrism\PhpHtml\Builder\Element;
use Agrism\PhpHtml\Table\Traits\Factory;


class Table
{
	use Factory;

	/*** @var Row[] */
	private $rows = [];

	/*** @var Attribute[] */
	private $attributes = [];

	/**
	 * @param  string  $key
	 * @param  string  $value
	 * @return $this
	 */
	public function addAttribute(string $key, string $value): self
	{
		$this->attributes[] = Attribute::factory($key, $value);
		return $this;
	}

	/**
	 * @param  array  $rowData
	 * @param  array  $attributes
	 * @return $this
	 */
	public function addHead(array $rowData, array $attributes): self
	{
		$row = Row::factory();

		foreach ($rowData as $celValue) {
			$row->addCell(Cell::factory()->setCellTypeToHead()->addContent(Element::factory()->addValue($celValue)));
		}

		foreach ($attributes as $attributeName => $attributeValue) {
			$row->addAttribute(Attribute::factory($attributeName, $attributeValue));
		}

		$this->rows[] = $row;

		return $this;
	}

	/**
	 * @param  array  $rowData
	 * @param  array  $attributes
	 * @return $this
	 */
	public function addRow(array $rowData, array $attributes = []): self
	{
		$row = Row::factory();

		foreach ($rowData as $celValue) {
			$row->addCell(Cell::factory()->addContent(Element::factory()->addValue($celValue)));
		}

		foreach ($attributes as $attributeName => $attributeValue) {
			$row->addAttribute(Attribute::factory($attributeName, $attributeValue));
		}

		$this->rows[] = $row;

		return $this;
	}

	/**
	 * @param  array  $data
	 * @param  array  $attributes
	 * @return $this
	 */
	public function addRows(array $data, array $attributes = []): self
	{
		foreach ($data as $row) {
			$this->addRow($row, $attributes);
		}
		return $this;
	}

	/** * @return $this */
	public function render(): self
	{
		$table = Element::factory('table');

		foreach ($this->attributes as $attribute){
			$table->addAttribute($attribute);
		}

		foreach ($this->rows as $row) {

			$tableBlock = Element::factory();

			foreach ($row->getCells() as $cell) {

				if (!$tableBlock->getTagName()) {
					if ($cell->getElement()->getTagName() === 'th') {
						$tableBlock->setTagName('thead');
					} else {
						$tableBlock->setTagName('tbody');
					}
				}
			}

			$tableBlock->addContent($row->getElement());

			$table->addContent($tableBlock);
		}

		$table->setEchoValue()->render();

		return $this;
	}
}