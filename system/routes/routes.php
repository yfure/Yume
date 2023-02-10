<?php

use Yume\App\HTTP\Controllers\Welcome;

use Yume\Fure\HTTP\Route\Route;
use Yume\Fure\HTTP\Route\RoutePath;

Route::get(
	path: "/",
	handler: Welcome::class,
	children: function()
	{
		Route::get( "test", fn() => view( "test", [] ) );
	}
);

?>