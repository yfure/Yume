<?php

use App\HTTP\Controllers;

use Yume\Kama\Obi\HTTP\HTTP;
use Yume\Kama\Obi\HTTP\Route;
use Yume\Kama\Obi\HTTP\Filter\RegExp;
use Yume\Kama\Obi\HTTP\Request;

// Call method by default.
//Route::get( "/", Null, Controllers\Welcome::class );

Route::get( "/", Null, function() {
    
    echo json_encode( [ "::{Closure}" => "Welcome to The Board!" ], JSON_PRETTY_PRINT );
});

?>