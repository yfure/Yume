<?php

namespace Yume\Func;

use Yume\Kama\Obi;

function replace( Array $tree, Array $replace, String $parent = "" )
{
    foreach( $tree As $key => $val )
    {
        if( is_array( $val ) )
        {
            replace( $val, $replace, format( "{}/{}", $parent, $key ) );
        } else {
            
            $file = format( "{}/{}", $parent, $val );
            
            if( substr( $file, -4 ) === ".php" )
            {
                if( count( $replace ) !== 0 )
                {
                    
                    $fget = file_get_contents( path( $file ) );
                    
                    $frep = $fget;
                    
                    foreach( $replace As $from => $to )
                    {
                        $frep = str_replace( $from, $to, $frep );
                    }
                    
                    if( $fget !== $frep )
                    {
                        $fput = file_put_contents( path( $file ), $frep );
                    }
                    
                }
            }
        }
    }
}

function replaceF( Array $replace, String $file )
{

}

?>