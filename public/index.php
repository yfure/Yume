<?php

/*
 * Yume PHP Framework.
 *
 * @author hxAri
 * @create 05.02-2022
 * @update -
 * @github https://github.com/yfure/Yume
 *
 * Yume is a simple framework for building Websites
 * built using the PHP Programming Language, it already
 * provides several built-in packages that are ready to
 * use but some packages are under development and code
 * repair. You can also install other PHP libraries if
 * the package is incomplete or incomplete.
 *
 * All Yume source code is under the MIT license,
 * please see the original for more details.
 */

use Yume\Fure\App;

/*
 * Yume application start time.
 *
 * This will be used by the framework to check how fast
 * the application is running or compiling.
 */
define( "YUME_START", microtime( True ) );

// Check if the application is under maintenance.
if( file_exists( $maintenance = __DIR__ . "/../assets/furemu/views/maintenance.php" ) )
{
	/*
	 * Application maintenance.
	 *
	 * If the application is in maintenance / demo mode via the `down` command
	 * we will load this file so that any pre-rendered content can be shown
	 * instead of starting the framework, which could cause an exception.
	 */
	require( $maintenance );
}
else {
	
	// Check if the autoload file exists.
	if( file_exists( $autoload = __DIR__ . "/../vendor/autoload.php" ) )
	{
		/*
		 * Register Auto Load.
		 *
		 * Automatic loading of files required for a project or application.
		 * This includes the files required for the application without
		 * explicitly including them with the include or require functions.
		 */
		require( $autoload );
	}
	else {
		exit( sprintf( "File %s not found.", $autoload ) );
	}
	
	/*
	 * Starting Application.
	 *
	 * Time to run the app!
	 * Relax your life!
	 */
	App\App::self()->run();
}

?>