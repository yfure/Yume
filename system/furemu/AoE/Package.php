<?php

namespace Yume\Kama\Obi\AoE;

use Yume\Kama\Obi\IO;
use Yume\Kama\Obi\Trouble;

abstract class Package
{
    
    public static function import( String $file ): Mixed
    {
        $fname = f( "{}{}", $file, substr( $file, -4 ) !== ".php" ? ".php" : "" );
        
        if( IO\File::exists( $fname ) )
        {
            return( require( path( $fname ) ) );
        }
        throw new Trouble\ModuleNotFoundError( $file, ModuleNotFoundError::NAME );
    }
    
}

?>