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
        
        // Get all user input.
        $email = Http\Input::post( "usermail", HTTP\Input::EMAIL );
        $uname = Http\Input::post( "username", HTTP\Input::UNAME );
        $passw = Http\Input::post( "password", HTTP\Input::PASSW );
        
        try {
            
            // Create new user model instance.
            $model = new App\Models\User;
            
            if( $email === Null )
            {
                return([
                    'error' => [
                        'code' => 457360,
                        'message' => ""
                    ]
                ]);
            } else {
                if( $email['valid'] )
                {
                    if( $model->exists([ 'usermail' => $email['value'] ]) )
                    {
                        return([
                            'error' => [
                                'code' => 457380,
                                'message' => "The user with this email address has registered."
                            ]
                        ]);
                    }
                    $email = $email['value'];
                } else {
                    return([
                        'error' => [
                            'code' => 457370,
                            'message' => ""
                        ]
                    ]);
                }
            }
            
            if( $uname === Null )
            {
                return([
                    'error' => [
                        'code' => 457361,
                        'message' => ""
                    ]
                ]);
            } else {
                if( $uname['valid'] )
                {
                    if( $model->exists([ 'username' => $uname['value'] ]) )
                    {
                        return([
                            'error' => [
                                'code' => 457381,
                                'message' => "The user with this username has been registered."
                            ]
                        ]);
                    }
                    $uname = $uname['value'];
                } else {
                    return([
                        'error' => [
                            'code' => 457370,
                            'message' => ""
                        ]
                    ]);
                }
            }
            
            if( $passw === Null )
            {
                return([
                    'error' => [
                        'code' => 457362,
                        'message' => ""
                    ]
                ]);
            } else {
                if( $passw['valid'] )
                {
                    $passw = password_hash( $passw['value'], PASSWORD_DEFAULT );
                } else {
                    return([
                        'error' => [
                            'code' => 457372,
                            'message' => ""
                        ]
                    ]);
                }
            }
            
            $model->insert([
                
                // Create user node id.
                'node' => $node = AoE\Stringable::random( 26 ),
                
                'usermail' => $email,
                'username' => $uname,
                'userpass' => $passw,
                
                // Generate new token for user.
                'access_token' => $accessToken = AoE\Stringable::random( 255 ),
                'remind_token' => $remindToken = AoE\Stringable::random( 128 )
                
            ]);
            return([
                'success' => [
                    'message' => "User has successfully registered.",
                    'data' => [
                        
                    ]
                ]
            ]);
            
        } catch( Throwable $e ) {
            return([
                'error' => [
                    'code' => 457390,
                    'message' => $e->getMessage()
                ]
            ]);
        }
        
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