<?php

namespace Agrism\PhpHtml;

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
	public function setAttribute(Attribute $attribute): self
	{
		$this->attributes[] = $attribute;
		return $this;
	}

	/**
	 * @param  IContent  $content
	 * @return $this
	 */
	public function setContent(IContent $content): self
	{
		$this->content[] = $content;
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

	/*** @return $this */
	public function doNothing(): self
	{
		return $this;
	}

	/**
	 * @param  bool  $print
	 * @return $this|IContent
	 */
	public function render(bool $print = false): IContent
	{
		$this->startOpen()
			->implementAttributes()
			->endOpen()
			->renderContent()
			->startClose()
			->endClose();

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