<?php

namespace Yume\Kama\Obi\HTTP\Cookies;

use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\RegExp;
use Yume\Kama\Obi\Trouble;

use Stringable;

/*
 * CookieHeader
 *
 * Raw Cookies header.
 *
 * @package Yume\Kama\Obi\HTTP\Cookies
 */
final class CookieHeader implements Stringable
{
    
    /*
     * Give cookie comment.
     *
     * @access Public
     *
     * @values String
     */
    public ? String $comment = Null;
    
    /*
     * Give cookie version.
     *
     * @access Public
     *
     * @values String
     */
    public ? String $version = Null;
    
    /*
     * Defines the host to which the cookie will be sent.
     *
     * @access Public
     *
     * @values String
     */
    public ? String $domain = Null;
    
    /*
     * Indicates the path that must exist in the requested
     * URL for the browser to send the Cookie header.
     *
     * @access Public
     *
     * @values String
     */
    public ? String $path = Null;
    
    /*
     * Controls whether or not a cookie is sent with
     * cross-origin requests, providing some protection
     * against cross-site request forgery attacks (CSRF).
     *
     * @access Public
     *
     * @values String
     */
    public ? String $sameSite = Null;
    
    /*
     * Forbids JavaScript from accessing the cookie.
     *
     * @access Public
     *
     * @values Bool
     */
    public Bool $httpOnly = False;
    
    /*
     * Indicates that the cookie is sent to the
     * server only when a request is made with the https://
     *
     * @access Public
     *
     * @values Bool
     */
    public Bool $secure = False;
    
    /*
     * Indicates the maximum lifetime of
     * the Cookie as an HTTP-date timestamp.
     *
     * @access Public
     *
     * @values Int
     */
    public Int | String | Null $expires = Null;
    
    /*
     * Indicates the number of seconds until the cookie expires.
     *
     * @access Public
     *
     * @values Int
     */
    public ? Int $maxAge = Null;
    
    /*
     * Construct method of class CookieHeader
     *
     * @access Public Instance
     *
     * @params String $name
     * @params String $value
     * @params Array $options
     * @params Bool $save
     *
     * @return Void
     */
    public function __construct( public String $name, public ? String $value = Null, Array $options = [], Bool $save = False )
    {
        $this->set( "name", $name );
        $this->set( "value", $value );
        
        foreach( $options As $attribute => $value )
        {
            $this->set( $attribute, $value );
        }
        if( $save )
        {
            $this->save();
        }
    }
    
    public function __toString(): String
    {
        return( $this->raw() );
    }
    
    /*
     * Save cookie header.
     *
     * @access Public
     *
     * @return Bool
     */
    public function save(): Bool
    {
        // Set header.
        HTTP\HTTP::header( $this->raw() );
        
        // Add to super global.
        $_COOKIE[$this->name] = $this->value;
        
        // Always True return.
        return( True );
    }
    
    /*
     * Set cookie attribute.
     *
     * @access Public
     *
     * @params String $attribute
     * @params String|Null|Bool|Int $value
     *
     * @return Static
     */
    public function set( String $attribute, String|Null|Bool|Int $value ): Static
    {
        // Checks if the cookie has the attribute to set.
        if( property_exists( $this, $attribute = lcfirst( RegExp\RegExp::replace( "/\-/", $attribute, "" ) ) ) )
        {
            $this->{ $attribute } = $value;
        } else {
            throw new Trouble\AttributeError( f( "Cookie object has no attribute \"{}\"", $attribute ) );
        }
        return( $this );
    }
    
