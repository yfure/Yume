<?php

use Yume\Kama\App;
use Yume\Kama\Obi\HTTP;

// Starting new session.
HTTP\Session\Session::start();

// Normal Route.
HTTP\Route::get( "/", fn() => view( "welcome" ) );

// Nesting Route.
HTTP\Route::get( "/:user",
	
	// Route Handler...
	App\HTTP\Controllers\User::class,
	
	// Route Children...
	function()
	{
		HTTP\Route::get( ":tabs", function( String $user, String $tabs )
		{
			return( f( "(?<user>{})\/(?<tabs>{})", $user, $tabs ) );
		})
		
		// Where segment name.
		->where( "tabs", "posts|rails|saveds|charms" );
	}
	
);

?>