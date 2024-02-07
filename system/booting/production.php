<?php

/*
 * Display errors.
 *
 * @default 1
 */
ini_set( "display_errors", 0 );
ini_set( "display_startup_errors", 0 );

/*
 * Sets which PHP errors are reported.
 * PHP has many levels of errors, using this function
 * sets that level for the duration (runtime) of your script.
 *
 * @default 0
 */
error_reporting( 0 );

/*
 * DEBUG MODE
 *
 * Allow the app to be in debug mode.
 */
define( "YUME_DEBUG", False );

/*
 * DEBUG BACKTRACE
 *
 * Show application error backtrace.
 */
define( "YUME_DEBUG_BACKTRACE", False );

?>