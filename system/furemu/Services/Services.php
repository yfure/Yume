<?php

namespace Yume\Kama\Obi\Services;

/*
 * Services
 *
 * @package Yume\Kama\Obi\Services
 */
abstract class Services implements ServicesInterface
{
	
	/*
	 * @inherit Yume\Kama\Obi\Services\ServicesInterface
	 *
	 */
	abstract public static function boot(): Void;
	
}

?>