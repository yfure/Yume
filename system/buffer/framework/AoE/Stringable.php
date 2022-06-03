<?php

namespace Yume\Kama\Obi\AoE;

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
     * @access Public, Static
     *
     * @params Mixed <data>
     *
     * @return String
     */
    public static function parse( Mixed $data ): String
    {
        if( $data !== Null )
        {
            if( is_bool( $data ) )
            {
                $data = $data ? "True" : "False";
            }
            if( is_array( $data ) )
            {
                $data = json_encode( $data/*, JSON_PRETTY_PRINT*/ );
            }
            if( is_callable( $data ) )
            {
                $data = self::parse( Reflection\ReflectionFunction::invoke( $data ) );
            }
            if( is_object( $data ) )
            {
                if( $data Instanceof \Stringable )
                {
                    return( $data->__toString() );
                }
                return( $data::class );
            }
            return( "{$data}" );
        }
        return( "Null" );
    }
    
    /*
     * Generate random string.
     *
     * @source http://stackoverflow.com/a/13733588/
     *
     * @access Public, Static
     *
     * @params Int <length>
     * @params String, Null <alphabet>
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
    
}

?>