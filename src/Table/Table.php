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

	/*** @var Element */
	private $table;

	/*** Table constructor.*/
	public function __construct()
	{
		$this->table = $this->table = Element::factory('table');
	}


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
	public function addHead(array $rowData = [], array $attributes = []): self
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
	public function addRow(array $rowData = [], array $attributes = []): self
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

	/*** @return Element */
	public function getElement(): Element
	{
		return $this->table;
	}

	/** * @return $this */
	public function render(): self
	{
		$this->prepareElement()->getElement()->setEchoValue()->render();

		return $this;
	}

	/*** @return string */
	public function getOutput(): string
	{
		return $this->prepareElement()->getElement()->render()->getPrintableOutput() ?? '';
	}

	/*** @return $this */
	private function prepareElement(): self
	{
		foreach ($this->attributes as $attribute) {
			$this->table->addAttribute($attribute);
		}

		$tableHead = Element::factory('thead');
		$tableBody = Element::factory('tbody');

		foreach ($this->rows as $row) {
			foreach ($row->getCells() as $cell) {
				if ($cell->getElement()->getTagName() === 'th') {
					$tableHead->addContent($row->getElement());
				} else {
					$tableBody->addContent($row->getElement());
				}
				break;
			}
		}

		$this->table->addContent($tableHead)->addContent($tableBody);

		return $this;
	}
}