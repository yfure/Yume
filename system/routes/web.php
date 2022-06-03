<?php

use function Yume\Func\view;

use App\HTTP\Controllers;
use App\Models;

use Yume\Kama\Obi\Database;
use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\IO;
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
        
    })->meta( HTTP\Route::GUEST );
    
    // Signup page for users.
    $parent->add( "POST", "/signup", function()
    {
        
        echo IO\File\File::read( "/index.php" );
        
        exit;
        $email = Http\Input::post( "usermail" );
        $uname = Http\Input::post( "username", "/+/" );
        $passw = Http\Input::post( "password" );
        
        
        
        $users = new App\Models\User;
        
        // Check whether the email address has been used or not.
        if( $users->exists([ 'usermail' => $email ]) )
        {
            $result = [
                'error' => [
                    'code' => Models\User::E_USERMAIL_EXISTS,
                    'message' => "The user with this email address has registered."
                ]
            ];
        } else {
            // Check whether the username has been used or not.
            if( $users->exists([ 'username' => $uname ]) )
            {
            return([
            'error' => [
            'code' => Models\User::E_USERNAME_EXISTS,
            'message' => "The user with this username has been registered."
            ]
            ]);
            } else {
            try {
            $users->create([
            
            'usermail' => $email,
            'username' => $uname,
            'userpass' => $passw,
            
            // Generate new token for user.
            'access_token' => $accessToken = AoE\Stringable::random( 255 ),
            'remind_token' => $remindToken = AoE\Stringable::random( 128 )
            
            ]);
            return([
            'success' => True,
            'message' => "User has successfully registered.",
            'data' => []
            ]);
            } catch( Throwable $e ) {
            return([
            
            ]);
            }
            }
        }
        return( $result );
        
    })->meta( HTTP\Route::GUEST );
    
    // Logout page for users.
    $parent->add( "GET", "/logout", function()
    {
        
    },
    function()
    {
        
    })->meta( HTTP\Route::AUTH );
    
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
HTTP\Route::add( "GET", "/test", function()
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