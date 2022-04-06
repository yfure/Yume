<?php

use Util\Octancle;

/* Show all error reports. */
error_reporting( E_ALL );

/* Get server document root. */
$root = $_SERVER['DOCUMENT_ROOT'];

/*
 * Register Auto Load.
 *
 * Automatic loading of files required for a project or application.
 * This includes the files required for the application without explicitly
 * including them with the [include] or [require] functions.
 */
require "$root/vendor/autoload.php";

// Import all Yume built-in Functions.
require "$root/system/helpers/.php";

// Get array for constant.
require "$root/system/__init__/constant.php";

// Require bootstrap application.
require "$root/system/__init__/bootstrap.php";

// Replace Name space.
Util\Function\replace( Util\Function\tree( "/" ), [] );

// Run the application.
Util\Octancle\Runtime\Runtime::app();

?>
