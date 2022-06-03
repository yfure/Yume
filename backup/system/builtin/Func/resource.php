<?php

namespace Yume\Func;

function resource( String $resource ): Mixed
{
    // ....
    $substr = substr( $resource, -4 );
    
    if( $substr === ".php" ) {
        if( file_exists( $f = resourcePath( $resource ) ) ) {
            
            // Return given value from resource.
            return( require( $f ) );
        }
    } else {
        
        // Pattern for deleting comments that are in a resource.
        $pattern = "/#![-|.|y]\s[^\n]+\n*|\/\!.*?!\//s";
        
        // Check if the resource exists or not.
        if( file_exists( $f = path( resource: $resource ) ) ) {
            
            return preg_replace( $pattern, "", file_get_contents( $f ) );
        }
    }
    return False;
}

function resourceReplace( String $subject, ?Callable $callback = Null ): String
{
    // ..
    if( $callback === Null ) {
        $callback = function( $m ) {
            
            // Get resource value or resource file path.
            return( $m[1] === "*"? path( resource: $m[2] ) : ( ( $r = resource( $m[2] ) ) !== False? $r : "" ) );
        };
    }
    
    // Pattern to replace string with resource.
    $pattern = "/re([\*]*){\s*([^\s*}]+)\s*}/";
    
    // Replace string according to pattern with resource value.
    return preg_replace_callback( pattern: $pattern, subject: $subject, callback: $callback );
}

?>