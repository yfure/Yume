<?php

namespace Yume\Kama\Obi\AoE\Traits;

/*
 * Package
 *
 * Explodes the class name.
 *
 * @package Yume\Kama\Obi\AoE\Traits
 */
trait Package
{
    
    /*
     * Explodes the class name.
     *
     * @access Public: Static
     *
     * @params String $class
     *
     * @return String
     */
    public static function name( ? String $class = Null ): String
    {
        if( $class === Null )
        {
            // Use the default class name.
            $class = self::class;
        }
        
        // Explode class name.
        $expld = explode( "\\", $class );
        
        // Return the last value of the array.
        return( array_pop( $expld ) );
    }
    
}

?>