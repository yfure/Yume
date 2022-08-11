<?php

use Yume\App\HTTP\Controllers;
use Yume\Fure\HTTP\Route;

// Request API.
Route::get( "/api", fn() => "Bad request url.", function()
{
    // Get username.
    Route::get( ":user", function( String $user )
    {
        return( $user );
    });
    
// Add route headers.
})->header( "Content-Type: application/json" );

// Test Cases.
Route::get( "/test/case", Controllers\Test::class );

// I don't know why.
Route::get( "/", Controllers\Main::class );

?>