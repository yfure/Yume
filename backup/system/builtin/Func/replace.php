<?php

namespace Yume\Func;

use Yume\Kama\Obi;

function replace( Array $tree, Array $replace, String $parent = "" )
{
    foreach( $tree As $key => $val )
    {
        if( is_array( $val ) )
        {
            replace( $val, $replace, "$parent/$key" );
        } else {
            replaceF( $replace, "$parent/$val" );
        }
    }
}

function replaceF( Array $replace, String $file )
{
    if( substr( $file, -4 ) === ".php" )
    {
        if( count( $replace ) !== 0 )
        {
            
            $fget = file_get_contents( path( base: $file ) );
            
            $frep = $fget;
            
            foreach( $replace As $from => $to )
            {
                $frep = str_replace( $from, $to, $frep );
            }
            
            if( $fget !== $frep )
            {
                $fput = file_put_contents( path( base: $file ), $frep );
            }
            
        }
    }
}

?>