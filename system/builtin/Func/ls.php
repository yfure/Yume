<?php

namespace Yume\Func;

/*
 * Lisy directory contents.
 *
 * @params String <dir>
 *
 * @return Array, Null
 */
function ls( String $dir ): Array | Null
{
    if( is_dir( path( base: $dir ) ) )
    {
        // Scanning directory.
        $scan = scandir( path( base: $dir ) );
        
        // Computes the difference of arrays.
        $scan = array_diff( $scan, [ ".", ".." ] );
        
        // Sort an array by key in ascending order.
        ksort( $scan );
        
        return( $scan );
    }
    return Null;
}

?>