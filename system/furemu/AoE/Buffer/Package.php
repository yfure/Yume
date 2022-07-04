<?php

namespace Yume\Kama\Obi\AoE\Buffer;

use Yume\Kama\Obi\IO;
use Yume\Kama\Obi\Trouble;

/*
 * Package
 *
 * @package Yume\Kama\Obi\AoE\Traits
 */
trait Package
{
    
    /*
     * Explodes the class name.
     *
     * @access Public Static
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
    
    /*
     * Import single file php
     *
     * @access Public Static
     *
     * @params String $file
     *
     * @return Mixed
     */
    public static function import( String $file ): Mixed
    {
        // Create new filename.
        $fname = f( "{}{}", $file, substr( $file, -4 ) !== ".php" ? ".php" : "" );
        
        // Check if the file exists.
        if( IO\File::exists( $fname ) )
        {
            // Return value back from file.
            return( require( path( $fname ) ) );
        }
        
        throw new Trouble\ModuleNotFoundError( $file, ModuleNotFoundError::NAME );
    }
    
}

?>