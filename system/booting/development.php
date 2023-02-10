<?php

/*
 * Display errors.
 *
 * @default 1
 */
ini_set( "display_errors", 1 );
ini_set( "display_startup_errors", 1 );

/*
 * Sets which PHP errors are reported.
 * PHP has many levels of errors, using this function
 * sets that level for the duration (runtime) of your script.
 *
 * @default E_ALL
 */
error_reporting( E_ALL );

/*
 * DEBUG MODE
 *
 * Allow the app to be in debug mode.
 */
define( "YUME_DEBUG", True );

/*
 * DEBUG BACKTRACE
 *
 * Show application error backtrace.
 */
define( "YUME_DEBUG_BACKTRACE", True );

?>