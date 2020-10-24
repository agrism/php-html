<?php


namespace Agrism\PhpHtml;


class Content implements IContent
{
	/*** @var string */
	private $value = '';

	/*** @return static */
	public static function factory(): self
	{
		return new self;
	}

	/**
	 * @param  string  $value
	 * @return $this
	 */
	public function setValue(string  $value = ''): self
	{
		$this->value = $value;
		return $this;
	}

	/*** @return $this|IContent */
	public function render(): IContent
	{
		return $this;
	}

	/*** @return string */
	public function getPrintableOutput(): string
	{
		return $this->value;
	}
}