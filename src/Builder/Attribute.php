<?php


namespace Agrism\PhpHtml\Builder;


class Attribute
{
	/*** @var string */
	private $name;

	/*** @var string */
	private $value;

	/**
	 * Attribute constructor.
	 * @param  string  $name
	 * @param  string  $value
	 */
	public function __construct(string $name = '', string $value = ''){
		$this->name = $name;
		$this->setValue($value);
	}

	/**
	 * @param  string  $name
	 * @param  string  $value
	 * @return Attribute
	 */
	public static function factory(string $name = '', string $value = ''){
		return new self($name, $value);
	}

	/*** @return string */
	public function getName(): string
	{
		return $this->name ?? '';
	}

	/*** @return string */
	public function getValue(): string
	{
		return $this->value ?? '';
	}

	/**
	 * @param  string  $value
	 * @return $this
	 */
	public function setValue(string $value): self
	{
		$this->value = $value;

		return $this;
	}
}