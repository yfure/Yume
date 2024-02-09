<?php

/*
 * Yume PHP Framework.
 *
 * @author Ari Setiawan
 * @create 05.02-2022
 * @update -
 * @github https://github.com/yfure/Yume
 *
 * Copyright (c) 2022 Ari Setiawan
 * Copyright (c) 2022 Yume Framework
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

use Yume\Fure\Main;

/*
 * Yume application start time.
 *
 * This will be used by the framework to check how fast
 * the application is running or compiling.
 */
define( "YUME_START", microtime( True ) );

// Check if the application is under maintenance.
if( file_exists( $maintenance = __DIR__ . "/../assets/furemu/views/maintenance.php" ) ) {

	/*
	 * Application maintenance.
	 *
	 * If the application is in maintenance / demo mode via the `down` command
	 * we will load this file so that any pre-rendered content can be shown
	 * instead of starting the framework, which could cause an exception.
	 */
	require( $maintenance );
}

// Check if the autoload file exists.
if( file_exists( $autoload = __DIR__ . "/../vendor/autoload.php" ) ) {
	try {
		
		/*
		 * Register Auto Load.
		 * 
		 * Automatic loading of files required for a project or application.
		 * This includes the files required for the application without explicitly
		 * including them with the include or require functions.
		 */
		require( $autoload );

		/*
		 * Starting Application.
		 *
		 * Time to run the app!
		 * Relax your life!
		 */
		Main\Main::self()->main();
	}
	catch( Throwable $e ) {
		header( "HTTP/1.1 500 Internal Server Error" );
		echo $e->getMessage();
	}
}
else {
	header( "HTTP/1.1 500 Internal Server Error" );
	echo sprintf( "File %s not found.", $autoload );
}

?>
