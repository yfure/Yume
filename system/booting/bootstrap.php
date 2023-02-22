<?php

/*
 * Bootstrap The Application.
 *
 * This process compares the minimum version of PHP used,
 * creates constants including application base path constants,
 * application context and framework version.
 */

// Start bootstraping application.
Yume\Fure\Util\Timer::calculate( "bootstrap", function()
{
	// Yume application info.
	define( "YUME_VERSION", "3.0.6" );
	define( "YUME_PHP_VERSION", "8.1.10" );
	
	// Yume Constants.
	$constant = [
		
		// Yume application context.
		"YUME_CONTEXT" => PHP_SAPI,
		"YUME_CONTEXT_CLI" => PHP_SAPI === "cli",
		"YUME_CONTEXT_CLI_SERVER" => PHP_SAPI === "cli-server",
		"YUME_CONTEXT_WEB" => PHP_SAPI === "cli-server" || PHP_SAPI === "web",
		
		// Yume application environment mode.
		"YUME_DEVELOPMENT" => 160824,
		"YUME_PRODUCTION" => 201205,
		
		// Constant for stop iteration.
		"STOP_ITERATION" => 160824020125,
		
		// Base path application.
		"BASE_PATH" => str_replace( "/", DIRECTORY_SEPARATOR, $_SERVER['DOCUMENT_ROOT'] !== "" ? $_SERVER['DOCUMENT_ROOT'] : substr( __DIR__, 0, - strlen( "/system/buffer" ) ) )
	];
	
	// Mapping constants.
	foreach( $constant As $const => $value )
	{
		// Check if constant is undefined.
		if( defined( $const ) === False )
		{
			// Define new constant.
			define( $const, $value );
		}
	}
});

?>