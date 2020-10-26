<?php

namespace Agrism\PhpHtml\Builder;

use Agrism\PhpHtml\Helpers\Helper;
use PHPUnit\Framework\Constraint\LogicalAnd;

class Element implements IContent
{
	/*** @var string */
	private $tagName;

	/*** @var bool */
	private $isSelfClosing = false;

	/*** @var array */
	private $output = [];

	/*** @var array */
	private $attributes = [];

	/*** @var array */
	private $content = [];

	/*** @var bool */
	private $echoValue = false;

	/*** @var bool */
	private $isElement = true;

	/*** @var mixed */
	private $value;

	/**
	 * Element constructor.
	 * @param  string  $tagName
	 * @param  bool  $isSelfClosing
	 */
	public function __construct(string $tagName = '', bool $isSelfClosing = false)
	{
		$this->tagName = $tagName;
		$this->isSelfClosing = $isSelfClosing;
	}

	/**
	 * @param  string  $tagName
	 * @param  bool  $isSelfClosing
	 * @return Element
	 */
	public static function factory(string $tagName = '', bool $isSelfClosing = false)
	{
		return new self($tagName, $isSelfClosing);
	}

	/**
	 * @param  string  $name
	 * @return $this
	 */
	public function setTagName(string $name): self
	{
		$this->tagName = $name;

		return $this;
	}

	/*** @return $this */
	public function startOpen(): self
	{
		$this->output[] = '<';
		$this->output[] = $this->tagName;
		return $this;
	}

	/*** @return $this */
	public function endOpen(): self
	{
		if ($this->isSelfClosing) {
			$this->output[] = '/';
		}
		$this->output[] = '>';
		return $this;
	}

	/*** @return $this */
	public function startClose(): self
	{
		if ($this->isSelfClosing) {
			return $this;
		}

		$this->output[] = '</';
		$this->output[] = $this->tagName;
		return $this;
	}

	/*** @return $this */
	public function endClose(): self
	{
		if ($this->isSelfClosing) {
			return $this;
		}
		$this->output[] = '>';
		return $this;
	}

	/**
	 * @param  Attribute  $attribute
	 * @return $this
	 */
	public function addAttribute(Attribute $attribute): self
	{
		$this->attributes[] = $attribute;
		return $this;
	}

	/**
	 * @param  IContent  $content
	 * @return $this
	 */
	public function addContent(IContent $content): self
	{
		$this->content[] = unserialize(serialize($content));;
		return $this;
	}

	/**
	 * @param  bool  $value
	 * @return $this
	 */
	public function setSelfClosing(bool $value = true): self
	{
		$this->isSelfClosing = $value;
		return $this;
	}

	/*** @return $this */
	private function implementAttributes(): self
	{
		foreach ($this->attributes as $attribute) {
			$this->output[] = ' ';
			$this->output[] = $attribute->getName();
			$this->output[] = '=';

			$value = $attribute->getValue();
			if (strpos($value, '"') !== false) {
				$this->output[] = "'".$attribute->getValue()."'";
			} else {
				$this->output[] = '"'.$attribute->getValue().'"';
			}
		}
		return $this;
	}

	/*** @return $this */
	public function renderContent(): self
	{
		foreach ($this->content as $content) {
			$this->output[] = $content->render()->getPrintableOutput();
		}

		return $this;
	}

	/**
	 * @param  string  $output
	 * @return $this
	 */
	public function addOutput(string $output): self
	{
		$this->output[] = $output;
		return $this;
	}

	/*** @return $this */
	public function setEchoValue(): self
	{
		$this->echoValue = true;
		return $this;
	}

	/*** @return bool */
	public function isElement(): bool
	{
		return boolval($this->tagName);
	}

	/*** @return mixed */
	public function getValue()
	{
		return $this->value === null ? "" : $this->value;
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function addValue($value): self
	{
		$this->value[] = $value;

		return $this;
	}

	public function getTagName(): string
	{
		return strval($this->tagName);
	}


	/*** @return $this */
	public function doNothing(): self
	{
		return $this;
	}

	/*** @return IContent */
	public function render(): IContent
	{
		if($this->isElement()){
			$this->startOpen()
				->implementAttributes()
				->endOpen()
				->renderContent()
				->startClose()
				->endClose();
		} else {
			$this->output[] = implode('',$this->value);
		}

		if ($this->echoValue) {
			$this->printOutput();
		}

		return $this;
	}

	/*** @return string */
	public function getPrintableOutput(): string
	{
		return implode('', $this->output);
	}

	/*** @return $this */
	public function printOutput(): self
	{
		echo $this->getPrintableOutput();

		return $this;
	}
}