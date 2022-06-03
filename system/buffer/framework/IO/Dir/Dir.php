<?php

namespace Yume\Kama\Obi\IO\Dir;

use function Yume\Func\ls;
use function Yume\Func\path;

abstract class Dir
{
    
    /*
     * Scan the directory from the specified root to the very bottom though.
     *
     * @access Public, Static
     *
     * @params String <path>
     * @params String <file>
     *
     * @return Array
     */
    public static function tree( String $path, Bool $file = True ): Array
    {
        
        $result = [];
        
        // List directory.
        $ls = ls( $path );
        
        if( $ls !== Null )
        {
            foreach( $ls As $dir )
            {
                if( $dir !== "vendor" )
                {
                    
                    // File is directory.
                    if( is_dir( path( base: "$path/$dir" ) ) )
                    {
                        // Loop scanning.
                        $result[$dir] = self::tree( "$path/$dir", $file );
                    } else {
                        
                        // If file is allowed.
                        if( $file )
                        {
                            $result[] = $dir;
                        }
                    }
                } else {
                    $result[$dir] = [];
                }
                
            }
        }
        
        return( $result );
    }
    
}

?>