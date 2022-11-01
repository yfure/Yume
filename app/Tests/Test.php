<?php

namespace Yume\App\Tests;

use Generator;
use Throwable;

use Yume\Fure\Support;
use Yume\Fure\Util;

try {
	
	// Get all declared functions.
	$functions = get_defined_functions();
	
	// Mapping Internal and User functions.
	$functions = Util\Arr::map( $functions, function( $i, $index, $defined )
	{
		return( Util\Arr::map( $defined, function( $i, $index, $function )
		{
			try
			{
				$param = Null;
				$type = Support\Reflect\ReflectParameter::getType( $function, 0, $param );
				
				return([
					"name" => $param->getName(),
					"func" => $function,
					"type" => $type ? $type->__toString() : Null
				]);
			}
			catch( Throwable $e )
			{
				return( f( "Function {} has no parameter", $function ) );
			}
		}));
	});
	
	var_dump( $functions );
	echo "\x1b[1;37mTest\x20\x1b[1;32mPassed!\n";
}
catch( Throwable $e )
{
	/** PRINT EXCEPTION THROWN */
	e( $e );
}

?>