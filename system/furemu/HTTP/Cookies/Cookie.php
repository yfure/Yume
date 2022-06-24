<?php

namespace Yume\Kama\Obi\HTTP\Cookies;

use Yume\Kama\Obi\RegExp;

abstract class Cookie
{
    
    /*
     * Returns all set cookies.
     *
     * @access Public Static
     *
     * @return Yume\Kama\Obi\HTTP\Cookies\CookieIterator
     */
    public static function getAll(): CookieIterator
    {
        $cookies = [];
        
        foreach( $_COOKIE As $name => $value )
        {
            $cookies[] = self::set( $name, urldecode( $value ) );
        }
        return( new CookieIterator( $cookies ) );
    }
    
    public static function parse( String $header )//: CookieHeader
    {
        if( $match = RegExp\RegExp::match( "/^(Set\-Cookie)\:\s*(.*)\=(.*?)(?:;\s(.*?))?$/i", $header ) )
        {
            
        }
        throw new CookieError( $header, CookieError::INVALID_HEADER );
    }
    
    /*
     * Delete cookie
     *
     * @access Public Static
     *
     * @params String $name
     *
     * @return Bool
     */
    public static function del( String $name ): Bool
    {
        if( isset( $_COOKIE[$name] ) )
        {
            unset( $_COOKIE[$name] );
        }
        return( self::set( $name, Null, [ "expires" => 0 ] )->save() );
    }
    
    /*
     * Get new CookieHeader instance.
     *
     * @access Public Static
     *
     * @params String $name
     *
     * Yume\Kama\Obi\HTTP\Cookies\CookieHeader|Bool
     */
    public static function get( String $name ): CookieHeader | Bool
    {
        if( isset( $_COOKIE[$name] ) )
        {
            return( self::set( $name, urldecode( $_COOKIE[$name] ) ) );
        }
        return( False );
    }
    
    /*
     * Create new CookieHeader instance.
     *
     * @access Public Static
     *
     * @params String $name
     * @params String $value
     * @params Array $options
     *
     * @return Yume\Kama\Obi\HTTP\Cookies\CookieHeader
     */
    public static function set( String $name, ? String $value = Null, Array $options = [] ): CookieHeader
    {
        return( new CookieHeader( $name, $value, $options ) );
    }
    
}

?>