<?php

/*
 * Bootstrap The Application.
 *
 * This process compares the minimum version of PHP used,
 * creates constants including application base path constants,
 * application context and framework version.
 */

// Yume application info.
define( "YUME_VERSION", "3.0.6" );
define( "YUME_PHP_VERSION", "8.1.10" );

// Get application base path.
$BASE_PATH = $_SERVER['DOCUMENT_ROOT'] ?? "";
$BASE_PATH = $_SERVER['DOCUMENT_ROOT'] !== "" ? $BASE_PATH : __DIR__;

// Path must be remove.
$SUBSTR_LENGTH = "/system/booting";

// If application running on cli-server/ web-server.
if( strpos( $BASE_PATH = str_replace( "\\", "/", $BASE_PATH ), $SUBSTR_LENGTH ) === False )
{
	// If appilaction running on cli-server
	// But the public path as root directory.
	if( strpos( $BASE_PATH, "/public" ) !== False )
	{
		$SUBSTR_LENGTH = "/public";
	}
	else {
		$SUBSTR_LENGTH = "";
	}
}

// Yume Constants.
$constant = [
	
	// Yume application context.
	"YUME_CONTEXT" => PHP_SAPI,
	"YUME_CONTEXT_CLI" => PHP_SAPI === "cli",
	"YUME_CONTEXT_CLI_SERVER" => PHP_SAPI === "cli-server",
	"YUME_CONTEXT_WEB" => PHP_SAPI === "cli-server" || PHP_SAPI === "web",
	
	// Yume application environment mode.
	"YUME_DEVELOPMENT" => 896051,
	"YUME_PRODUCTION" => 935997,
	
	// Constant for stop execution.
	"STOP_EXECUTION" => 113207592990,
	
	// Constant for stop iteration.
	"STOP_ITERATION" => 129881116207,
	
	// Base path application.
	"BASE_PATH" => str_replace( [ "/", "\\" ], DIRECTORY_SEPARATOR, $SUBSTR_LENGTH === "" ? $BASE_PATH : substr( $BASE_PATH, 0, - strlen( $SUBSTR_LENGTH ) ) )
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

?>