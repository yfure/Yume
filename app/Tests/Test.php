<?php

namespace Yume\App\Tests;

use Yume\Fure\App;
use Yume\Fure\Cache;
use Yume\Fure\CLI;
use Yume\Fure\Config;
use Yume\Fure\Error;
use Yume\Fure\Error\Handler As ErrorHandler;
use Yume\Fure\HTTP;
use Yume\Fure\HTTP\Header;
use Yume\Fure\HTTP\Message;
use Yume\Fure\HTTP\Stream;
use Yume\Fure\Locale;
use Yume\Fure\Locale\Clock;
use Yume\Fure\Locale\DatTime;
use Yume\Fure\Locale\Language;
use Yume\Fure\Logger;
use Yume\Fure\Logger\Handler As LoggerHandler;
use Yume\Fure\Secure;
use Yume\Fure\Support;
use Yume\Fure\Support\Data;
use Yume\Fure\Support\Design;
use Yume\Fure\Support\File;
use Yume\Fure\Support\Package;
use Yume\Fure\Support\Path;
use Yume\Fure\Support\Reflect;
use Yume\Fure\Support\Services;
use Yume\Fure\Util;
use Yume\Fure\Util\Env;
use Yume\Fure\Util\Json;
use Yume\Fure\Util\Random;
use Yume\Fure\Util\RegExp;
use Yume\Fure\View;
use Yume\Fure\View\Template;

/*
 * Test
 * 
 * @package Yume\App\Tests
 */
final class Test
{
	
	/*
	 * Construct method of class Test.
	 *
	 * @access Public Instance
	 *
	 * @return Void
	 */
	public function __construct()
	{
		echo "<pre>";
	}
	
	/*
	 * Starting testing.
	 * 
	 * @access Public
	 * 
	 * @return Void
	 */
	public function main(): Void
	{
		puts( "Execution >> {}", executionTimeCompareEnd() );
	}
}

?>