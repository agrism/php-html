<?php


namespace Agrism\PhpHtml\Builder;


interface IContent
{
	public function render(): self;

	public function getPrintableOutput(): string;
}