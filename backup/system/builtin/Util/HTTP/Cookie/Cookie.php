<?php

namespace Yume\Kama\Obi\HTTP\Cookie;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Security\BuiltIn\AES256 As Aes;

/*
 * Cookie utility class.
 *
 * @package Yume\Kama\Obi\HTTP\Cookie
 */
abstract class Cookie extends HTTP\HTTP
{
    
    /*
     * Cookie prefix host.
     *
     * @access Public, Static
     *
     * @values String
     */
    public const PREFIX_HOST = "__Host-";
    
    /*
     * Cookie prefix secure.
     *
     * @access Public, Static
     *
     * @values String
     */
    public const PREFIX_SECURE = "__Secure-";
    
    /*
     * Cookie prefix header.
     *
     * @access Public, Static
     *
     * @values String
     */
    public const PREFIX_HEADER = "Set-Cookie:";
    
    const SAME_SITE_R_L = "Lax";
    const SAME_SITE_R_N = "None";
    const SAME_SITE_R_S = "Strict";
    
    /*
     * Return new cookie item.
     *
     * @access Public, Static
     *
     * @params String <key>
     *
     * @return Yume\Kama\Obi\HTTP\Cookie\CookieItem
     */
    public static function item( String $key ): CookieItem
    {
        return( new CookieItem( $key ) );
    }
    
    /*
     * Cookie name validation.
     *
     * @access Public, Static
     *
     * @params String <name>
     *
     * @return String
     */
    public static function name( String $name ): String
    {
        if( ( $name = HTTP\Filter\RegExp::replace( "/([^\w])/", $name, "" ) ) === "" )
        {
            throw new \UnexpectedValueException( "Cookie name can't be empty!" );
        } else {
            if( $keyE = parent::config( "cookie.encrypt.key" ) )
            {
                $name = HTTP\Filter\RegExp::replace( "/([^\w])/", crypt( $name, $keyE ), "" );
            }
            return( $name );
        }
    }
    
    /*
     * Get cookie by key name.
     *
     * @access Public, Static
     *
     * @params String <name>
     *
     * @return Mixed
     */
    public static function get( String $name ): Mixed
    {
        $value = Null;
        
        if( isset( $_COOKIE[$name] ) )
        {
            $value = $_COOKIE[$name];
        } else {
            if( isset( $_COOKIE[( $name = self::name( $name ) )] ) )
            {
                $value = $_COOKIE[$name];
            }
        }
        if( $valE = parent::config( "cookie.encrypt.val" ) )
        {
            if( $valD = Aes::decrypt( $value, $valE ) )
            {
                return( $valD );
            }
        }
        return( $value );
    }
    
    /*
     * Set new cookie.
     *
     * @access Public, Static
     *
     * @params <>
     *
     * @return Yume\Kama\Obi\HTTP\Cookie\CookieItem
     */
    public static function set( Array | String $name ): CookieItem
    {
        return( self::item( $name ) );
    }
    
    /*
     * Check if cookie exists.
     *
     * @access Public, Static
     *
     * @params String <name>
     *
     * @return Bool
     */
    public static function isset( String $name ): Bool
    {
        return( isset( $_COOKIE[$name] ) ? True : isset( $_COOKIE[self::name( $name )] ) );
    }
    
    /*
     * Remove or Unset cookie.
     *
     * @access Public, Static
     *
     * @params String <name>
     *
     * @return Bool
     */
    public static function unset( String $name ): Bool
    {
        // Unset cookie from group.
        unset( $_COOKIE[self::name( $name )] );
        
        return( self::entry( self::item( $name )->expire( 0 ) ) );
    }
    
    /*
     * Save new cookie header.
     * 
     * @access Public, Static
     * 
     * @params Util\Octancle\Cookie\CookieItem <cookie>
     * 
     * @return Bool
     */
    public static function entry( CookieItem $cookie ): Bool
    {
        if( headers_sent() === False )
        {
            if( empty( $header = self::create( $cookie ) ) === False )
            {
                // send a raw HTTP header.
                parent::header( $header, False );
                
                return True;
            }
        }
        return False;
    }
    
