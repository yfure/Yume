<?php

namespace Yume\Kama\Obi\HTTP;

/*
 * Request utility class.
 *
 * @package Yume\Kama\Obi\HTTP
 */
abstract class Request extends Server
{
    
    /*
     * Current route page.
     *
     * @access Protected
     *
     * @values String
     */
    protected static $uri;
    
    /*
     * Return route of current page.
     *
     * @access Public, Static
     *
     * @return String
     */
    public static function uri(): String
    {
        if( self::$uri === Null )
        {
            if( isset( $_SERVER['REQUEST_URI'] ) )
            {
                $r = rtrim( SERVER_REQUEST_URI, "/" );
                
                if( $r !== "" && $r !== Null )
                {
                    self::$uri = $r;
                } else {
                    self::$uri = "/";
                }
            } else {
                self::$uri = "/";
            }
        }
        return( self::$uri );
    }
    
    /*
     * Return current page method or match current page method.
     *
     * @access Public, Static
     *
     * @params String, Null <match>
     *
     * @return String, Bool
     */
    public static function method( ? String $match = Null ): Bool | String
    {
        if( $match !== Null )
        {
            return( $match === self::method() );
        }
        return( SERVER_REQUEST_METHOD );
    }
    
}

?>