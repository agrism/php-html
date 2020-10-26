<?php


namespace Agrism\PhpHtml\Helpers;

class Helper
{
	/*** @param  mixed  $value */
	public static function dump($value)
	{
		echo '<pre style="background-color: greenyellow;padding: 10px;margin: 15px">';
		print_r($value);
		echo '</pre>';
	}

	/*** @param  mixed  $value */
	public static function dd($value)
	{
		self::dump($value);
		die;
	}

	/*** @param  mixed  $value */
	public static function log($value)
	{

		$cmd = [];
		$cmd[] = 'echo';
		$cmd[] = ' "';
		$cmd[] = '['.date('Y-m-d H:i:s').']';
		$cmd[] = ' ';
		$cmd[] = strval($value);
		$cmd[] = '" ';
		$cmd[] = '>> '.ROOT_PATH.'/log.log';
		$cmd = implode('', $cmd);

		$r = exec($cmd);

	}
}