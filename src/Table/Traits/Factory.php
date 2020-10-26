<?php


namespace Agrism\PhpHtml\Table\Traits;

trait Factory
{
	/**
	 * @return static
	 */
	public static function factory(): self
	{
		return new self;
	}
}