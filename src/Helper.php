<?php


namespace Agrism\PhpHtml;


class Helper
{
	public static function dump($value)
	{
		echo '<pre style="background-color: greenyellow;padding: 10px;margin: 15px">';
		print_r($value);
		echo '</pre>';
	}

	public static function dd($value)
	{
		self::dump($value);
		die;
	}
}