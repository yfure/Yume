<?php

namespace Yume\Kama\Obi\AoE;

use Yume\Kama\Obi\Reflector;
use Yume\Kama\Obi\Trouble;

/*
 * Utility class for strings.
 *
 * @package Yume\Kama\Obi\AoE
 */
abstract class Stringable
{
    
    /*
     * Parses any data to type string.
     *
     * @access Public Static
     *
     * @params Mixed $data
     *
     * @return String
     */
    public static function parse( Mixed $data ): String
    {
        if( $data === Null  )
        {
            return( "Null" );
        }
        if( is_bool( $data ) )
        {
            return( $data ? "True" : "False" );
        }
        if( is_array( $data ) )
        {
            return( json_encode( $data, JSON_PRETTY_PRINT ) );
        }
        if( is_callable( $data ) )
        {
            return( self::parse( Reflector\Kansu::invoke( $data ) ) );
        }
        if( is_object( $data ) )
        {
            if( $data Instanceof \Stringable )
            {
                return( $data->__toString() );
            }
            return( $data::class );
        }
        return( $data !== Null ? "{$data}" : "Null" );
    }
    
    /*
     * @inherit Function format
     *
     */
    public static function format( String $string, Mixed ...$format ): String
    {
        return( call_user_func_array( "format", func_get_args() ) );
    }
    
    /*
     * Generate random string.
     *
     * @source http://stackoverflow.com/a/13733588/
     *
     * @access Public Static
     *
     * @params Int $length
     * @params String, Null $alphabet
     *
     * @return String
     */
    public static function random( Int $length, ? String $alphabet = Null )
    {
        $token = "";
        
        if( $alphabet === Null )
        {
            $alphabet = implode( range( "a", "z" ) );
            $alphabet .= implode( range( "A", "Z" ) );
            $alphabet .= implode( range( 0, 9 ) );
        }
        
        $alphabetLength = strlen( $alphabet );
        
        for( $i = 0; $i < $length; $i++ )
        {
            $token .= $alphabet[Numberable::random( 0, $alphabetLength )];
        }
        
        return( $token );
    }
    
    public static function posLetterIs( String $string, String $letter, Int $position ): Bool
    {
        if( strlen( $string ) < $position )
        {
            throw new Trouble\IndexError( range: $position, ref: __METHOD__ );
        }
        foreach( str_split( $string ) As $pos => $let )
        {
            if( $pos === $position )
            {
                return( $let === $letter );
            }
        }
        return( False );
    }
    
    /*
     * Check if check if letter is upper or lower.
     *
     * @access Public Static
     *
     * @params String $string
     *
     * @return Bool
     */
    public static function firstLetterIsUpper( String $string ): Int | Bool
    {
        return( preg_match( "/^[\p{Lu}\x{2160}-\x{216F}]/u", $string ) );
    }
    
}

?>