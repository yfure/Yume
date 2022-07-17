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
    function(): Void
    {
        HTTP\Route::get( ":tabs", function( String $user, String $tabs )
        {
            return( f( "<pre>^<b>\/</b>(?:(?&ltuser&gt<b\x20style=\"color:#8490ff\">{}</b>)<b>\/</b>(?&lttabs&gt<b\x20style=\"color:#007bff\">{}</b>))$</pre>", $user, $tabs ) );
        })
        
        // Where segment name.
        ->where( "tabs", "posts|rails|saveds|charms" );
    }
    
);

// Error method not allowed.
HTTP\Route::error( HTTP\Routing\RouteError::METHOD_NOT_ALLOWED, fn() => "Error" );

?>