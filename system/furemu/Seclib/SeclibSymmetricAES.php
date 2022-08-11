<?php

namespace Yume\Fure\Seclib;

use Yume\Fure\AoE;
use Yume\Fure\Reflector;
use Yume\Fure\Threader;

use phpseclib3\Crypt;
use Phpsrclib3\Exception;

/*
 * SeclibSymmetricAES
 *
 * @package Yume\Fure\Seclib
 */
abstract class SeclibSymmetricAES
{
    
    protected const DECRYPT = 7545;
    
    protected const ENCRYPT = 7875;
    
    /*
     * AES Class instance from phpseclib
     *
     * @access Protected Static
     *
     * @values phpseclib3\Crypt\Aes
     */
    protected static $chiper;
    
    /*
     * Decrypt encrypted data.
     *
     * @access Public Static
     *
     * @params String $data
     * @params String $iv
     * @params String $key
     * @params Array $password
     *
     * @return String|Bool
     */
    public static function decrypt( String $data, String $iv, ? String $key = Null, ? Array $password = Null ): String | Bool
    {
        return( self::catchs( $data, $iv, $key, $password, self::DECRYPT ) );
    }
    
    /*
     * Encrypt raw data.
     *
     * @access Public Static
     *
     * @params String $data
     * @params String $iv
     * @params String $key
     * @params Array $password
     *
     * @return String|Bool
     */
    public static function encrypt( String $data, String $iv, ? String $key = Null, ? Array $password = Null ): String | Bool
    {
        return( self::catchs( $data, $iv, $key, $password, self::ENCRYPT ) );
    }
    
    /*
     * Get or create new aes instance class.
     *
     * @access Public
     *
     * @return phpseclib3\Crypt\Aes
     */
    public static function chiper(): Crypt\Aes
    {
        if( self::$chiper === Null )
        {
            // Create new aes class instance.
            self::$chiper = new Crypt\Aes( Threader\App::config( "seclib.symmetric.aes.mode" ) );
            
            // Set default key length.
            self::$chiper->setKeyLength( Threader\App::config( "seclib.symmetric.aes[key.length]" ) );
            
            // Set default preferred engine.
            self::$chiper->setPreferredEngine( Threader\App::config( "seclib.symmetric.aes.engine" ) );
        }
        return( self::$chiper );
    }
    
    /*
     * Catch all phpseclib3\Exception
     *
     * @access Protected Static
     *
     * @params @inherit function
     *
     * @return Mixed
     */
    protected static function catchs( String $data, String $iv, ? String $key = Null, ? Array $password = Null, Int $flags = 0 ): Mixed
    {
        try {
            return( match( $flags )
            {
                self::DECRYPT => base64_encode( self::update( $iv, $key, $password )->encrypt( $data ) ),
                self::ENCRYPT => self::update( $iv, $key, $password )->decrypt( base64_decode( $data ) )
            });
        }
        catch( Exception\BadConfigurationException
             | Exception\BadDecryptionException
             | Exception\BadModeException
             | Exception\ConnectionClosedException
             | Exception\FileNotFoundException
             | Exception\InconsistentSetupException
             | Exception\InsufficientSetupException
             | Exception\NoKeyLoadedException
             | Exception\NoSupportedAlgorithmsException
             | Exception\UnableToConnectException
             | Exception\UnsupportedAlgorithmException
             | Exception\UnsupportedCurveException
             | Exception\UnsupportedFormatException 
             | Exception\UnsupportedOperationException $e )
        {
            throw new SeclibError( f( "Unexpected error, failed to {} data.", $flags === self::DECRYPT ? "decrypt" : "encrypt" ), 0, $e );
        }
    }
    
    /*
     * Update chiper configuration.
     *
     * @access Protected Static
     *
     * @params String $iv
     * @params String $key
     * @params Array $password
     *
     * @return phpseclib3\Crypt\Aes
     */
    protected static function update( String $iv, ? String $key = Null, ? Array $password = Null ): Crypt\Aes
    {
        // Get chiper instance class.
        $chiper = self::chiper();
        
        // Set new iv for aes.
        $chiper->setIV( $iv );
        
        // If chiper has no password key will automate setup.
        if( $password === Null )
        {
            // Set new key for chiper.
            $chiper->setKey( $key );
        } else {
            
            // Set new password for chiper.
            Reflector\ReflectMethod::invoke( $chiper, "setPassword", $password );
        }
        return( $chiper );
    }
    
}

?>