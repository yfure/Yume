<?php

namespace Yume\Fure\HTTP\Routing;

use Yume\Fure\Error;

/*
 * RouteSegment
 *
 * @package Yume\Fure\HTTP\Routing
 */
abstract class RouteSegment
{
    
    /*
     * Registered segment list.
     *
     * @access Protected Static
     *
     * @values Array
     */
    protected static Array $segments = [];
    
    /*
     * Get regex by segment name.
     *
     * @access Public Static
     *
     * @params String $key
     *
     * @return String|False
     */
    public static function get( String $key ): False | String
    {
        return( isset( self::$segments[$key] ) ? self::$segments[$key] : False );
    }
    
    /*
     * Set regex for segment.
     *
     * @access Public Static
     *
     * @params String $key
     * @params String $reg
     *
     * @return String
     */
    public static function set( String $key, String $reg ): String
    {
        return( self::$segments[$key] = $reg );
    }
    
}

?>