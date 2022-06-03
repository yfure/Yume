<?php

namespace Yume\Kama\Obi\AoE;

abstract class Numberable
{
    
    /*
     * Generate random int.
     *
     * @source http://stackoverflow.com/a/13733588/
     *
     * @access Public, Static
     *
     * @params Int <min>
     * @params Int <max>
     *
     * @return Int
     */
    public static function random( Int $min, Int $max )
    {
        // Not so random...
        if( ( $range = $max - $min ) < 0 )
        {
            return $min;
        }
        
        // Length in bytes.
        ( $bytes = ( Int ) ( ( $log = log( $range, 2 ) ) / 8 ) + 1 );
        
        // Set all lower bits to 1.
        ( $filter = ( Int ) ( 1 << ( $bits = ( Int ) $log + 1 ) ) - 1 );
        
        do {
            
            $rnd = $bytes;
            $rnd = openssl_random_pseudo_bytes( $rnd );
            $rnd = bin2hex( $rnd );
            $rnd = hexdec( $rnd );
            
            // Discard irrelevant bits.
            $rnd = $rnd & $filter;
            
        } while( $rnd >= $range );
        
        return( $min + $rnd );
    }
    
}

?>