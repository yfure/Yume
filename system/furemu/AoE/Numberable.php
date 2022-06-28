<?php

namespace Yume\Kama\Obi\AoE;

use Yume\Kama\Obi\RegExp;

abstract class Numberable
{
    
    public static function is( String $ref ): Bool
    {
        return( RegExp\RegExp::test( "/^(?:\d+)$/", $ref ) );
    }
    
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
    
    public static function length( Int $length )
    {
        
        $string = "";
        $arrays = [];
        
        // Generate random bytes and convert to hexadecimal.
        $random = bin2hex( random_bytes( $length / 2 ) );
        
        for( $i = 0; $i < strlen( $random ); $i++ )
        {
            $arrays[] = hexdec( $random[$i] . $i ) * hexdec( $random[$i] );
        }
        
        // Cut the string according to the length value.
        $string = substr( implode( "", $arrays ), 0, $length );
        
        return( $string );
    }
    
    public static function parse( String $string ): Bool | String
    {
        if( Http\RegExp::match( "/^[a-f0-9]+$/", $string ) )
        {
            $array = [];
            
            for( $i = 0; $i < strlen( $string ); $i++ )
            {
                $array[] = hexdec( $string[$i] );
            }
            return( implode( "", $array ) );
        }
        return( False );
    }
    
}

?>