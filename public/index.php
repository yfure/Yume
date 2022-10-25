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

define( "YUME_START", microtime( True ) );

/*
 * Register Auto Load.
 *
 * Automatic loading of files required for a project or application.
 * This includes the files required for the application without
 * explicitly including them with the include or require functions.
 */
require( $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php" );

App\App::self();

?>