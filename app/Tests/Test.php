<?php

namespace Yume\App\Tests;

use Throwable;

use Yume\Fure\Util;
use Yume\Fure\Util\Array;

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
	//	echo "<pre>";
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
		try
		{
			$list = new Array\Lists([
				1, 2, 3
			]);
			var_dump( $list );
		}
		catch( Throwable $e )
		{
			echo $e->getMessage() . " in file " . $e->getFile() . " on line " . $e->getLine();
		}
	}
	
}

?>