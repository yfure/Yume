<?php

use function Yume\Func\view;

use App\HTTP\Controllers;
use App\Models;

use Yume\Util\Database;
use Yume\Util\Himei;
use Yume\Util\HTTP;
use Yume\Util\IO;
use Yume\Util\Trouble;

HTTP\Route::add( "GET", "/", fn() => view( "views.welcome" ) );

?>
