<?php

namespace Yume\Fure\HTTP;

use Yume\Fure\RegExp;

/*
 * HTTPRequest
 *
 * @package Yume\Fure\HTTP
 */
abstract class HTTPRequest extends HTTP
{
    
    /*
     * Return route of current page.
     *
     * @access Public Static
     *
     * @return String
     */
    public static function uri(): String
    {
        // Get current request uri.
        $uri = isset( $_SERVER['REQUEST_URI'] ) ? ( ( $r = rtrim( $_SERVER['REQUEST_URI'], "/" ) ) !== "" ? $r : "/" ) : "/";
        
        // If server request has query string.
        if( $query = self::queryString() )
        {
            // Remove query string in request uri.
            $uri = str_replace( f( "?{}", $query ), "", $uri );
        }
        return( $uri );
    }
    
    /*
     * Return current page method or match current page method.
     *
     * @access Public Static
     *
     * @params String $match
     *
     * @return String|Bool
     */
    public static function method( ? String $match = Null ): Bool | String
    {
        if( $match !== Null )
        {
            return( RegExp\RegExp::test( f( "/^(?:({}))$/i", $match ), self::method() ) );
        }
        return( $_SERVER['REQUEST_METHOD'] );
    }
    
    public static function time(): Int
    {
        return( $_SERVER['REQUEST_TIME'] );
    }
    
    public static function timeFloat(): Float
    {
        return( $_SERVER['REQUEST_TIME_FLOAT'] );
    }
    
    public static function queryString(): ? String
    {
        return( isset( $_SERVER['QUERY_STRING'] ) ? $_SERVER['QUERY_STRING'] : Null );
    }
    
}

?>