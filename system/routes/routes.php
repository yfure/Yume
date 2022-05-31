<?php

use function Yume\Func\view;

use Yume\Util\HTTP;

HTTP\Route::add( "GET", "/", fn() => view( "views.welcome" ) );

?>
