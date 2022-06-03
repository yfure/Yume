<?php

namespace Yume\Kama\Obi\Security\Symmetric;

use phpseclib3\Crypt;

use Yume\Kama\Obi\Reflection;
use Yume\Kama\Obi\Security;

abstract class AES
{
    
    protected static $chiper;
    protected static $config;
    
    /*
     * ....
     *
     * @access Public, Static
     *
     * @return String
     */
    public static function decrypt( String $data, String $iv, ?String $key = Null, ?Array $password = Null )
    {
        return( self::prepare( $iv, $key, $password )->decrypt( base64_decode( $data ) ) );
    }
    
    /*
     * ....
     *
     * @access Public, Static
     *
     * @return String
     */
    public static function encrypt( String $data, String $iv, ?String $key = Null, ?Array $password = Null )
    {
        return( base64_encode( self::prepare( $iv, $key, $password )->encrypt( $data ) ) );
    }
    
    public static function prepare( String $iv, ?String $key = Null, ?Array $password = Null ): Crypt\AES
    {
        // ....
        $chiper = self::chiper();
        
        // ....
        $chiper->setIV( $iv );
        
        if( $password === Null ) {
            
            // ....
            $chiper->setKey( $key );
        } else {
            
            // ....
            Reflection\ReflectionMethod::invoke( $chiper, "setPassword", $password );
        }
        return( $chiper );
    }
    
    public static function chiper(): Crypt\AES
    {
        if( self::$chiper === Null ) {
            if( self::$config === Null ) {
                self::$config = Security\Security::config( "Symmetric.AES" );
            }
            
            // Create new AES Class Instance.
            self::$chiper = new Crypt\AES( self::$config['mode'] );
            
            // Set default preferred engine.
            self::$chiper->setPreferredEngine( self::$config['engine'] );
            
            // Set default key length.
            self::$chiper->setKeyLength( self::$config['keyLength'] );
        }
        return( self::$chiper );
    }
    
}

?>