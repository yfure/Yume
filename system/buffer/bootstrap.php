<?php

/*
 * Bootstrap The Application.
 *
 * This process compares the minimum version of PHP used,
 * creates constants including application base path constants,
 * application context and framework version.
 */

// Yume application info.
define( "YUME_VERSION", "3.0.5" );
define( "YUME_PHP_VERSION", "8.1.10" );

// Check whether the php version used is standard.
if( version_compare( PHP_VERSION, YUME_PHP_VERSION, ">" ) )
{
	// Yume application context.
	define( "YUME_CONTEXT", PHP_SAPI );
	define( "YUME_CONTEXT_CLI", PHP_SAPI === "cli" );
	define( "YUME_CONTEXT_CLI_SERVER", PHP_SAPI === "cli-server" );
	define( "YUME_CONTEXT_WEB", PHP_SAPI === "cli-server" || PHP_SAPI === "web"  );
	
	// Yume application environment mode.
	define( "YUME_DEVELOPMENT", 160824 );
	define( "YUME_PRODUCTION", 201205 );
	
	// Check if basepath is undefined.
	if( defined( "BASE_PATH" ) === False )
	{
		// Define base path application.
		define( "BASE_PATH", str_replace( "/", DIRECTORY_SEPARATOR, $_SERVER['DOCUMENT_ROOT'] !== "" ? $_SERVER['DOCUMENT_ROOT'] : substr( __DIR__, 0, - strlen( "/system/buffer" ) ) ) );
	}
}
else {
	exit( sprintf( "Your PHP Version is %s, You need PHP Version %s or higher to run Yume.", PHP_VERSION, YUME_PHP_VERSION ) );
}

?>
