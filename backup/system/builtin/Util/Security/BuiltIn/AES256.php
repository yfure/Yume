<?php

namespace Yume\Kama\Obi\Security\BuiltIn;

/*
 * Add encryption to internal PHP save handlers.
 *
 * @see https://www.php.net/manual/en/class.sessionhandler.php
 */
abstract class AES256
{
    /*
     * Encrypt AES256
     *
     * @access Public, Static
     *
     * @params Data <data>
     * @params String <password>
     *
     * @return StringEncrypted
     */
    public static function encrypt( $data, $password )
    {
        // Generate a pseudo-random string of bytes.
        $salt = openssl_random_pseudo_bytes( 16 );
        
        $salted = "";
        $dx = "";
        
        // Salt the key( 32 ) and iv( 16 ) = 48
        while( strlen( $salted ) < 48 ) {
            
            $dx = hash( "sha256", $dx . $password . $salt, True );
            $salted .= $dx;
        }
        
        // Get part of a string.
        $key = substr( $salted, 0, 32 );
        $iv  = substr( $salted, 32, 16 );
        
        // Encrypt data using openssl encrypt.
        return( base64_encode( $salt . openssl_encrypt( $data, "AES-256-CBC", $key, True, $iv ) ) );
    }
    
    /*
     * Decrypt AES256
     *
     * @access Public, Static
     *
     * @param Data <edata>
     * @param String <password>
     *
     * @return StringDecrypted
     */
    public static function decrypt( $edata, $password )
    {
        // Encodes data with MIME base64.
        $data = base64_decode( $edata );
        
        // Get part of a string.
        $salt = substr( $data, 0, 16 );
        $ct = substr( $data, 16 );
        
        // depends on key length.
        $rounds = 3;
        $data00 = $password . $salt;
        $hash = [];
        $hash[0] = hash( "sha256", $data00, True );
        $result = $hash[0];
        
        for( $i = 1; $i < $rounds; $i++ ) {
            $hash[$i] = hash( "sha256", $hash[($i - 1)] . $data00, True );
            $result .= $hash[$i];
        }
        
        // Get part of a string.
        $key = substr( $result, 0, 32 );
        $iv  = substr( $result, 32, 16 );
        
        // Decrypt data using openssl decrypt.
        return( openssl_decrypt( $ct, "AES-256-CBC", $key, True, $iv ) );
    }
}

?>