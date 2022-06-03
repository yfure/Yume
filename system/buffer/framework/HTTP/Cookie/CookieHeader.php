<?php

namespace Yume\Kama\Obi\HTTP\Cookie;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\Security\BuiltIn\ASE256 As Aes;

abstract class CookieHeader
{

    /*
     * Save new cookie header.
     * 
     * @access Public, Static
     * 
     * @params Util/Octancle/Cookie/CookieItem <cookie>
     * 
     * @return Bool
     */
    public static function entry( CookieItem $cookie ): Bool
    {
        if( headers_sent() === False )
        {
            if( empty( $header ) === False )
            {
                // send a raw HTTP header.
                HTTP\HTTP::header( self::create( $cookie ), False );
                
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
                    $cookie->expire = ( clone AoE\App::$object->object->object->object->object->object->object->dateTime )->modify( $cookie->expire )->getTimestamp();
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
                
                $header = Cookie::PREFIX_HEADER . "{$cookie->name}=" . urlencode( $cookie->value );
                
                if( $expired !== Null )
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
                
                if( $cookie->sameSiteRestriction === Cookie::SAME_SITE_R_N )
                {
                    if( $cookie->secureOnly === False )
                    {
                        throw new \UnexpectedValueException( "When the 'SameSite' attribute is set to 'None', the 'secure' attribute should be set as well" );
                    }
                    $header .= "; SameSite=None";
                } else
                if( $cookie->sameSiteRestriction === Cookie::SAME_SITE_R_L )
                {
                    $header .= "; SameSite=Lax";
                } else
                if( $cookie->sameSiteRestriction === Cookie::SAME_SITE_R_S )
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
     * @params <header>
     * 
     * @return Undefined
     */
    public static function parser( $header )
    {
        //
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

    private static function calculateMaxAge( $expire ) {
        if( $expire === 0 )
        {
            return 0;
        } else {
            return( $expire - time() );
        }
    }

    public static function formatExpireTime( $expire, $fs = False )
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

    public static function formatMaxAge( $expire, $fs = False )
    {
        if( $expire > 0 || $fs )
        {
            return( ( string ) self::calculateMaxAge( $expire ) );
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
        if( $domain !== Null ) {
            if( filter_var( $domain, FILTER_VALIDATE_IP ) !== false ) {
                return Null;
            }
            if( strpos( $domain, "." ) === false ) {
                return Null;
            }
            if( strrpos( $domain, "." ) === 0) {
                return Null;
            }
            if( $domain[0] !== "." ) {
                return ".{$domain}";
            }
        } else {
            return Null;
        }
    }

}

?>