<?php

/*
 * Yume PHP Framework.
 *
 * @author hxAri
 * @create 05.02-2022
 * @update -
 * @github https://github.com/hxAri/{Yume}
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
 *
 */

// Show all error reports.
error_reporting( E_ALL );

// Get server document root.
$root = $_SERVER['DOCUMENT_ROOT'];

/*
 * Register Auto Load.
 *
 * Automatic loading of files required for a project or application.
 * This includes the files required for the application without
 * explicitly including them with the include or require functions.
 */
if( $root !== "" )
{
    require "$root/vendor/autoload.php";
} else {
    require "vendor/autoload.php";
}

//replace( Yume\Kama\Obi\IO\Dir\Dir::tree( "/" ), [] );

Yume\Kama\Obi\AoE\Runtime::buff();

?>