<?php

namespace Yume\Kama\Obi\IO;

abstract class File
{
    
    public static function exists( String $file ): Bool
    {
        return( file_exists( path( $file ) ) );
    }
    
}

?>