<?php

/* Show all error reports. */
error_reporting( E_ALL );

/* Get server document root. */
$root = $_SERVER['DOCUMENT_ROOT'];

// Get array for constant.
require "$root/system/__init__/constant.php";

// Require bootstrap application.
require "$root/system/__init__/bootstrap.php";

// Replace Name space.
Yume\Func\replace( Yume\Func\tree( "/" ), [
	
]);

// Run the application.
Yume\Util\Runtime\Runtime::app();

?>
