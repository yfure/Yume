<?php

namespace Yume\Kama\Obi\Translator;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Services;

/*
 * TranslatorServices
 *
 * @extends Yume\Kama\Obi\Services\Services
 *
 * @package Yume\Kama\Obi\Translator
 *
 */
final class TranslatorServices extends Services\Services
{
	
	/*
	 * @inherit Yume\Kama\Obi\Services\ServicesInterface
	 *
	 */
	public static function boot(): Void
	{
		Translator::import( AoE\App::config( "language" ) );
	}
	
}

?>