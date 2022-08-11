<?php

namespace Yume\Fure\AoE;

use Yume\Fure\IO;
use Yume\Fure\RegExp;

/*
 * Replacer
 *
 * @package Yume\Fure\AoE
 */
final class Replacer
{
    
    public static function execute( Callable | Int $handler ): Void
    {
        self::loop( $handler, tree( "/" ), "" ); exit;
    }
    
    /*
     * Looping arrays.
     *
     * @access Public Static
     *
     * @params Array $array
     * @params String $in
     *
     * @return Void
     */
    public static function loop( Callable $handler, Array $array, String $in = "" )
    {
        // Eaching arrays.
        foreach( $array As $path => $files )
        {
            // If the folder has a lot of content.
            if( is_array( $files ) )
            {
                if( $path !== "vendor" && $path !== ".git" && $path !== "_" )
                {
                    // Repeat again.
                    self::loop( $handler, $files, str_replace( "//", "/", f( "{}/{}", $in, $path ) ) );
                }
            } else {
                
                // Create file name.
                $fname = str_replace( "//", "/", f( "{}/{}", $in, $file = $files ) );
                
                // Check if file name is directory.
                if( IO\Path::exists( $fname ) )
                {
                    continue;
                }
                
                // Get file contents.
                $fdata = IO\File::read( $fname );
                
                // Call handler function.
                $handler( $fname, $fdata );
            }
        }
    }
}

?>