    /*
     * Generates the raw header of the cookie.
     *
     * @access Public
     *
     * @return String
     */
    public function raw(): String
    {
        if( RegExp\RegExp::test( "/(\s|\n|\r|\t|\(|\)|\<|\>|\@|\,|\;|\:|\\|\"|\'|\/|\[|\]|\?|\=|\{|\})/", $name = $this->name ) === False )
        {
            // Get Cookie Value.
            $value = $this->value;
            
            // If the Cookie value is empty,
            // the cookie expiration value will
            // automatically be changed to negative.
            if( $value === Null || $value === "None" )
            {
                $this->value = $value = "None";
                $this->expires = -1;
            }
            
            // Raw Cookie Header.
            $header = f( "Set-Cookie: {}={}", $name, urlencode( $value ) );
            
            $header .= $this->version ? f( "; Version={}", $this->version ) : "";
            $header .= $this->comment ? f( "; Comment=\"{}\"", urlencode( RegExp\RegExp::replace( "/^(?:\"(.*?)\")$/", $this->comment, "$1" ) ) ) : "";
            
            if( $domain = $this->domain )
            {
                // Checks if the cookie domain name is invalid.
                if( RegExp\RegExp::test( "/^(?:([a-z0-9][a-z0-9\-\.]{1,61}[a-z0-9])\.([a-z]{2,}))$/i", $domain ) === False )
                {
                    throw new CookieError( $domain, CookieError::INVALID_DOMAIN );
                }
                $header .= f( "; Domain={}", $domain );
            }
            
            if( $path = $this->path )
            {
                // Checks if the cookie pathname is invalid.
                if( RegExp\RegExp::test( "/^\/(?:\w+\/?){0,}$/", $path ) === False )
                {
                    throw new CookieError( $path, CookieError::INVALID_PATH );
                }
                $header .= f( "; Path={}", $path );
            }
            
            if( $sameSite = $this->sameSite )
            {
                // Check if the samesite value does not match.
                if( $sameSite !== "Lax" &&
                    $sameSite !== "None" &&
                    $sameSite !== "Strict" )
                {
                    throw new CookieError( $sameSite, CookieError::INVALID_SAMESITE );
                }
                $header .= f( "; SameSite={}", $sameSite );
            }
            
            if( $this->expires !== Null )
            {
                if( is_string( $expires = $this->expires ) )
                {
                    // Shortdays list.
                    $days = "Sun|Mon|Tue|Wed|Thu|Fri|Sat";
                    
                    // Shortmonths list.
                    $months = "Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec";
                    
                    // Checks if the expired value is the default of the parsed cookie (e.g... Mon, 23-May-2022 H:i:s GMT)
                    if( RegExp\RegExp::test( "/^(?:({$days})\,\s(\d{2})\-({$months})\-(\d{4})\s(\d{2})\:(\d{2})\:(\d{2})\s(GMT))$/i", $expires ) )
                    {
                        $header .= f( "; expires={}", $expires );
                    } else
                    
                    // If the expiration value is a time string (e.g... 1|+1|-1 days)
                    if( RegExp\RegExp::test( "/^(?:(\+|\-)*(\d)\s(seconds|minutes|hours|days|weeks|months|years))$/i", $expires ) )
                    {
                        $header .= f( "; expires={}", gmdate( "D, d-M-Y H:i:s T", strtotime( $expires ) ) );
                    } else {
                        throw new CookieError( $expires, CookieError::INVALID_EXPIRES );
                    }
                } else {
                    
                    // If the length of the expiration value is below ten it will
                    // be converted to days, because if the length of the expiration
                    // number is 10 <more if possible> it will be considered as a Timestamp.
                    if( strlen( RegExp\RegExp::replace( "/\+|\-/", "{$expires}", "" ) ) < 10 )
                    {
                        // 1|+1|-1 === 1 Day
                        $expires = strtotime( f( "{} days", $expires ) );
                    }
                    $header .= f( "; expires={}", gmdate( "D, d-M-Y H:i:s T", $expires ) );
                }
            }
            
            if( $this->maxAge !== Null )
            {
                $maxAge = $this->maxAge;
                
                // If the Max-Age is not more than or equal to 1.9 years.
                if( $maxAge <= 999999 )
                {
                    // Multiply the Max-Age value by 60 seconds 1
                    // second equals 1000, 1 Max-Age equals 1 minute.
                    $maxAge = $maxAge * 60 * 100;
                }
                $header .= f( "; Max-Age={}", $maxAge );
            }
            
            // This means cookies can only be accessed by the server.
            $header .= $this->httpOnly ? ";\x20HttpOnly" : "";
            
            $header .= $this->secure ? ";\x20Secure" : "";
            
            return( $header );
        }
        throw new CookieError( $name, CookieError::INVALID_NAME );
    }
    
    
    
}

?>