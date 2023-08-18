<?php

/*
 * Bootstrap The Application.
 *
 * This process compares the minimum version of PHP used,
 * creates constants including application base path constants,
 * application context and framework version.
 */

// Yume application info.
defined( "YUME_VERSION" ) || define( "YUME_VERSION", "4.4.0" );
defined( "YUME_PHP_VERSION" ) || define( "YUME_PHP_VERSION", "8.2.0" );

// Yume application context.
defined( "YUME_CONTEXT" ) || define( "YUME_CONTEXT", PHP_SAPI );
defined( "YUME_CONTEXT_CLI" ) || define( "YUME_CONTEXT_CLI", PHP_SAPI === "cli" );
defined( "YUME_CONTEXT_CLI_SERVER" ) || define( "YUME_CONTEXT_CLI_SERVER", PHP_SAPI === "cli-server" );
defined( "YUME_CONTEXT_WEB" ) || define( "YUME_CONTEXT_WEB", PHP_SAPI === "cli-server" || PHP_SAPI === "web" );

// Yume application environment mode.
defined( "YUME_DEVELOPMENT" ) || define( "YUME_DEVELOPMENT", 896051 );
defined( "YUME_PRODUCTION" ) || define( "YUME_PRODUCTION", 935997 );

// Get application base path.
$BASE_PATH = $_SERVER['DOCUMENT_ROOT'] ?? "";
$BASE_PATH = $_SERVER['DOCUMENT_ROOT'] !== "" ? $BASE_PATH : __DIR__;

// Path must be remove.
$SUBSTR_PATH = "/system/booting";

// Check if application running on cli-server/ web-server.
if( strpos( $BASE_PATH = str_replace( "\\", "/", $BASE_PATH ), $SUBSTR_PATH ) === False )
{
	/*
	 * If appilaction running on cli-server
	 * but the public path as root directory.
	 *
	 */
	if( strpos( $BASE_PATH, "/public" ) !== False )
	{
		$SUBSTR_PATH = "/public";
	}
	else {
		$SUBSTR_PATH = "";
	}
}

// Base path application.
define( "BASE_PATH", str_replace( [ "/", "\\" ], DIRECTORY_SEPARATOR, $SUBSTR_PATH === "" ? $BASE_PATH : substr( $BASE_PATH, 0, - strlen( $SUBSTR_PATH ) ) ) );

?>