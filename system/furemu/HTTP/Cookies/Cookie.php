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
    
    /*
     * Parse cookie header.
     *
     * @access Public Static
     *
     * @params String $header
     * @params Bool $save
     *
     * @return Yume\Kama\Obi\HTTP\Cookies\CookieHeader
     */
    public static function parse( String $header, Bool $save = False ): CookieHeader
    {
        // Checks if the header provided is valid.
        if( $match = RegExp\RegExp::match( "/(?:^Set\-Cookie\:\s*(.*?)\=(.*?)(?:;\s(.*?))?)$/i", $header ) )
        {
            // Create a new instance.
            $cookie = self::set( $match[1], urldecode( $match[2] ) );
            
            // If the cookie has the attribute.
            if( $match[3] !== Null )
            {
                
                // Split all attributes.
                $splits = explode( ";\x20", $match[3] );
                
                foreach( $splits As $split )
                {
                    // Separate attributes by value.
                    $split = explode( "=", $split );
                    
                    // Set cookie attribute.
                    $cookie->set( $split[0], call_user_func_array( args: [$split], callback: function( $split )
                    {
                        // If attribute is Max-Age.
                        if( $split[0] === "Max-Age" )
                        {
                            // Parse the value to Int, and divide the time
                            // Value by the number of seconds and minutes.
                            $split[1] = ( Int ) $split[1] / 60 / 100;
                        } else {
                            if( isset( $split[1] ) )
                            {
                                
                                // Decode string encoded with urlencode.
                                $split[1] = urldecode( $split[1] );
                            } else {
                                
                                // Only for HttpOnly and Secure attributes.
                                $split[1] = True;
                            }
                        }
                        return( $split[1] );
                    }));
                    
                }
                
            }
            
            // If autosave is allowed.
            if( $save )
            {
                // Save cookie.
                $cookie->save();
            }
            
            return( $cookie );
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