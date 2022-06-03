<?php

namespace Yume\Func;

function tree( String $path, Bool $f = True ): Array
{
    $result = [];
    
    // List Value.
    $ls = ls( $path );
    
    if( $ls !== Null )
    {
        foreach( $ls As $file )
        {
            if( $file !== "vendor" )
            {
                if( is_dir( path( base: "$path/$file" ) ) )
                {
                    $result[$file] = tree( "$path/$file", $f );
                } else {
                    $result[] = $file;
                }
            } else {
                $result[$file] = [];
            }
        }
    }
    return( $result );
}

?>