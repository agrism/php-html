<?php


namespace Agrism\PhpHtml;


interface IContent
{
	public function render(): self;

	public function getPrintableOutput(): string;
}