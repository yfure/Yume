<?php

use Yume\Kama\Obi\HTTP;

// Starting new session.
HTTP\Session\Session::start();

// Normal Route.
HTTP\Route::get( "/", fn() => view( "welcome" ) );

// Nesting Route.
HTTP\Route::get( "/:user",
    
    // Handler ...
    function( String $user )
    {
        return( f( "(?<user>{})", $user ) );
    },
    
    // Children ...
    function()
    {
        HTTP\Route::get( ":tabs", function( String $user, String $tabs )
        {
            return( f( "(?<user>{})\/(?<tabs>{})", $user, $tabs ) );
        })
        
        // Where segment name.
        ->where( "tabs", "posts|rails|saveds|charms" );
    }
    
)

// Where segment name.
->where( "user", "[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*" );

?>