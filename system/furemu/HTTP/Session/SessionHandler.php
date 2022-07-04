<?php

namespace Yume\Kama\Obi\HTTP\Session;

use Yume\Kama\Obi\HTTP;
use Yume\Kama\Obi\Trouble;

use SessionHandler as PHPBuiltInSessionHandler;

/*
 * SessionHandler
 *
 * Just extending PHP's built-in Session Handler class.
 *
 * @package Yume\Kama\Obi\HTTP\Session
 */
final class SessionHandler extends PHPBuiltInSessionHandler
{
    
    /*
     * Session key salt.
     *
     * @access Protected
     *
     * @values String
     */
    protected String $key;
    
    /*
     * Construct method of class SessionHandler
     *
     * @access Public Instance
     *
     * @return Void
     */
    public function __construct()
    {
        if( extension_loaded( "mstring" ) === False && 
            extension_loaded( "openssl" ) === False )
        {
            throw new Trouble\ExtensionError( "Multibyte String & OpenSSL" );
        }
    }
    
    /*
     * @inherit https://www.php.net/manual/en/sessionhandler.open.php
     *
     */
    public function open( String $path, String $name ): Bool
    {
        // Get or generate random key string.
        $this->key = $this->getKey( f( "KEY_{}", $name ) );
        
        // Return value from parent::open.
        return( parent::open( $path, $name ) );
    }
    
    /*
     * @inherit https://www.php.net/manual/en/sessionhandler.read.php
     *
     */
    public function read( String $id ): String | False
    {
        // Get data from parent.
        $data = parent::read( $id );
        
        if( empty( $data ) )
        {
            return( "" );
        }
        
        // Return decoded data.
        return( $this->decode( $this->key, $data ) );
    }
    
    /*
     * @inherit https://www.php.net/manual/en/sessionhandler.write.php
     *
     */
    public function write( String $id, String $data ): Bool
    {
        return( parent::write( $id, $this->encode( $this->key, $data ) ) );
    }
    
    protected function encode( String $key, String $data ): String
    {
        // AES block size in CBC mode.
        $iv = random_bytes( 16 );
        
        // Encrypts data.
        $ct = openssl_encrypt( $data, "AES-256-CBC", mb_substr( $key, 0, 32, "8bit" ), OPENSSL_RAW_DATA, $iv );
        
        // Generate a keyed hash value using the HMAC method.
        $ha = hash_hmac( "SHA512", f( "{}{}", $iv, $ct ), mb_substr( $key, 32, Null, "8bit" ), True );
        
        // Return ALL.
        return( f( "{}{}{}", $ha, $iv, $ct ) );
    }
    
    protected function decode( String $key, String $data ): String
    {
        $ha = mb_substr( $data, 0, 32, "8bit" );
        $iv = mb_substr( $data, 32, 16, "8bit" );
        $ct = mb_substr( $data, 48, Null, "8bit" );
        
        // Generate a keyed hash value using the HMAC method.
        $he = hash_hmac( "SHA512", f( "{}{}", $iv, $ct ), mb_substr( $key, 32, Null, "8bit" ), True );
        
        // Timing attack safe string comparison.
        if( hash_equals( $ha, $he ) )
        {
            // Return description value.
            return( openssl_decrypt( $data, "AES-256-CBC", mb_substr( $key, 0, 32, "8bit" ), OPENSSL_RAW_DATA, $iv ) );
        }
        
        throw new Trouble\AuthenticationError( "Authentication failed, hash string is not equal." );
    }
    
    /*
     * Get or generate random key string.
     *
     * @access Protected
     *
     * @params String $name
     *
     * @return String
     */
    protected function getKey( String $name ): String
    {
        // Check if cookie exists.
        if( $cookie = HTTP\Cookies\Cookie::get( $name ) )
        {
            // Decodes key encoded with MIME base64.
            $key = base64_decode( $cookie->value);
        } else {
            
            // Generates cryptographically secure pseudo-random bytes.
            $key = random_bytes( 64 );
            
            // Convert pseudo-random to hexadecimal.
            $key = bin2hex( $key );
            
            // Encodes key with MIME base64.
            $enckey = base64_encode( $key );
            
            // Get the session cookie parameters.
            $cookie = session_get_cookie_params();
            
            // Cookie options.
            $options = [
                
                // Cookie domain address.
                "domain" => $cookie['domain'] !== "" ? $cookie['domain'] : Null,
                
                // Cookie expiration time.
                "expires" => $cookie['lifetime'],
                
                // Cookie path saved.
                "path" => $cookie['path'],
                
                // Cookie samesite.
                "sameSite" => $cookie['samesite'] !== "" ? $cookie['samesite'] : Null,
                
                // Cookie secure.
                "secure" => $cookie['secure'],
                
                // Cookie httponly.
                "httpOnly" => $cookie['httponly']
                
            ];
            
            // Set new cookie.
            Http\Cookies\Cookie::set( $name, $enckey, $options, True );
            
        }
        return( $key );
    }
    
}

?>