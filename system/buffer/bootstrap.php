<?php

/*
 * Bootstrap The Application.
 *
 * This process compares the minimum version of PHP used,
 * creates constants including application base path constants,
 * and loads environment variables.
 */

define( "YUME_VERSION", "3.0.4" );
define( "YUME_PHP_VERSION", "8.1.10" );

// Check whether the php version used is standard.
if( version_compare( PHP_VERSION, YUME_PHP_VERSION, ">" ) )
{
	// Define base path application.
	define( "BASE_PATH", str_replace( "/", DIRECTORY_SEPARATOR, __DIR__ ) );
	
	// Load application environment variables.
	Yume\Fure\Support\Kankyou\Kankyou::self()->load();
}
else {
	exit( sprintf( "Your PHP Version is %s, You need PHP Version %s or higher to run Yume.", PHP_VERSION, YUME_PHP_VERSION ) );
}

?>