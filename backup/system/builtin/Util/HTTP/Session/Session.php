<?php

namespace Yume\Kama\Obi\HTTP\Session;

use function Yume\Func\config;

use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Reflection;
use Yume\Kama\Obi\Security;
use Yume\Kama\Obi\Security\BuiltIn\AES256;

/*
 * Session utility class.
 *
 * @package Yume\Kama\Obi\Octancle\Session
 */
abstract class Session extends HTTP\HTTP
{
    /*
     * Session Handler Instance.
     *
     * @values Yume\Kama\Obi\HTTP\Session\SessionHandler
     */
    protected static $driver;
    
    /*
     * Starting new session.
     * 
     * @access Public, Static
     * 
     * @return Void
     */
    public static function start(): Void
    {
        
        $params = [
            
            // Get Iv Value.
            parent::config( "session.handler.iv" ),
            
            // Get Key Name.
            parent::config( "session.handler.key" ),
            
            // Get Password Parameter.
            parent::config( "session.handler.password" )
            
        ];
        
        // Create Handler Instance.
        self::$driver = Reflection\ReflectionInstance::construct( parent::config( "session.handler.driver" ), $params );
        
        if( self::$driver Instanceof SessionHandlerInterface )
        {
            
            // Set the value of a configuration session.
            ini_set( "session.save_handler", "files" );
            
            // Set user-level session storage functions.
            session_set_save_handler( self::$driver );
            
            // Start new or resume existing session.
            session_start();
            
        } else {
            throw new \RuntimeException( "The Driver Session Handler class must implement Yume\Kama\Obi\StorageHandlerInterface class" );
        }
        
    }
    
    /*
     * Remove session set by key.
     * 
     * @access Public, Static
     * 
     * @params String <key.
     * 
     * @return Void
     */
    public static function unset( String $key ): Void
    {
        unset( $_SESSION[self::keyE( $key )] );
    }
    
    /*
     * Check if the session is set.
     * 
     * @access Public, Static
     * 
     * @params String <key.
     * 
     * @return Bool
     */
    public static function isset( String $key ): Bool
    {
        return( isset( $_SESSION[self::keyE( $key )] ) );
    }
    
    /*
     * Set new session.
     * 
     * @access Public, Static
     * 
     * @params String <key>
     * @params Mixed <val>
     * 
     * @return Void
     */
    public static function set( String $key, Mixed $value ): Void
    {
        $_SESSION[self::keyE( $key )] = $value;
    }
    
    /*
     * Get session value.
     * 
     * @access Public, Static
     * 
     * @params String <key.
     * 
     * @return Mixed
     */
    public static function get( String $key ): Mixed
    {
        if( self::isset( $key ) )
        {
            return( $_SESSION[self::keyE( $key )] );
        }
        return Null;
    }
    
    /*
     * Encrypt session key name.
     * 
     * @access Public, Static
     * 
     * @params String <key>
     * 
     * @return String
     */
    public static function keyE( String $key ): String
    {
        if( $keyE = parent::config( "session.encrypt.key" ) )
        {
            return( HTTP\Filter\RegExp::replace( "/([^\w]+)/", crypt( $key, $keyE ), "" ) );
        }
        return $key;
    }
    
}

?>