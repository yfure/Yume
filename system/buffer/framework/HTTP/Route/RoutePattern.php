<?php

namespace Yume\Kama\Obi\HTTP\Route;

use Yume\Kama\Obi\HTTP;

/*
 * The Route Pattern Class
 *
 * @author hxAri
 * @create 19.03-2022
 * @update 21.03-2022
 *
 * @object Abstract
 */
abstract class RoutePattern
{
    
    /*
     * Default route pattern.
     *
     * @access Public, Static
     *
     * @values String
     */
    public static $default = "[a-zA-Z0-9\-\_]+";
    
    /*
     * Route segment replace.
     *
     * @access Public, Static
     *
     * @values String
     */
    public static $replace = "/\:([a-zA-Z0-9\-\_]+)/";
    
    /*
     * Route segment search.
     *
     * @access Public, Static
     *
     * @values String
     */
    public static $segment = "/\:([a-zA-Z0-9\-\_]+)|\(.*?\)/";
    
    /*
     * Route segment pattern.
     *
     * @access Private, Static
     *
     * @values Array
     */
    private static $where = [];
    
    /*
     * Create an equalization pattern for route.
     *
     * @access Public, Static
     *
     * @params Yume\Kama\Obi\HTTP\Route\Route <route>
     *
     * @return String
     */
    public static function create( Route $route )
    {
        $route->pattern( $route->path() );
        
        if( count( $route->segment() ) !== 0 )
        {
            foreach( $route->segment() As $i => $segment )
            {
                $pattern = "/\:({$segment[1]})/";
                
                if( isset( $route->where()[$segment[1]] ) )
                {
                    $replace = $route->where()[$segment[1]];
                } else {
                    if( isset( self::$where[$segment[1]] ) )
                    {
                        $replace = self::$where[$segment[1]];
                    } else {
                        $replace = self::$default;
                    }
                }
                $route->pattern( HTTP\Filter\RegExp::replace( $pattern, $route->pattern(), "({$replace})", limit: 1 ) );
            }
        }
        return( $route->pattern() );
    }
    
    /*
     * Replace current route with pattern.
     *
     * @access Public, Static
     *
     * @params Yume\Kama\Obi\HTTP\Route\Route <route>
     *
     * @return Void
     */
    public static function pattern( Route $route )
    {
        $params = [];
        
        if( HTTP\Filter\RegExp::match( "@^{$route->pattern()}$@D", HTTP\Request::uri(), $params ) )
        {
            $route->path( array_shift( $params ) );
            $route->params( $params );
        }
    }
    
    /*
     * Add pattern for the same segment.
     *
     * @access Public, Static
     *
     * @params String <segment>
     * @params String <pattern>
     *
     * @return Void
     */
    public static function add( String $segment, String $pattern ): Void
    {
        // Insert new segment pattern.
        self::$where[$segment] = $pattern;
    }
    
    /*
     * Get pattern by segment name.
     *
     * @access Public, Static
     *
     * @params String <segment>
     *
     * @return String
     */
    public static function get( String $segment )
    {
        return( self::$where[$segment] );
    }
    
}

?>