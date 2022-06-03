<?php

namespace Yume\Kama\Obi\HTTP;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Trouble;

/*
 * HTTPRoute utility class.
 *
 * @package Yume\Kama\Obi\HTTP;
 */
abstract class Route
{
    
    /*
     * Notify if the page accessed requires authentication.
     *
     * @access Public, Static
     *
     * @values Hexadecimal
     */
    public const AUTH = 0x100;
    
    /*
     * This means the route is only accessible to visitors not to users.
     *
     * @access Public, Static
     *
     * @values Hexadecimal
     */
    public const GUEST = 0x671;
    
    /*
     * This will route the page accessible when the user is authenticated or not.
     *
     * @access Public, Static
     *
     * @values Hexadecimal
     */
    public const ALLOW = 0x729;
    
    /*
     * Identification for route not found or not defined.
     *
     * @access Public, Static
     *
     * @values String
     */
    public const NOTFOUND = "*";
    
    public static function add( Array | String $method = "GET", String $path = "*", Array | String | Callable $handler = [], ? Callable $group = Null ): Route\Route
    {
        if( self::exists( $path ) )
        {
            throw new Trouble\Exception\HTTPRouterError( "Unable to define same page route." );
        } else {
            if( $path === self::NOTFOUND ) {
                return( AoE\App::$object->routes[self::NOTFOUND] = new Route\Route([
                    'path' => $path,
                    'group' => $group,
                    'method' => $method,
                    'handler' => $handler
                ]));
            }
            return( AoE\App::$object->routes[] = new Route\Route([
                'path' => $path,
                'group' => $group,
                'method' => $method,
                'handler' => $handler
            ]));
        }
    }
    
    public static function view( Array | String $method = "GET", String $path = "*", String $view = "" )
    {
        if( self::exists( $path ) )
        {
            throw new Trouble\Exception\HTTPRouterError( "Unable to define same page route." );
        }
        return( AoE\App::$object->routes[] = new Route\Route([
            'path' => $path,
            'view' => $view,
            'method' => $method
        ]));
    }
    
    public static function exists( String $path ): Bool
    {
        if( str_replace( "\s", "", $path ) !== "" )
        {
            return( AoE\App::$object->routes->offsetExists( $path ) );
        } else {
            throw new Trouble\Exception\HTTPRouterError( "The route path cannot be empty." );
        }
    }
    
}

?>