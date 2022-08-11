<?php

namespace Yume\Fure\AoE;

use Yume\Fure\Error;
use Yume\Fure\JSON;
use Yume\Fure\Reflector;
use Yume\Fure\RegExp;

use Stringable;
use ArrayAccess;

/*
 * Stringer
 *
 * @package Yume\Fure\AoE
 */
abstract class Stringer
{
    
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
    
    /*
     * String formater.
     *
     * @params String $string
     * @params Mixed $format
     *
     * @return String
     */
    public static function format( String $string, Mixed ...$format ): String
    {
        // Check if first index of array is exists.
        if( isset( $format[0] ) )
        {
            // If first index of array is array.
            if( is_array( $format[0] ) || $format[0] Instanceof ArrayAccess )
            {
                $format = $format[0];
            }
        }
        
        // Replacing string based on index or key name.
        return( RegExp\RegExp::replace( "/(?:(?<F>\{[\s]*(?<Name>([a-zA-Z_\x80-\xff][a-zA-Z0-9_\.\x80-\xff]*[a-zA-Z0-9_\x80-\xff])|([\d]+))[\s]*\}|\{[\s]*\}))/i", $string, function( $matchs ) use( $string, $format )
        {
            // Statically variable.
            static $i = 0;
            
            // If format key name based on key name.
            if( isset( $matchs['Name'] ) )
            {
                // Check if format key name is exists.
                if( isset( $format[$matchs['Name']] ) )
                {
                    return( self::parse( $format[$matchs['Name']] ) );
                }
                throw new Error\KeyError( $matchs['Name'] );
            } else {
                
                // Check if index array is exists.
                if( isset( $format[$i] ) )
                {
                    return( self::parse( $format[$i++] ) );
                }
                throw new Error\IndexError( $i++ );
            }
        }));
    }
    
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
        // If data is null type.
        if( $data === Null  )
        {
            $data = "None";
        } else {
            switch( ucfirst( gettype( $data ) ) )
            {
                case "Bool":
                    
                    // Parse boolean tyoe into string.
                    $data = $data === True ? "True" : "False"; break;
                    
                case "Array":
                    
                    // Parse array into json string.
                    $data = JSON\JSON::encode( $data, JSON_PRETTY_PRINT ); break;
                    
                case "Object":
                    
                    // Check if object is callable type.
                    if( is_callable( $data ) )
                    {
                        $data = self::parse( Reflector\ReflectFunction::invoke( $data ) );
                    } else {
                        
                        // Check if object is stringable.
                        if( $data Instanceof Stringable )
                        {
                            // Parse object into string.
                            $data = $data->__toString();
                        } else {
                            
                            // Only get object class name.
                            $data = $data::class;
                        }
                    }
                    break;
                    
                default: break;
            }
        }
        return( $data );
    }
    
    /*
     * Remove last string with separator.
     *
     * @access Public Static
     *
     * @params String $subject
     * @params String $separator
     *
     * @return String
     */
    public static function pop( String $subject, String $separator ): String
    {
        // Split string with separator.
        $split = explode( $separator, $subject );
        
        // Remove last array ellement.
        array_pop( $split );
        
        // Join array elements with a string.
        return( $subject = implode( $separator, $split ) );
    }
    
    /*
     * Check index string letter charackter.
     *
     * @access Public Static
     *
     * @params ...
     *
     * @return Bool
     */
    public static function posLetterIs( String $string, String $letter, Int $position ): Bool
    {
        if( strlen( $string ) < $position )
        {
            throw new Error\IndexError( $position );
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
     * Generate random string.
     *
     * @source http://stackoverflow.com/a/13733588/
     *
     * @access Public Static
     *
     * @params Int $length
     * @params String $alphabet
     *
     * @return String
     */
    public static function random( Int $length, ? String $alphabet = Null )
    {
        // Token result stack.
        $token = "";
        
        // Check if alphabet is null type.
        if( $alphabet === Null )
        {
            // Generate random alphabet.
            $alphabet = self::format( "{}{}{}", [
                implode( range( "a", "z" ) ),
                implode( range( "A", "Z" ) ),
                implode( range( 0, 9 ) )
            ]);
        }
        
        // Get alphabet length.
        $alphabetLength = strlen( $alphabet );
        
        for( $i = 0; $i < $length; $i++ )
        {
            // Get alphabet based on randomable number.
            $token .= $alphabet[Numerator::random( 0, $alphabetLength )];
        }
        
        return( $token );
    }
    
}

?>