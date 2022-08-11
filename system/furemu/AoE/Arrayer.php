<?php

namespace Yume\Fure\AoE;

use Yume\Fure\Error;
use Yume\Fure\RegExp;

use ArrayAccess;

/*
 * Arrayer
 *
 * @package Yume\Fure\AoE
 */
abstract class Arrayer
{
    
    /*
     * Retrieve element values using dot as array separator.
     *
     * @params Array|String $refs
     * @params Array|ArrayAccess $data
     *
     * @return Mixed
     */
    public static function ify( Array | String $refs, Array | ArrayAccess $data ): Mixed
    {
        if( is_string( $refs ) )
        {
            // Encodes each character inside [].
            $refs = RegExp\RegExp::replace( "/(?:\[([^\]]*)\])/", $refs, fn( $m ) => f( ".b64_{}", base64_encode( $m[1] ) ) );
            
            // Split string with period.
            $refs = explode( ".", $refs );
        }
        
        foreach( $refs As $key )
        {
            // Checks if the character contains only numbers.
            if( Numerator::is( $key ) )
            {
                // Parse string to int.
                $key = ( Int ) $key;
            } else {
                
                if( $key === "" )
                {
                    continue;
                }
                
                // Checks if the string is encoded text.
                if( RegExp\RegExp::test( "/^(?:b64_.*?)$/", $key ) )
                {
                    // Decode BASE64 strings.
                    $key = RegExp\RegExp::replace( "/^(?:b64_(.*?))$/", $key, fn( $m ) => base64_decode( $m[1] ) );
                }
            }
            
            // Check if stack variable is exists.
            if( isset( $stack ) )
            {
                // If key or index is exists.
                if( isset( $stack[$key] ) )
                {
                    $stack = $stack[$key];
                } else {
                    throw is_string( $key ) ? new Error\KeyError( $key ) : new Error\IndexError( $key );
                }
            } else {
                
                // If key or index is exists.
                if( isset( $data[$key] ) )
                {
                    $stack = $data[$key];
                } else {
                    throw is_string( $key ) ? new Error\KeyError( $key ) : new Error\IndexError( $key );
                }
            }
        }
        return( $stack );
    }
    
    /*
     * Push array any position.
     *
     * @access Public Static
     *
     * @params Array|Int|String $position
     * @params Array $array
     * @params Mixed $value
     *
     * @return Array
     */
    public static function insert( Int | Array | String $position, Array $array, Mixed $value ): Array
    {
        // Iteration start.
        $i = 0;
        
        // If the array is empty with no contents.
        if( count( $array ) === 0 )
        {
            $array[$position] = $value;
        } else {
            
            // If position string then this will overwrite the existing value.
            if( is_string( $position ) )
            {
                $array[$position] = $value;
            } else {
                
                $copy = [];
                
                // To avoid stacking values, unset the array if it exists.
                if( is_array( $position ) )
                {
                    unset( $array[$position[1]] );
                }
                
                foreach( $array As $key => $val )
                {
                    $i++;
                    
                    // If the array position is the same.
                    if( is_int( $position ) && $i -1 === $position || is_array( $position ) && $i -1 === $position[0] )
                    {
                        $copy[ is_int( $position ) ? $i -1 : $position[1] ] = $value;
                        
                        // Add next queue.
                        foreach( $array As $k => $v )
                        {
                            $copy[ is_int( $k ) ? $k + 1 : $k ] = $v;
                        }
                        break;
                    }
                    else {
                        
                        // If position is more than number of array.
                        if( is_int( $position ) && count( $array ) < $position + 1 || is_array( $position ) && count( $array ) < $position[0] + 1 )
                        {
                            $copy[ is_int( $position ) ? $i -1 : $position[1] ] = $value;
                            
                            // Add next queue.
                            foreach( $array As $k => $v )
                            {
                                $copy[ is_int( $k ) ? $k + 1 : $k ] = $v;
                            }
                        }
                        else {
                            $copy[$key] = $val;
                        }
                    }
                }
                
                $array = $copy;
                
            }
        }
        
        return( $array );
    }
    
}

?>