<?php

namespace Yume\Kama\Obi\HTTP\Route;

use function Yume\Func\view;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Reflection;

use ArrayAccess;
use Iterator;
use Stringable;
use TypeError;

/*
 * RouteDispatch utility class.
 *
 * @package Yume\Kama\Obi\HTTP\Route
 */
abstract class RouteDispatch
{
    
    /*
     * Authentication instance class.
     *
     * @access Protected, Static
     *
     * @values Yume\Kama\Obi\HTTP\Authentication
     */
    protected static $auth;
    
    /*
     * Current route path.
     *
     * @access Protected, Static
     *
     * @values String
     */
    protected static $path;
    
    /*
     * Includes all predefined routes.
     *
     * @access Protected, Static
     *
     * @values Yume\Kama\Obi\AoE\Data
     */
    protected static $routes;
    
    public static function dispatch(): Void
    {
        
        // Create new reflection.
        $reflect = Reflection\ReflectionInstance::reflect( AoE\App::$object->routes );
        
        // If the class doesn't implement Iterator.
        if( $reflect->implementsInterface( Iterator::class ) === False )
        {
            throw new TypeError( "The route container class must be loopable." );
        }
        
        // If the class doesn't implement ArrayAccess.
        if( $reflect->implementsInterface( ArrayAccess::class ) === False )
        {
            throw new TypeError( "The route container class must be able to access the array." );
        }
        
        // Get current route page.
        self::$path = HTTP\Request::uri();
        
        // New Authentication instance.
        self::$auth = new HTTP\Authentication\Authentication();
        
        // Validate all routes that have been defined.
        self::validate( AoE\App::$object->routes );
        
    }
    
    /*
     * Validate route address as per page.
     *
     * @access Private, Static
     *
     * @params Yume\Kama\Obi\AoE\Data <routes>
     *
     * @return Void
     */
    private static function validate( AoE\Data $routes )
    {
        if( $routes->count() !== 0 )
        {
            foreach( $routes As $i => $v )
            {
                // Can route current instance.
                $route = $routes->current();
                
                // If the route has a segment to take.
                if( $segment = HTTP\Filter\RegExp::exec( RoutePattern::$segment, $route->path() ) )
                {
                    $route->segment( $segment );
                    
                    RoutePattern::create( $route );
                    RoutePattern::pattern( $route );
                }
                
                // If the current path is the same as the defined path.
                if( $route->path() === self::$path )
                {
                    if( self::method( $route ) )
                    {
                        // 
                        self::segment( $route );
                        
                        // 
                        self::guard( $route );
                    } else {
                        echo "Method is not allowed!";
                    }
                    break;
                } else {
                    if( $routes->count() - 2 === $i )
                    {
                        if( $routes->__isset( HTTP\Route::NOTFOUND ) )
                        {
                            self::handler( $routes[HTTP\Route::NOTFOUND] );
                        } else {
                            echo "Route not found";
                        }
                    }
                }
            }
        } else {
            echo "No Routes Defined";
        }
    }
    
    /*
     * Validate page route method request.
     *
     * @access Private, Static
     *
     * @params Yume\Kama\Obi\HTTP\Route\Route <route>
     *
     * @return Bool
     */
    private static function method( Route $route )
    {
        if( is_array( $route->method() ) )
        {
            foreach( $route->method() As $method )
            {
                if( HTTP\Request::method( $method ) )
                {
                    return( True );
                }
            }
            return( False );
        }
        return( HTTP\Request::method( $route->method() ) );
    }
    
    private static function segment( Route $route )
    {
        $params = $route->params();
        
        foreach( $route->segment() As $i => $segment )
        {
            if( isset( $params[$i] ) )
            {
                // Insert new array element.
                $params[$segment[1]] = $params[$i];
                
                // Remove array element.
                unset( $params[$i] );
                
            }
        }
        $route->params( $params );
    }
    
    /*
     * 
     *
     * @access Private, Static
     *
     * @params Yume\Kama\Obi\HTTP\Route\Route <route>
     *
     * @return Void
     */
    private static function guard( Route $route ): Void
    {
        if( $route->meta() === HTTP\Route::ALLOW || $route->meta() === Null )
        {
            self::handler( $route );
        } else {
            if( $route->meta() === HTTP\Route::AUTH )
            {
                if( self::$auth->auth() )
                {
                    echo "User is auth";
                } else {
                    echo "User is not authentication";
                }
            }
            if( $route->meta() === HTTP\Route::GUEST )
            {
                if( self::$auth->auth() )
                {
                    echo "Redirect to dashboard.";
                } else {
                    self::handler( $route );
                }
            }
        }
    }
    
    protected static function handler( Route $route )
    {
        if( $route->redirect() !== Null )
        {
            // Redirects current page to destination.
            HTTP\HTTP::header( "location: {$route->redirect()}" );
        }
        foreach( $route->header() As $raw )
        {
            // Set header for page route.
            HTTP\HTTP::header( $raw[0], $raw[1], $raw[2] );
        }
        if( $route->handler() !== Null )
        {
            if( $route->response() !== Null )
            {
                // Set response content type for page.
                HTTP\HTTP::header( HTTP\HTTP::response( AoE\App::$object['response'] = $route->response() ), True );
            }
            if( is_callable( $route->handler() ) )
            {
                // Invoke callback function handler.
                self::render( Reflection\ReflectionFunction::invoke( $route->handler(), $route->params() ) );
            } else {
                
                // Invoke method function handler.
                self::render( Reflection\ReflectionMethod::invoke(
                    $instance = Reflection\ReflectionInstance::construct(
                        is_array( $route->handler() )
                            ? $route->handler()[0] 
                            : $route->handler()
                    ), 
                    is_array( $route->handler() ) 
                        ? $route->handler()[1] 
                        : "main", 
                    $route->params() 
                ));
            }
        } else {
            if( $route->view !== Null )
            {
                echo( view( $route->view(), $route->params() ) );
            } else {
                echo "*";
            }
        }
    }
    
    /*
     * Render the page route if the handler returns a value.
     *
     * @access Protected, Static
     *
     * @params Mixed <value>
     *
     * @return ...
     */
    protected static function render( Mixed $value, Bool $print = True )//: Void
    {
        if( is_int( $value ) === False && 
            is_null( $value ) === False && 
            is_string( $value ) === False )
        {
            $value = ( 
                is_bool( $value ) 
                    ? ( 
                        $bool 
                            ? "True" 
                            : "False" 
                    ) 
                    : $value 
            );
            $value = ( 
                is_array( $value ) 
                    ? json_encode( $value, JSON_PRETTY_PRINT ) 
                    : $value 
            );
            $value = ( 
                is_callable( $value ) 
                    ? self::render( Reflection\ReflectionFunction::invoke( $value ), False ) 
                    : $value 
            );
            $value = ( 
                is_object( $value ) 
                    ? ( 
                        $value Instanceof Stringable 
                            ? $value->__toString() 
                            : $value::class 
                    )
                    : $value
            );
        }
        if( $print !== True )
        {
            return( $value );
        }
        echo( $value );
    }
    
}

?>