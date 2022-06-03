<?php

namespace Yume\Kama\Obi\AoE;



abstract class Arrayable
{
    
    /*
     * Retrieve element values using dot as array separator.
     *
     * @access Public, Static
     *
     * @params Array, String <str>
     * @params Array <arr>
     *
     * @return Mixed
     */
    public static function ify( Array | String $str, Array | DataInterface $arr ): Mixed
    {
        return( ify( $str, $arr ) );
    }
    
    public static function insert( Int | Array | String $position, Array $array, Mixed $value ): Array
    {
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
                    } else {
                        
                        // If position is more than number of array.
                        if( is_int( $position ) && count( $array ) < $position + 1 || is_array( $position ) && count( $array ) < $position[0] + 1 )
                        {
                            $copy[ is_int( $position ) ? $i -1 : $position[1] ] = $value;
                            
                            // Add next queue.
                            foreach( $array As $k => $v )
                            {
                                $copy[ is_int( $k ) ? $k + 1 : $k ] = $v;
                            }
                        } else {
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