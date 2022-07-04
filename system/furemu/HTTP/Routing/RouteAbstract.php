<?php

namespace Yume\Kama\Obi\HTTP\Routing;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\RegExp;

/*
 * RouteAbstract
 *
 * @package Yume\Kama\Obi\HTTP\Routing
 */
abstract class RouteAbstract
{
    
    /*
     * @inherit Yume\Kama\Obi\HTTP\Route::path
     *
     */
    public static function delete( String $path, Array | String | Callable $handler, ? Callable $children = Null ): Route
    {
        return( self::path( "DELETE", $path, $handler, $children ) );
    }
    
    /*
     * @inherit Yume\Kama\Obi\HTTP\Route::path
     *
     */
    public static function get( String $path, Array | String | Callable $handler, ? Callable $children = Null ): Route
    {
        return( self::path( "GET", $path, $handler, $children ) );
    }
    
    /*
     * @inherit Yume\Kama\Obi\HTTP\Route::path
     *
     */
    public static function head( String $path, Array | String | Callable $handler, ? Callable $children = Null ): Route
    {
        return( self::path( "HEAD", $path, $handler, $children ) );
    }
    
    /*
     * @inherit Yume\Kama\Obi\HTTP\Route::path
     *
     */
    public static function patch( String $path, Array | String | Callable $handler, ? Callable $children = Null ): Route
    {
        return( self::path( "PATCH", $path, $handler, $children ) );
    }
    
    /*
     * @inherit Yume\Kama\Obi\HTTP\Route::path
     *
     */
    public static function post( String $path, Array | String | Callable $handler, ? Callable $children = Null ): Route
    {
        return( self::path( "POST", $path, $handler, $children ) );
    }
    
    /*
     * @inherit Yume\Kama\Obi\HTTP\Route::path
     *
     */
    public static function put( String $path, Array | String | Callable $handler, ? Callable $children = Null ): Route
    {
        return( self::path( "PUT", $path, $handler, $children ) );
    }
    
    /*
     * Registers single routes to global routes.
     *
     * @access Public Static
     *
     * @params String $method
     * @params String $path
     * @params Array|String|Callable $handler
     * @params Null|Callable $children
     *
     * @return Yume\Kama\Obi\HTTP\Routing\Route
     */
    public static function path( String $method, String $path, Array | String | Callable $handler, ? Callable $children = Null ): Route
    {
        // Check if route is exists.
        if( self::exists( $path ) )
        {
            throw new RouteError( RegExp\RegExp::replace( "/(?:(?<Segment>\:(?<SegmentName>([a-z]+))(\((?<SegmentRegExp>[^\)]*)\))*))/", AoE\Runtime::$app->object->routes->__isset( "parent" ) ? f( "{}/{}", AoE\Runtime::$app->object->routes->parent, $path ) : $path, "\:$2" ), RouteError::DUPLICATE_PATH );
        } else {
            
            // If the route has children.
            if( $children !== Null )
            {
                
                // Copy global routes.
                $globalRoutes = AoE\Runtime::$app->object->routes;
                
                // Get parent routes.
                $parentRoutes = $globalRoutes['parent'] ? f( "{}/{}", $globalRoutes['parent'], $path ) : $path;
                
                // Replace global routes with child routes.
                $childsRoutes = AoE\Runtime::$app->object->routes = new Routes([ "parent" => $parentRoutes ]);
                
                // Execute a function that wraps a child route.
                call_user_func( $children );
                
                // Return value from global with routes global copied earlier.
                AoE\Runtime::$app->object->routes = $globalRoutes;
                
                // Copy child route list.
                $children = $childsRoutes;
                
            }
            
            // Registers routes to global routes.
            return( AoE\Runtime::$app->object->routes[] = new Route( $method, $path, $handler, $children ) );
        }
    }
    
    /*
     * Check if route path is exists.
     *
     * @access Public Static
     *
     * @params String $path
     *
     * @return Bool
     */
    public static function exists( String $path ): Bool
    {
        // Get routes from global.
        $routes = AoE\Runtime::$app->object->routes;
        
        foreach( $routes As $route )
        {
            if( $route Instanceof Route )
            {
                // Remove syntax regex from path.
                $replace = RegExp\RegExp::replace( "/(?:(?<Segment>\:(?<SegmentName>([a-z]+))(\((?<SegmentRegExp>[^\)]*)\))*))/", replace: "\:$2", subject: [ $route->getPath(), $path ]);
                
                // Check if the routes have the same.
                if( $replace[0] === $replace[1] )
                {
                    return( True );
                }
            }
        }
        return( False );
    }
    
    /*
     * Check if route path is exists.
     *
     * @access Public Static
     *
     * @params String $path
     * @params Yume\Kama\Obi\HTTP\Routing\Routes
     *
     * @return Bool
     */
    public static function isset( String $path, ? Routes $routes = Null ): Bool
    {
        if( $routes === Null )
        {
            // Get routes from global.
            $routes = AoE\Runtime::$app->object->routes;
        }
        foreach( $routes As $route )
        {
            if( $route Instanceof Route )
            {
                // Get route path.
                $ropath = $route->getPath();
                
                // Add parent path if it has parent.
                $ropath = $routes->__isset( "parent" ) ? f( "{}/{}", $routes->parent, $ropath ) : $ropath;
                
                // Remove syntax regex from path..
                $ropath = RegExp\RegExp::replace( "/(?:(?<Segment>\:(?<SegmentName>([a-z]+))(\((?<SegmentRegExp>[^\)]*)\))*))/", replace: "\:$2", subject: [ $ropath, $path ] );
                
                // if path name is same.
                if( $ropath[0] === $ropath[1] )
                {
                    return( True );
                } else {
                    
                    // Check if the route has children.
                    if( $childs = $route->getChild() )
                    {
                        // Repeating.
                        if( self::isset( $ropath[1], $childs ) )
                        {
                            return( True );
                        }
                    }
                }
            }
        }
        return( False );
    }
    
}

?>