    /*
     * Create RAW Cookie header.
     * 
     * @access Public, Static
     * 
     * @params Yume\Kama\Obi\Cookie\CookieItem <cookie>
     * 
     * @return String
     */
    public static function create( CookieItem $cookie )
    {
        if( self::isInvalidName( $cookie->name ) )
        {
            throw new \UnexpectedValueException( "Unexpected error, invalid cookie name." );
        } else {
            if( self::isInvalidExpire( $cookie->expire ) )
            {
                throw new \UnexpectedValueException( "Unexpected error, invalid cookie expire." );
            } else {
                if( is_string( $cookie->expire ) )
                {
                    $cookie->expire = ( clone AoE\App::$object->dateTime )->modify( $cookie->expire )->getTimestamp();
                }
                $forceShowExpiry = False;
                
                if( $cookie->value === Null || $cookie->value === False || $cookie->value === "" )
                {
                    $cookie->value = "deleted";
                    $cookie->expire = 0;
                    $forceShowExpiry = True;
                }
                
                $maxAge = self::formatMaxAge( $cookie->expire, $forceShowExpiry );
                $expTime = self::formatExpireTime( $cookie->expire, $forceShowExpiry );
                
                $header = self::PREFIX_HEADER . "{$cookie->name}=" . urlencode( $cookie->value );
                
                if( $cookie->expire !== Null )
                {
                    $header .= "; expires={$expTime}";
                }
                
                if( $maxAge !== Null )
                {
                    $header .= "; Max-Age={$maxAge}";
                }
                
                if( $cookie->path )
                {
                    $header .= "; path={$cookie->path}";
                }
                
                if( $cookie->domain !== "" && $cookie->domain !== Null )
                {
                    $header .= "; domain={$cookie->domain}";
                }
                
                if( $cookie->secureOnly )
                {
                    $header .= "; secure";
                }
                
                if( $cookie->httpOnly )
                {
                    $header .= "; httponly";
                }
                
                if( $cookie->sameSiteRestriction === self::SAME_SITE_R_N )
                {
                    if( $cookie->secureOnly === False )
                    {
                        throw new \UnexpectedValueException( "When the 'SameSite' attribute is set to 'None', the 'secure' attribute should be set as well" );
                    }
                    $header .= "; SameSite=None";
                } else
                if( $cookie->sameSiteRestriction === self::SAME_SITE_R_L )
                {
                    $header .= "; SameSite=Lax";
                } else
                if( $cookie->sameSiteRestriction === self::SAME_SITE_R_S )
                {
                    $header .= "; SameSite=Strict";
                }
                return $header;
            }
        }
    }
    
    /*
     * Parse the cookie header.
     * 
     * @access Public, Static
     * 
     * @params String <header>
     * 
     * @return Undefined
     */
    public static function parser( String $header )
    {
        
    }
    
    /*
     * If cookie name is invalid.
     * 
     * @access Public, Static
     * 
     * @params String <name>
     * 
     * @return Bool
     */
    public static function isInvalidName( String $name ): Bool
    {
        return( HTTP\Filter\RegExp::match( "/[=,; \t\r\n\013\014]/", "{$name}" ) );
    }
    
    /*
     * ....
     * 
     * @access Public, Static
     * 
     * @params String, Int <expire>
     * 
     * @return Bool
     */
    public static function isInvalidExpire( String | Int $expire ): Bool
    {
        if( is_int( $expire ) )
        {
            return( is_numeric( $expire ) === False );
        }
        return( HTTP\Filter\RegExp::match( "/\+([0-9]+)\s(days|months|years|hours|minutes|seconds)/", $expire ) === False );
    }
    
    /*
     * Return calculate maxmimum age.
     *
     * @access Private, Static
     *
     * @params Int <expire>
     *
     * @return Int
     */
    private static function calculateMaxAge( $expire ): Int
    {
        if( $expire === 0 )
        {
            return 0;
        } else {
            return( $expire - time() );
        }
    }
    
    /*
     * Return format expire time.
     *
     * @access Public, Static
     *
     * @params <>
     * @params <>
     *
     * @return String
     */
    public static function formatExpireTime( $expire, $fs = False ): String
    {
        if( $expire > 0 || $fs )
        {
            if( $fs )
            {
                $expire = 1;
            }
            return gmdate( "D, d-M-Y H:i:s T", $expire );
        } else {
            return null;
        }
    }
    
    /*
     * Return format maximum age.
     *
     * @access Public, Static
     *
     * @params <>
     * @params <>
     *
     * @return String
     */
    public static function formatMaxAge( $expire, $fs = False )
    {
        if( $expire > 0 || $fs )
        {
            return( ( String ) self::calculateMaxAge( $expire ) );
        } else {
            return Null;
        }
    }
    
    /*
     * Domain name normalization.
     * 
     * @access Public, Static
     * 
     * @params String, Null <domain>
     * 
     * @return String, Null
     */
    public static function normalizeDomain( ? String $domain ): ? String
    {
        if( $domain !== Null )
        {
            if( filter_var( $domain, FILTER_VALIDATE_IP ) !== false )
            {
                return Null;
            }
            if( strpos( $domain, "." ) === false )
            {
                return Null;
            }
            if( strrpos( $domain, "." ) === 0 )
            {
                return Null;
            }
            if( $domain[0] !== "." )
            {
                return ".{$domain}";
            }
        } else {
            return Null;
        }
    }
    
}

?>