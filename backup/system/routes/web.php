<?php

use function Yume\Func\view;

use App\HTTP\Controllers;
use App\Models;

use Yume\Kama\Obi\Database;
use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Trouble;

/*
 * Rest API.
 *
 */
HTTP\Route::add( "GET", "/api", function()
{
    echo "Hi";
},
function( HTTP\Route\RouteGroup $parent ): Void
{
    
    /*
     * Starting new session.
     *
     */
    HTTP\Session\Session::start();
    
    // Signin page for users.
    $parent->add( "POST", "/signin", function()
    {
        
    });
    
    // Signup page for users.
    $parent->add( "POST", "/signup", function()
    {
        
        /*
         * Create new database connection.
         *
         * @database octancle
         */
        $init = Database\Connection::create( "octancle" );
        
        
    })->meta( HTTP\Route::GUEST );
    
    // Logout page for users.
    $parent->add( "GET", "/logout", function()
    {
        
    });
    
})
    
/*
 * Set response content Type as application/json.
 *
 * @response application/json
 */
->response( "json" );

/*
 * This is the page route to do the test.
 *
 * @route /test
 */
HTTP\Route::add( "GET", "/:test", function( $test )
{
    $code = "from i import u as e\nimport u,h";
    
    $regex = "/(?m)^(?:from[ ]+(\S+)[ ]+)?import[ ]+(\S+)(?:[ ]+as[ ]+(\S+))?[ ]*$/s";
    
    preg_replace_callback( $regex, function( $m ) {
        //var_dump( $m );
    }, $code );
    return( view( "views.test" ) );
});

/*
 * Handle route not found!
 *
 */
HTTP\Route::add( path: HTTP\Route::NOTFOUND, handler: fn() => view( "views.public" ) );

?>