<?php

use Yume\Kama\Obi\Environment;
use Yume\Kama\Obi\Runtime;

/*
 * Yume PHP Framework.
 *
 * @author hxAri
 * @create 05.02-2022
 * @update 01.06-2022
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

// Reporting error.
error_reporting( E_ALL );

// Load autoload file.
include "vendor/autoload.php";

// Load builtin functions.
include "system/buffer/.php";

// Load variable from environment file.
Environment\Environment::onload()->load();

// Run application.
Runtime\Runtime::create();

?>