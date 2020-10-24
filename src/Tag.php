<?php


namespace Agrism\PhpHtml;


class Tag
{
	/*** @var string */
	private $name;

	public function __construct(string $name)
	{
		$this->name = $name;
	}

	/**
	 * @param  string  $name
	 * @return static
	 */
	public static function factory(string $name): self
	{
		return new self($name);
	}
}