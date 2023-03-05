<?php

use Yume\App\HTTP\Controllers;

use Yume\Fure\HTTP\Request;
use Yume\Fure\HTTP\Router;

/*
 * Welcome
 *
 * This is an example how you can define route in Yume.
 *
 * @target /
 */
$welcome = Router\Route::get(
	
	// Route pathname.
	path: [ "/", "/welcome" ],
	
	// Route handler.
	handler: Controllers\Welcome::class,
	
	/*
	 * Route children.
	 *
	 * @params Yume\Fure\HTTP\Request\RequestInterface $r
	 *
	 * @return Void
	 */
	children: function( Request\RequestInterface $r ): Void
	{
		// Do something here.
	}
);

Router\Route::error404( fn() => view( "" ) );

?>