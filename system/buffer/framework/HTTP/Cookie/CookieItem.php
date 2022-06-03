<?php

namespace Yume\Kama\Obi\HTTP\Cookie;

use Yume\Kama\Obi\AoE;
use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Reflection;
use Yume\Kama\Obi\Security\BuiltIn\AES256 As Aes;

use ArrayAccess;

final class CookieItem extends Cookie
{
    
    /*
     * The name of the cookie.
     * 
     * @access Public, Readonly
     * 
     * @values String
     */
    public /* Readonly */ String $name;

    /*
     * The path on the server in which the
     * Cookie will be available on.
     * 
     * @access Public
     * 
     * @values String
     */
    public ? String $path = "/";
    
    /*
     * The value of the cookie. This value is stored
     * On the clients computer.
     * 
     * @access Public
     * 
     * @values String, Null
     */
    public ? String $value = Null;
    
    /*
     * The time the cookie expires. This is a Unix timestamp
     * So is in number of seconds since the epoch.
     * 
     * @access Public
     * 
     * @values Int, String
     */
    public Int | String $expire = 0;
    
    /*
     * The <sub>domain that the cookie is available to.
     * 
     * @access Public
     * 
     * @values String, Null
     */
    public ? String $domain = Null;
    
    /*
     * When true the cookie will be made accessible only
     * Through the HTTP protocol.
     * 
     * @access Public
     * 
     * @values Bool
     */
    public Bool $httpOnly = True;
    
    /*
     * Indicates that the cookie should only be transmitted
     * Over a secure HTTPS connection from the client.
     * 
     * @access Public
     * 
     * @values Bool
     */
    public Bool $secureOnly = False;
    
    public String $sameSiteRestriction = parent::SAME_SITE_R_L;
    
    public function __construct( String $name )
    {
        $this->name = parent::name( $name );
        $this->value = parent::get( $name );
    }
    
    /*
     * Allows a class to decide how it will
     * React when it is treated like a string.
     * 
     * @access Public
     * 
     * @return String
     */
    public function __toString(): String
    {
        return( parent::create( $this ) );
    }
    
    /*
     * Save cookie.
     * 
     * @access Public
     * 
     * @return Bool
     */
    public function save(): Bool
    {
        return( parent::entry( $this ) );
    }
    
    public function path( String $path = "/" ): Static
    {
        if( $this->path !== $path )
        {
            $this->path = $path;
        }
        return( $this );
    }
    
    public function value( ? String $value = Null ): Static
    {
        if( $value !== Null && $valE = parent::config( "cookie.encrypt.val" ) )
        {
            $this->value = Aes::encrypt( $value, $valE );
        } else {
            $this->value = $value;
        }
        return( $this );
    }
    
    public function expire( Int | String $expire = 0 ): Static
    {
        if( is_string( $expire ) )
        {
            $this->expire = ( clone AoE\App::$object->dateTime )->modify( $expire )->getTimestamp();
        } else {
            $this->expire = $expire;
        }
        return( $this );
    }
    
}

?>