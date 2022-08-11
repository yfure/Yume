<?php

namespace Yume\Fure\HTTP\CSRFToken;

use Yume\Fure\AoE;
use Yume\Fure\Error;
use Yume\Fure\HTTP;
use Yume\Fure\RegExp;
use Yume\Fure\Seclib;
use Yume\Fure\Threader;

/*
 * CSRFToken
 *
 * @package Yume\Fure\HTTP\CSRF
 */
abstract class CSRFToken
{
    
    /*
     * CSRFToken validation global type.
     *
     * @access Public Static
     *
     * @values Int
     */
    public const GLOBAL_TYPE = 6432;
    
    /*
     * Csrftoken syntax.
     *
     * @access Protected Static
     *
     * @values String
     */
    protected static $syntax = "{};type={};timestamp={};timezone={}";
    
    /*
     * Generate new csrf token.
     *
     * @access Public Static
     *
     * @return String
     */
    public static function generate( Int | String $type = self::GLOBAL_TYPE ): String
    {
        // Generate random string for token.
        $token = hash( "sha512", AoE\Stringer::random( 256 ) );
        
        // Create cookie csrftoken.
        HTTP\Cookies\Cookie::set( "csrftoken", self::encode( self::format( $token, $type ) ), Threader\App::config( "http.csrf.cookie" ) )->save();
        
        return( $token );
    }
    
    /*
     * Validate csrf token.
     *
     * @access Public Static
     *
     * @return Bool
     */
    public static function validate( Int | String $type = self::GLOBAL_TYPE ): Bool
    {
        if( HTTP\HTTPRequest::method( "POST" ) )
        {
            if( isset( $_POST['csrftoken'] ) )
            {
                if( $parsed = self::parser() )
                {
                    // ...
                }
            }
        }
        return( False );
    }
    
    /*
     * Parse cookie value.
     *
     * @access Protected Static
     *
     * @return Array
     */
    protected static function parser(): Array | False
    {
        // Check if cookie exists.
        if( $cookie = HTTP\Cookies\Cookie::get( "csrftoken" ) )
        {
            // Decode encrypted cookie value.
            $decode = self::decode( $cookie->value );
            
            // Split decoded token.
            $splits = explode( ";", $decode );
            
            // ....
            $result = [];
            
            // Mapping split results.
            foreach( $splits As $i => $split )
            {
                if( $i === 0 )
                {
                    $result['token'] = $split;
                } else {
                    
                    // Split attribute.
                    $parts = explode( "=", $split );
                    
                    // Switch attribute type.
                    switch( $parts[0] )
                    {
                        case "timestamp":
                            if( RegExp\RegExp::test( "/^[\d]+$/", $parts[1] ) )
                            {
                                $result['timestamp'] = ( Int ) $parts[1];
                            } else {
                                throw new Error\TypeError( f( "Invalid value type, timestamp value must be type Int, \"{}\" given.", $parts[1] ) );
                            }
                            break;
                        case "timezone":
                            $result['timezone'] = $parts[1];
                            break;
                        default:
                            throw new Error\AttributeError( f( "Csrftoken doesn't have attribute \"{}\"", $parts[0] ) );
                    }
                }
            }
            return( $result );
        }
        return( False );
    }
    
    /*
     * Create format cookie value.
     *
     * @access Protected Static
     *
     * @params String $token
     *
     * @return String
     */
    protected static function format( String $token, Int | String $type = self::GLOBAL_TYPE ): String
    {
        // Get current time.
        $times = Threader\Runtime::$app->object->dateTime->getTimestamp();
        
        // Get timezone.
        $tzone = Threader\App::config( "timezone" );
        
        return( f( self::$syntax, $type, $token, $times, $tzone ) );
    }
    
    /*
     * Decrypt cookie value.
     *
     * @access Protected Static
     *
     * @params String $token
     *
     * @return String
     */
    protected static function decode( String $token ): String
    {
        return( Seclib\Simple\AES256::decrypt( $token, Threader\App::config( "http.csrf.password" ) ) );
    }
    
    /*
     * Encrypt cookie value.
     *
     * @access Protected Static
     *
     * @params String $token
     *
     * @return String
     */
    protected static function encode( String $token ): String
    {
        return( Seclib\Simple\AES256::encrypt( $token, Threader\App::config( "http.csrf.password" ) ) );
    }
    
}

?>