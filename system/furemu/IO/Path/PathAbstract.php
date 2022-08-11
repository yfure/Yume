<?php

namespace Yume\Fure\IO\Path;

/*
 * Directory
 *
 * @package Yume\Fure\IO
 */
abstract class PathAbstract
{
    
    /*
     * Tells whether the filename is a directory.
     *
     * @access Public Static
     *
     * @params String $dir
     *
     * @return Bool
     */
    public static function exists( String $dir ): Bool
    {
        return( is_dir( path( $dir ) ) );
    }
    
    /*
     * List directory contents.
     *
     * @access Public Static
     *
     * @params String $dir
     *
     * @return Array|Bool
     */
    public static function ls( String $path ): Array | Bool
    {
        if( self::exists( $path ) )
        {
            // Scanning directory.
            $scan = scandir( path( $path ) );
            
            // Computes the difference of arrays.
            $scan = array_diff( $scan, [ ".", ".." ] );
            
            // Sort an array by key in ascending order.
            ksort( $scan );
            
            return( $scan );
        }
        return( False );
    }
    
    /*
     * Create new directory.
     *
     * @access Public Static
     *
     * @params String $path
     *
     * @return Void
     */
    public static function mkdir( String $path ): Void
    {
        // Directory stack.
        $stack = "";
        
        // Mapping dir.
        array_map( array: explode( "/", $path ), callback: function( $dir ) use( &$stack )
        {
            // Check if directory is exists.
            if( self::exists( $stack = f( "{}{}/", $stack, $dir ) ) === False )
            {
                // Create new directory.
                mkdir( path( $stack ) );
            }
        });
    }
    
    /*
     * Create tree directory structure.
     *
     * @access Public Static
     *
     * @params String $path
     * @params String $parent
     *
     * @return Array|False
     */
    public static function tree( String $path, String $parent = "" ): Array | False
    {
        if( self::exists( $path ) )
        {
            $tree = [];
            $scan = self::ls( $path );
            
            foreach( $scan As $i => $file )
            {
                if( $file === "vendor" || $file === ".git" )
                {
                    continue;
                }
                if( $rscan = self::tree( f( "{}/{}", $path, $file ) ) )
                {
                    $tree[$file] = $rscan;
                } else {
                    $tree[] = $file;
                }
            }
            return( $tree );
        }
        return( False );
    }
    
}

?>