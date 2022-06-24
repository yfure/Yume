<?php

namespace Yume\Kama\Obi\HTTP\Cookies;

use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\RegExp;
use Yume\Kama\Obi\Trouble;

use Stringable;

class CookieHeader implements Stringable
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
    public ? Int $expires = Null;
    
    /*
     * Indicates the number of seconds until the cookie expires.
     *
     * @access Public
     *
     * @values Int
     */
    public ? Int $maxAge = Null;
    
    public function __construct( public String $name, public ? String $value = Null, Array $options = [] )
    {
        if( RegExp\RegExp::test( "/(\s|\n|\r|\t|\(|\)|\<|\>|\@|\,|\;|\:|\\|\"|\'|\/|\[|\]|\?|\=|\{|\})/", $name ) )
        {
            throw new CookieError( $name, CookieError::INVALID_NAME );
        } else {
            if( $value === Null )
            {
                $this->value = "None";
                $this->expires = -1;
            }
            foreach( $options As $attribute => $value )
            {
                if( property_exists( $this, $attribute ) )
                {
                    $this->{ $attribute } = $value;
                } else {
                    throw new Trouble\AttributeError( f( "Cookie object has no attribute \"{}\"", $attribute ) );
                }
            }
        }
    }
    
    public function __toString(): String
    {
        return( $this->raw() );
    }
    
    public function save(): Bool
    {
        // Set header.
        HTTP\HTTP::header( $this->raw() );
        
        // Always True return.
        return( True );
    }
    
    public function raw(): String
    {
        
        // Raw Cookie Header.
        $raw = f( "Set-Cookie: {}={}", $this->name, urlencode( $this->value !== Null ? $this->value : "None" ) );
        
        // If the cookie has a comment.
        if( $this->comment !== Null )
        {
            $raw .= f( "; Comment=\"{}\"", $this->comment );
        }
        
        // If the cookie has a domain name.
        if( $this->domain !== Null )
        {
            if( RegExp\RegExp::test( "/\s/", $this->domain ) )
            {
                throw new CookieError( $this->domain, CookieError::INVALID_DOMAIN );
            }
            if( RegExp\RegExp::replace( "/\s/", $this->domain, "" ) === "" )
            {
                throw new CookieError( $this->domain, CookieError::INVALID_DOMAIN );
            }
            $raw .= f( "; Domain={}", $this->domain );
        }
        
        // If the cookie has an expiration date.
        if( $this->expires !== Null )
        {
            $raw .= f( "; expires={}", gmdate( "D, d-M-Y H:i:s T", strtotime( f( "+{} days", $this->expires ) ) ) );
        }
        
        // If the cookie is read only the server.
        if( $this->httpOnly )
        {
            $raw .= "; HttpOnly";
        }
        
        // ....
        if( $this->maxAge !== Null )
        {
            $raw .= f( "; Max-Age={}", $this->maxAge * 60 * 1000 );
        }
        
        // If cookies are only set in certain locations.
        if( $this->path !== Null )
        {
            // If the location path name is valid.
            if( RegExp\RegExp::test( "/(?:^(\/\w+){0,}\/?)$/", $this->path ) )
            {
                $raw .= f( "; Path={}", $this->path );
            } else {
                throw new CookieError( $this->path, CookieError::INVALID_PATH );
            }
        }
        
        if( $this->sameSite !== Null )
        {
            switch( $this->sameSite )
            {
                case "Lax":
                    $raw .= "; SameSite=Lax";
                    break;
                case "None":
                    $raw .= "; SameSite=None";
                    break;
                case "Strict":
                    $raw .= "; SameSite=Strict";
                    break;
                default:
                    throw new CookieError( $this->sameSite, CookieError::INVALID_SAMESITE );
            }
        }
        
        // Otherwise the cookie is only sent
        // to the server when a request is made.
        if( $this->secure )
        {
            $raw .= "; Secure";
        }
        
        // If cookie has a version.
        if( $this->version !== Null )
        {
            $raw .= f( "; Version={}", $this->version );
        }
        
        // Returns the cookie's raw header value.
        return( $raw );
        
    }
    
}

?>