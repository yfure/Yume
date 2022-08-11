<?php

namespace Yume\Fure\AoE\ITraits;

use Yume\Fure\IO;
use Yume\Fure\Error;

/*
 * Package
 *
 * @package Yume\Fure\AoE\Traits
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
    public static function import( String $file, Bool $isPHPFile = True ): Mixed
    {
        // Create new filename.
        $fname = $isPHPFile ? f( "{}{}", $file, substr( $file, -4 ) !== ".php" ? ".php" : "" ) : $file;
        
        // Check if the file exists.
        if( IO\File::exists( $fname ) )
        {
            // Return value back from file.
            return( require( path( $fname ) ) );
        }
        
        throw new Error\ModuleNotFoundError( $file, Error\ModuleNotFoundError::NAME );
    }
    
}

?>